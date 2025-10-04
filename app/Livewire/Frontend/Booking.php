<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout(
    'app',
    [
        'title' => 'livewire.frontend.booking',
        'breadcrumb' => 'livewire.frontend.booking',
        'page_slug' => 'livewire.frontend.booking'
    ]
)]
class Booking extends Component
{

  public string $paymentFrequency = 'daily'; // default
    public int $rentalDays = 31;
    public float $dailyPrice = 99.00;
    public float $securityDeposit = 200.00;

    public function getRentalCostProperty(): float
    {
        return match ($this->paymentFrequency) {
            'daily' => $this->dailyPrice,
            'weekly' => $this->dailyPrice * 7,
            'now' => $this->dailyPrice * $this->rentalDays,
            default => 0.00,
        };
    }

    public function getUpfrontPaymentProperty(): float
    {
        return $this->rentalCost + $this->securityDeposit;
    }

    public function getPaymentDescriptionProperty(): string
    {
        $rentalCost = $this->rentalCost;
        $dailyPrice = number_format($this->dailyPrice, 2);

        return match ($this->paymentFrequency) {
            'daily' => "Your next daily payment of \$$dailyPrice is due starting Oct 02 until Nov 01",
            'weekly' => "Your next weekly payment of \$" . number_format($rentalCost, 2) . " is due starting Oct 02 until Nov 01",
            'now' => "The total rental amount of \$" . number_format($rentalCost, 2) . " has been paid upfront.",
            default => '',
        };
    }

    private function formatCurrency(float $amount): string
    {
        return '$' . number_format($amount, 2);
    }

    public function render()
    {
        return view('livewire.frontend.booking');
    }
}
