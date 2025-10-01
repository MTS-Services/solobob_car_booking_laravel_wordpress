<?php

namespace App\Livewire\Backend\Partials;

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
        return view('livewire.backend.partials.header');
    }
}
