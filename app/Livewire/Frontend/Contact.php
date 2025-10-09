<?php

namespace App\Livewire\Frontend;

use App\Livewire\Forms\ContactForm;
use App\Models\Contacts;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(
    'app',
    [
        'title' => 'livewire.frontend.contact',
        'breadcrumb' => 'livewire.frontend.contact',
        'page_slug' => 'livewire.frontend.contact',
    ]
)]
class Contact extends Component
{
    public ContactForm $form;

    public function contactSubmit()
    {

        $this->validate();

        Contacts::create($this->form->all());

        session()->flash('submit_message', 'Message has been sent successfully');

        $this->reset(['form.first_name', 'form.last_name', 'form.phone', 'form.email', 'form.message']);

    }

    public function render()
    {
        return view('livewire.frontend.contact');
    }
}
