<?php

namespace App\Livewire\Frontend;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

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
    public string $selectedDate = '';

    #[Rule('required|string')]
    public string $selectedTime = '';

    #[Rule('required|integer|min:1|max:365')]
    public int $rentalDays = 7;

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


    // --- Step 4: Confirmation ---
    // (Handled by final validation and submit)


    public function mount($slug)
    {
        // Fetch vehicle with relationships
        $this->vehicle = Vehicle::with(['images', 'relations.make', 'relations.model', 'category', 'bookings.timeline'])->where('slug', $slug)->first();
        $this->upfrontAmountMonthly = $this->vehicle->monthly_rate + $this->vehicle->security_deposit_monthly;
        $this->upfrontAmountWeekly = $this->vehicle->weekly_rate + $this->vehicle->security_deposit_weekly;
    }


    // Dynamic Validation Rules based on current step
    protected function rules()
    {
        return match ($this->currentStep) {
            1 => [
                'selectedDate' => 'required|date|after_or_equal:today',
                'selectedTime' => 'required|string',
                'rentalDays' => 'required|integer|min:1|max:365',
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
        return $this->dailyPrice * $this->rentalDays;
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

            if ($this->currentStep < 4) {
                $this->currentStep++;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw the exception to show errors on the form
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

        // --- Task Processing ---

        // 1. Save Signature Image (Simulation):
        // In a real application, you would:
        // $signaturePath = $this->saveBase64Image($this->signatureData);
        // \Log::info("Signature saved to: $signaturePath");

        // 2. Process Payment (Simulation)
        // \Log::info("Processing payment with option: " . $this->paymentOption);

        // 3. Save Booking to Database (Simulation)
        // \Log::info("Booking saved for user: " . $this->email);

        session()->flash('success', 'Your booking has been successfully confirmed!');
        // return $this->redirect(route('thank-you')); // Redirect to a success page
    }

    // Helper for final validation across all steps
    protected function rulesByStep(int $step): array
    {
        return match ($step) {
            1 => [
                'selectedDate' => 'required',
                'selectedTime' => 'required',
                'rentalDays' => 'required|min:1',
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

    public function render()
    {
        return view('livewire.frontend.booking');
    }
}
