<?php

namespace App\Livewire\Frontend;

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
    public $testimonials;

    public function mount()
    {
        $this->showTestimonials();
    }
    public function showTestimonials()
    {
        $this->testimonials = [
            [
                'text' => 'Family er sathe weekend trip er jonno gari chilo. Booking process chilo simple, ar gari chilo clean ar comfortable chilo.',
                'img' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                'name' => 'Sarah Thompson',
                'title' => 'Event Planner',
            ],
            [
                'text' => 'Uber or Pathao or jonno 833 Rentals er vehicles perfect. Approval fast, ar gari gulo always in good condition. Income barate help koreche.',
                'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                'name' => 'Michael Reed',
                'title' => 'Owner',
            ],
            [
                'text' => '833 Rentals er flexible rental options ar fast approval process amader business ke smooth koreche. Amra easily on-demand vehicles peye jai.',
                'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                'name' => 'John Matthews',
                'title' => 'Executive Chef',
            ],
            [
                'text' => 'This is the fourth card to test the sliding mechanism correctly amader business ke smooth koreche. Amra easily on-demand vehicles peye jai.',
                'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                'name' => 'Anika Khan',
                'title' => 'Designer',
            ],
            [
                'text' => 'This is the fifth card for testing purposes amader business ke smooth koreche. Amra easily on-demand vehicles peye jai.',
                'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=200&q=80',
                'name' => 'Test User',
                'title' => 'Tester',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}
