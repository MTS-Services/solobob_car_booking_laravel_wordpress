<?php
namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Booking;
use App\Models\BookingStatusTimeline;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout(
    'app',
    [
        'title' => 'Order Details',
        'breadcrumb' => 'Order Details',
        'page_slug' => 'order-management'
    ]
)]
class OrderDetails extends Component
{
    public $detailsOrder;
    public $showModal = false;
    public $reason;

    public function mount($id)
    {
        // Load booking with all relationships through bookingRelation
        $this->detailsOrder = Booking::with([
            'auditor',
            'user',
            'vehicle.images',
            'vehicle.relations.make',
            'vehicle.relations.model',
            'vehicle.category',
            'pickupLocation',
            'relation',
            'billingInformation',
            'residentialAddress',
            'parkingAddress',
            'userDocument',
            'timeline.createdBy',
            'createdBy',
            'updatedBy',
            'deletedBy'
        ])->findOrFail($id);
    }

    public function acceptOrder()
    {
        DB::beginTransaction();
        try {
            $order = Booking::findOrFail($this->detailsOrder->id);
            
            $isUpdated = $order->update([
                'booking_status' => Booking::BOOKING_STATUS_ACCEPTED,
                'audit_by' => user()->id,
            ]);

            if (!$isUpdated) {
                DB::rollBack();
                session()->flash('error', 'Operation failed. Something went wrong!');
                return;
            }

            // Create timeline entry
            BookingStatusTimeline::create([
                'booking_id' => $order->id,
                'booking_status' => Booking::BOOKING_STATUS_ACCEPTED,
                'created_by' => user()->id,
            ]);

            DB::commit();
            session()->flash('success', 'Order accepted successfully!');
            $this->mount($this->detailsOrder->id);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Operation failed: ' . $e->getMessage());
        }
    }

    public function openRejectModal()
    {
        $this->showModal = true;
        $this->reason = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reason = '';
        $this->resetValidation();
    }

    public function saveRejection()
    {
        $this->validate([
            'reason' => 'required|string|min:10|max:500'
        ]);

        DB::beginTransaction();
        try {
            $order = Booking::findOrFail($this->detailsOrder->id);
            
            $isUpdated = $order->update([
                'booking_status' => Booking::BOOKING_STATUS_REJECTED,
                'reason' => $this->reason,
                'audit_by' => user()->id,
            ]);
            
            if (!$isUpdated) {
                DB::rollBack();
                session()->flash('error', 'Operation failed. Something went wrong!');
                return;
            }

            // Create timeline entry
            BookingStatusTimeline::create([
                'booking_id' => $order->id,
                'booking_status' => Booking::BOOKING_STATUS_REJECTED,
                'created_by' => user()->id,
            ]);

            DB::commit();
            session()->flash('success', 'Order rejected successfully!');
            $this->showModal = false;
            $this->mount($this->detailsOrder->id);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Operation failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.order-management.order-details');
    }
}