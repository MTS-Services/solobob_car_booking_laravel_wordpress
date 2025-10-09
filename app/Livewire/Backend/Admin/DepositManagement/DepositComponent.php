<?php

namespace App\Livewire\Backend\Admin\DepositManagement;

use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'Deposit Management',
        'breadcrumb' => 'Deposit Management',
        'page_slug' => 'deposit-management'
    ]
)]
class DepositComponent extends Component
{
    public $search = '';
    public function render()
    {
        
        $deposits = Payment::query()
        ->where('type', Payment::TYPE_DEPOSIT)
            ->with(['booking', 'user',])
            ->latest()
            ->paginate(10);
            
        $columns = [
             ['key' => 'booking_id', 'label' => 'Booking Referece', 'width' => '20%', 'format' =>function($deposits){
                return $deposits->booking->booking_reference ;
             }],
             
             ['key' => 'type', 'label' => 'Payment Type', 'width' => '20%', 'format' => function($deposits){
                return $deposits->getTypeLabelAttribute();
             }],
             ['key' => 'status', 'label' => 'Payment Status', 'width' => '20%', 'format' => function($deposits){
                return $deposits->getStatusLabelAttribute();
             }],
             ['key' => 'amount', 'label' => 'Amount', 'width' => '20%', 'format' => function($deposits){
                return '$'. $deposits->amount;
             }],
        ];
        $actions = [
             ['key' => 'id', 'label' => 'View', 'route' => 'admin.deposit.detail'],
        ];
        return view('livewire.backend.admin.deposit-management.deposit-component',compact(
            'deposits',
            'columns',
            'actions',
        ));
    }
}
