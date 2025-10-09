<?php

namespace App\Livewire\Frontend;

use App\Models\Vehicle;
use App\Models\Booking as BookingModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

#[Layout(
    'app',
    [
        'title' => 'Booking',
        'breadcrumb' => 'Booking',
        'page_slug' => 'booking',
    ]
)]
class Booking extends Component
{
    public ?Vehicle $vehicle;
    // --- Step State ---
    public int $currentStep = 2;

    public string $rentalRange = 'weekly';
    public int $upfrontAmountWeekly = 0;
    public int $upfrontAmountMonthly = 0;

    // --- Step 1: Date/Time ---
    #[Rule('required|date|after_or_equal:today')]
    public string $pickupDate = '';

    #[Rule('required|date|after:pickupDate')]
    public string $returnDate = '';

    #[Rule('required|string')]
    public string $pickupTime = '';

    #[Rule('required|string')]
    public string $returnTime = '';

    // Disabled dates for flatpickr
    public array $disabledDates = [];

    // Simplified cost properties for preview
    public float $dailyPrice = 99.00;
    public float $securityDeposit = 200.00;

    // --- Step 2: User Information & Signature ---
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|string|max:20')]
    public string $phone = '';

    #[Rule('accepted')]
    public bool $termsAccepted = false;

    // Base64 image data from signature pad
    #[Rule('required|string')]
    public string $signatureData = '';

    // --- Step 3: Payment ---
    #[Rule('required|in:card,paypal,bank')]
    public string $paymentOption = 'card';

    // Conditional rules for card payment
    public string $cardName = '';
    public string $cardNumber = '';
    public string $cardExpiry = '';
    public string $cardCvc = '';

    public function mount($slug)
    {
        // Fetch vehicle with relationships
        $this->vehicle = Vehicle::with(['images', 'relations.make', 'relations.model', 'category', 'bookings.timeline'])
            ->where('slug', $slug)
            ->first();

        $this->upfrontAmountMonthly = $this->vehicle->monthly_rate + $this->vehicle->security_deposit_monthly;
        $this->upfrontAmountWeekly = $this->vehicle->weekly_rate + $this->vehicle->security_deposit_weekly;

        // Load disabled dates
        $this->loadDisabledDates();
    }

