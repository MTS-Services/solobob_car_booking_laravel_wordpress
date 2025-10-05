<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ContactForm extends Form
{
    //

   #[Validate('required')]
   public $first_name = '';

   
   #[Validate('required')]
   public $last_name = '';

   
   #[Validate('required|email')]
   public $email = '';

   
   #[Validate('numeric')]
   public $phone = '';

   
   #[Validate('required')]
   public $message = '';
}
