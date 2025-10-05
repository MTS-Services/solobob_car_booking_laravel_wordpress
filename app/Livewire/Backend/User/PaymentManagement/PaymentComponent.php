<?php

namespace App\Livewire\Backend\User\PaymentManagement;

use Livewire\Component;
use App\Models\Payment;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

#[Layout(
    'app',
    [
        'title' => 'Payments',
        'breadcrumb' => 'Payments',
        'page_slug' => 'user-payments',
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


    public function mount()
    {
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

    public function openDetailsModal(int $id)
    {
        try {
            $this->detailsPayment = Payment::findOrFail($id)->first()->load('paymentMethod');
            $this->showDetailsModal = true;
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                abort(404);
            }
            session()->flash('error', $e->getMessage());
        }
    }
    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->detailsPayment = null;
    }
    public function render()
    {
        $payments = Payment::query()->self()
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
            ->paginate(5);

        return view('livewire.backend.user.payment-management.payment-component', [
            'payments' => $payments,
        ]);
    }
}
