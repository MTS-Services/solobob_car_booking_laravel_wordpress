<?php

    namespace App\Livewire\Backend\Admin\DepositManagement;

    use App\Models\Deposit;
    use App\Models\Payment;
    use Livewire\Attributes\Layout;
    use Livewire\Attributes\Url;
    use Livewire\Component;
    use Livewire\WithPagination;

#[Layout(
    'app',
    [
        'title' => 'Deposit Management',
        'breadcrumb' => 'Deposit Management',
        'page_slug' => 'deposit-management',
    ]
)]
class DepositComponent extends Component
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

        $deposit = Deposit::find($id);

        if ($deposit) {

            $this->detailsPayment = $deposit;

            $this->showDetailsModal = true;
        } else {

            session()->flash('error', 'Deposit details not available.');
        }
    }

    public function render()
    {
        $payments = Payment::query()->deposit()
            ->with(['booking', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('id', 'like', '%'.$this->search.'%')
                        ->orWhere('amount', 'like', '%'.$this->search.'%')
                        ->orWhere('note', 'like', '%'.$this->search.'%')
                        ->orWhereHas('user', function ($q) {
                            $q->where('name', 'like', '%'.$this->search.'%')
                                ->orWhere('email', 'like', '%'.$this->search.'%');
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

        return view('livewire.backend.admin.deposit-management.deposit-component', [
            'payments' => $payments,
        ]);
    }
}
