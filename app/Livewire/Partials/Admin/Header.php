<?php

namespace App\Livewire\Partials\Admin;

use Livewire\Component;

class Header extends Component
{
    public string $breadcrumb = '';
    public function mount(string $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }
    public function render()
    {
        return view('livewire.partials.admin.header');
    }
}
