<?php

namespace App\Livewire\Backend\User;

use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.backend.user.deposit',
        'breadcrumb' => 'livewire.backend.user.deposit',
        'page_slug' => 'livewire.backend.user.deposit'
    ]
)]
class Deposit extends Component
{

    public function render()
    {


        $deposits = Payment::query()->self()
                                    ->where('type', Payment::TYPE_DEPOSIT)
                                    ->latest()
                                    ->get();
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
             ['key' => 'id', 'label' => 'View', 'route' => 'user.deposit.detail'],
        ];

        return view('livewire.backend.user.deposit', compact(
            'deposits',
            'columns',
            'actions'
        ));
    }
}
