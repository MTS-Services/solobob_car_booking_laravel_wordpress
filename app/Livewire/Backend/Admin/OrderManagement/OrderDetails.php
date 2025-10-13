<?php
namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Booking;
use App\Models\BookingStatusTimeline;
use App\Mail\BookingAccepted;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

            // Send email to user
            try {
                Mail::to($order->user->email)->send(new BookingAccepted($order));
                
                Log::info('Booking accepted email sent', [
                    'booking_id' => $order->id,
                    'booking_reference' => $order->booking_reference,
                    'user_email' => $order->user->email
                ]);
            } catch (\Exception $mailException) {
                // Log the error but don't fail the transaction
                Log::error('Failed to send booking accepted email', [
                    'booking_id' => $order->id,
                    'error' => $mailException->getMessage()
                ]);
                
                // Still commit the transaction, just notify about email failure
                session()->flash('warning', 'Order accepted successfully, but failed to send confirmation email.');
            }

            DB::commit();
            session()->flash('success', 'Order accepted successfully! Confirmation email sent to customer.');
            $this->mount($this->detailsOrder->id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to accept order', [
                'booking_id' => $this->detailsOrder->id,
                'error' => $e->getMessage()
            ]);
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