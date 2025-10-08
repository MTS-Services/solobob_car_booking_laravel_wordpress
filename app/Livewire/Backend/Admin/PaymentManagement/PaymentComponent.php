<?php

namespace App\Livewire\Backend\Admin\PaymentManagement;

use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\Url;



#[Layout(
    'app',
    [
        'title' => 'Payments',
        'breadcrumb' => 'Payments',
        'page_slug' => 'payments',
    ]
)]
class PaymentComponent extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $status = '';

    #[Url]
    public $paymentMethod = '';

    public $showDetailsModal = false;
    public $detailsPayment = null;

    public $sortField;

    public function mount() {
        // 
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPaymentMethod()
    {
        $this->resetPage();
    }

    public function render()
    {
        $payments = Payment::query()
            ->with(['booking', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', '%' . $this->search . '%')
                        ->orWhere('amount', 'like', '%' . $this->search . '%')
                        ->orWhere('note', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->paymentMethod !== '', function ($query) {
                $query->where('payment_method', $this->paymentMethod);
            })
            ->latest()
            ->paginate(10);

        $columns = [
             ['key' => 'booking_id', 'label' => 'Booking Referece', 'width' => '20%', 'format' => function($v) {
                $url = route('admin.om.details', $v->booking_id);
             return "<a href='{$url}' wire:navigate>View Booking</a>";
             }],
             
             ['key' => 'type', 'label' => 'Payment Type', 'width' => '20%', 'format' => function($payments){
                return $payments->getTypeLabelAttribute();
             }],
             ['key' => 'status', 'label' => 'Payment Status', 'width' => '20%', 'format' => function($payments){
                return $payments->getStatusLabelAttribute();
             }],
             ['key' => 'amount', 'label' => 'Amount', 'width' => '20%', 'format' => function($payments){
                return '$'. $payments->amount_formatted;
             }],
        ];
        $actions = [
             ['key' => 'id', 'label' => 'View', 'route' => 'admin.deposit.detail'],
        ];

        return view('livewire.backend.admin.payment-component', [
            'items' => $payments,
            'columns'=> $columns,
            'actions'=> $actions
        ]);
    }
}
