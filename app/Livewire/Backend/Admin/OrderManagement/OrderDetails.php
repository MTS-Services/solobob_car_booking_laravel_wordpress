<?php

namespace App\Livewire\Backend\Admin\OrderManagement;

use App\Models\Booking;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.admin.order-management.order-details',
        'breadcrumb' => 'livewire.backend.admin.order-management.order-details',
        'page_slug' => 'deposit-management'
    ]
)]

class OrderDetails extends Component
{
    public $detailsOrder;
    public $search = false;
    public $showModal = false;

    public function mount($id){

        $this->detailsOrder = Booking::withTrashed()->findOrFail($id);
    }
    public function accpetOrder(){
       
       $order =  Booking::findOrFail($this->detailsOrder->id);
        
       $isUpdated = $order->update(
        [
            'booking_status'    => Booking::BOOKING_STATUS_ACCEPTED,
        ]
         );

        if(! $isUpdated)   {
            session()->flash('message', 'Operation failed something went wrong !!');
         
        }
        session()->flash('message', 'Operation successfully completed');
       
        $this->mount($this->detailsOrder->id);

    }

    public function openRejectModal(){
        $this->showModal = true;
    }

    public function closeModal(){
        $this->showModal= false; 
    }

    public $reason; 
    public function saveRejection(){

        $this->validate([
            'reason'    =>'required'
        ]);

        $order =  Booking::findOrFail($this->detailsOrder->id);
        
       $isUpdated = $order->update(
        [
            'booking_status'    => 6,
            'reason'    => $this->reason,
        ]
         );
        
        if(! $isUpdated)   {
            session()->flash('message', 'Operation failed something went wrong !!');
         
        }
        session()->flash('message', 'Operation successfully completed');
       
        $this->showModal = false;


        $this->mount(encrypt($this->detailsOrder->id));

    }
    public function render()
    {
        return view('livewire.backend.admin.order-management.order-details');
    }
}
