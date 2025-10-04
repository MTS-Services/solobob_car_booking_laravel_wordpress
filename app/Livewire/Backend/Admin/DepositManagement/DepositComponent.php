<?php

namespace App\Livewire\Backend\Admin\DepositManagement;

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
        return view('livewire.backend.admin.deposit-management.deposit-component');
    }
}
