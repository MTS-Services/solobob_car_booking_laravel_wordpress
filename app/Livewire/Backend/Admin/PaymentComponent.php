<?php

namespace App\Livewire\Backend\Admin;

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
// {
//     use WithPagination;
//     #[Url]
//     public $search = '';

//     #[Url]
//     public $status = '';

//     #[Url]
//     public $paymentMethod = '';

//     #[Url]
//     public $perPage = 10;

//     public $sortField = 'created_at';
//     public $sortDirection = 'desc';

//     protected $queryString = [
//         'search' => ['except' => ''],
//         'status' => ['except' => ''],
//         'paymentMethod' => ['except' => ''],
//         'perPage' => ['except' => 10],
//     ];

//     public function updatingSearch()
//     {
//         $this->resetPage();
//     }

//     public function updatingStatus()
//     {
//         $this->resetPage();
//     }

//     public function updatingPaymentMethod()
//     {
//         $this->resetPage();
//     }

//     public function sortBy($field)
//     {
//         if ($this->sortField === $field) {
//             $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
//         } else {
//             $this->sortField = $field;
//             $this->sortDirection = 'asc';
//         }
//     }

//     public function render()
//     {
//         $payments = Payment::query()
//             ->with(['booking', 'user'])
//             ->when($this->search, function ($query) {
//                 $query->where(function ($q) {
//                     $q->where('id', 'like', '%' . $this->search . '%')
//                         ->orWhere('amount', 'like', '%' . $this->search . '%')
//                         ->orWhere('note', 'like', '%' . $this->search . '%')
//                         ->orWhereHas('user', function ($q) {
//                             $q->where('name', 'like', '%' . $this->search . '%')
//                                 ->orWhere('email', 'like', '%' . $this->search . '%');
//                         })
//                         ->orWhereHas('booking', function ($q) {
//                             $q->where('id', 'like', '%' . $this->search . '%');
//                         });
//                 });
//             })
//             ->when($this->status !== '', function ($query) {
//                 $query->where('status', $this->status);
//             })
//             ->when($this->paymentMethod !== '', function ($query) {
//                 $query->where('payment_method', $this->paymentMethod);
//             })
//             ->orderBy($this->sortField, $this->sortDirection)
//             ->paginate($this->perPage);

//         return view('livewire.backend.admin.payment-component', [
//             'payments' => $payments,
//         ]);
//     }
// }
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

    public $sortField ;

    public function openDetailsModal($paymentId)
    {
        $this->detailsPayment = Payment::with(['booking', 'user'])->findOrFail($paymentId);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsPayment = null;
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

        return view('livewire.backend.admin.payment-component', [
            'payments' => $payments,
        ]);
    }
}
