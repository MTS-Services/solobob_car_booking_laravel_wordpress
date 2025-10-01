<?php

namespace App\Livewire\Frontend\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'Welcome to',
    ]
)]
class Home extends Component
{
    public function render()
    {
        return view('livewire.frontend.pages.home');
    }
}