    /**
     * Load all booked dates for this vehicle
     */
    public function loadDisabledDates()
    {
        $bookings = BookingModel::where('vehicle_id', $this->vehicle->id)
            ->whereIn('booking_status', [
                BookingModel::BOOKING_STATUS_PENDING,
                BookingModel::BOOKING_STATUS_ACCEPTED,
                BookingModel::BOOKING_STATUS_DEPOSITED,
                BookingModel::BOOKING_STATUS_DELIVERED,
            ])
            ->get(['pickup_date', 'return_date']);

        $disabledDates = [];

        foreach ($bookings as $booking) {
            $start = Carbon::parse($booking->pickup_date);
            $end = Carbon::parse($booking->return_date);

            // Generate all dates in the range
            while ($start->lte($end)) {
                $disabledDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        $this->disabledDates = array_unique($disabledDates);
    }

    /**
     * Get disabled dates as JSON for JavaScript
     */
    public function getDisabledDatesJson()
    {
        return json_encode($this->disabledDates);
    }

    /**
     * Get required days based on rental range
     */
    public function getRequiredDays(): int
    {
        return $this->rentalRange === 'weekly' ? 7 : 30;
    }

    /**
     * Validate date range selection
     */
    public function validateDateRange()
    {
        if (empty($this->pickupDate) || empty($this->returnDate)) {
            $this->addError('dateRange', 'Please select both pickup and return dates.');
            return false;
        }

        $pickup = Carbon::parse($this->pickupDate);
        $return = Carbon::parse($this->returnDate);
        $days = $pickup->diffInDays($return);
        $requiredDays = $this->getRequiredDays();

        if ($days !== $requiredDays) {
            $rangeName = $this->rentalRange === 'weekly' ? 'Weekly' : 'Monthly';
            $this->addError('dateRange', "{$rangeName} rentals must be exactly {$requiredDays} days. You selected {$days} days.");
            return false;
        }

        // Check if any date in range is disabled
        $current = $pickup->copy();
        while ($current->lte($return)) {
            if (in_array($current->format('Y-m-d'), $this->disabledDates)) {
                $this->addError('dateRange', 'Selected date range includes unavailable dates. Please choose different dates.');
                return false;
            }
            $current->addDay();
        }

        return true;
    }

    /**
     * Updated when rental range changes
     */
    public function updatedRentalRange()
    {
        // Reset dates when rental range changes
        $this->pickupDate = '';
        $this->returnDate = '';
        $this->dispatch('reset-calendar');
    }

    // Dynamic Validation Rules based on current step
    protected function rules()
    {
        return match ($this->currentStep) {
            1 => [
                'pickupDate' => 'required|date|after_or_equal:today',
                'returnDate' => 'required|date|after:pickupDate',
                'pickupTime' => 'required|string',
                'returnTime' => 'required|string',
            ],
            2 => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'termsAccepted' => 'accepted',
                'signatureData' => 'required|string',
            ],
            3 => [
                'paymentOption' => 'required|in:card,paypal,bank',
                'cardName' => $this->paymentOption === 'card' ? 'required|string|max:255' : 'nullable',
                'cardNumber' => $this->paymentOption === 'card' ? 'required|string|min:16|max:19' : 'nullable',
                'cardExpiry' => $this->paymentOption === 'card' ? 'required|string|date_format:m/y' : 'nullable',
                'cardCvc' => $this->paymentOption === 'card' ? 'required|string|min:3|max:4' : 'nullable',
            ],
            default => [],
        };
    }

    // Computed property for subtotal cost
    public function getSubtotalProperty(): float
    {
        return $this->dailyPrice * $this->getRequiredDays();
    }

    // Computed property for total cost
    public function getTotalCostProperty(): float
    {
        return $this->subtotal + $this->securityDeposit;
    }

    // Method to move to the next step
    public function nextStep()
    {
        try {
            // Validate only the fields for the current step
            $this->validate();

            // Additional validation for date range on step 1
            if ($this->currentStep === 1 && !$this->validateDateRange()) {
                return;
            }

            if ($this->currentStep < 4) {
                $this->currentStep++;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }

    // Method to move to the previous step
    public function previousStep()
    {
        if ($this->currentStep > 2) {
            $this->currentStep--;
        }
    }

    // Final submission method
    public function submit()
    {
        // Set to step 4 and validate ALL steps required fields
        $this->currentStep = 4;
        $rules = array_merge(
            $this->rulesByStep(1),
            $this->rulesByStep(2),
            $this->rulesByStep(3)
        );

        $this->validate($rules);

        // Final date range validation
        if (!$this->validateDateRange()) {
            $this->currentStep = 1;
            return;
        }

        // --- Task Processing ---
        // 1. Save booking to database
        // 2. Process payment
        // 3. Send confirmation email

        session()->flash('success', 'Your booking has been successfully confirmed!');
        // return $this->redirect(route('thank-you'));
    }

    // Helper for final validation across all steps
    protected function rulesByStep(int $step): array
    {
        return match ($step) {
            1 => [
                'pickupDate' => 'required|date|after_or_equal:today',
                'returnDate' => 'required|date|after:pickupDate',
                'pickupTime' => 'required|string',
                'returnTime' => 'required|string',
            ],
            2 => [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'termsAccepted' => 'accepted',
                'signatureData' => 'required',
            ],
            3 => [
                'paymentOption' => 'required',
                'cardName' => $this->paymentOption === 'card' ? 'required' : 'nullable',
                'cardNumber' => $this->paymentOption === 'card' ? 'required' : 'nullable',
                'cardExpiry' => $this->paymentOption === 'card' ? 'required' : 'nullable',
                'cardCvc' => $this->paymentOption === 'card' ? 'required' : 'nullable',
            ],
            default => [],
        };
    }

    public function updated()
    {
        Log::info($this->rentalDays, $this->rentalRange, $this->pickupDate, $this->returnDate, $this->pickupTime, $this->returnTime);
    }

    public function render()
    {
        return view('livewire.frontend.booking', [
            'disabledDates' => $this->disabledDates,
            'requiredDays' => $this->getRequiredDays(),
        ]);
    }
}
