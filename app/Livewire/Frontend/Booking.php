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
    public int $currentStep = 2;
    public string $rentalRange = 'weekly';
    public int $upfrontAmountWeekly = 0;
    public int $upfrontAmountMonthly = 0;

    // Date/Time properties
    #[Rule('required|date|after_or_equal:today')]
    public string $pickupDate = '';

    #[Rule('required|date|after:pickupDate')]
    public string $returnDate = '';

    #[Rule('required|string')]
    public string $pickupTime = '';

    #[Rule('required|string')]
    public string $returnTime = '';

    // Disabled dates array
    public array $disabledDates = [];

    public function mount($slug)
    {
        $this->vehicle = Vehicle::with(['images', 'relations.make', 'relations.model', 'category', 'bookings.timeline'])
            ->where('slug', $slug)
            ->first();

        if (!$this->vehicle) {
            abort(404);
        }

        $this->upfrontAmountMonthly = $this->vehicle->monthly_rate + $this->vehicle->security_deposit_monthly;
        $this->upfrontAmountWeekly = $this->vehicle->weekly_rate + $this->vehicle->security_deposit_weekly;

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

            while ($start->lte($end)) {
                $disabledDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        $this->disabledDates = array_values(array_unique($disabledDates));
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
    /**
     * Validate date range selection
     */
    public function validateDateRange()
    {
        // dd($this->pickupDate, $this->returnDate);
        if (empty($this->pickupDate) || empty($this->returnDate)) {
            $this->addError('dateRange', 'Please select both pickup and return dates.');
            return false;
        }

        $pickup = Carbon::parse($this->pickupDate);
        $return = Carbon::parse($this->returnDate);

        $days = $pickup->diffInDays($return) + 1;
        $requiredDays = $this->getRequiredDays();

        // Log for debugging
        Log::info("Date validation: pickup={$this->pickupDate}, return={$this->returnDate}, days={$days}, required={$requiredDays}");

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
        $this->pickupDate = '';
        $this->returnDate = '';
        $this->dispatch('rental-range-changed', requiredDays: $this->getRequiredDays());
    }

    /**
     * Move to next step
     */
    public function nextStep()
    {
        try {
            $this->validate();

            if ($this->currentStep === 2 && !$this->validateDateRange()) {
                return;
            }

            if ($this->currentStep < 4) {
                $this->currentStep++;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        }
    }

    /**
     * Move to previous step
     */
    public function previousStep()
    {
        if ($this->currentStep > 2) {
            $this->currentStep--;
        }
    }

    protected function rules()
    {
        if ($this->currentStep === 2) {
            return [
                'pickupDate' => 'required|date|after_or_equal:today',
                'returnDate' => 'required|date|after:pickupDate',
                'pickupTime' => 'required|string',
                'returnTime' => 'required|string',
            ];
        }
        return [];
    }

    public function updated()
    {
        Log::info('Disabled dates: ' . json_encode($this->disabledDates));
        Log::info('Required days: ' . $this->getRequiredDays());
        Log::info('Current step: ' . $this->currentStep);
        Log::info('Rental range: ' . $this->rentalRange);
        Log::info('Upfront amount weekly: ' . $this->upfrontAmountWeekly);
        Log::info('Upfront amount monthly: ' . $this->upfrontAmountMonthly);
        Log::info('Pickup date: ' . $this->pickupDate);
        Log::info('Return date: ' . $this->returnDate);
        Log::info('Pickup time: ' . $this->pickupTime);
        Log::info('Return time: ' . $this->returnTime);
    }

    public function render()
    {
        // Log::info('Disabled dates: ' . json_encode($this->disabledDates));
        // Log::info('Required days: ' . $this->getRequiredDays());
        // Log::info('Current step: ' . $this->currentStep);
        // Log::info('Rental range: ' . $this->rentalRange);
        // Log::info('Upfront amount weekly: ' . $this->upfrontAmountWeekly);
        // Log::info('Upfront amount monthly: ' . $this->upfrontAmountMonthly);
        // Log::info('Pickup date: ' . $this->pickupDate);
        // Log::info('Return date: ' . $this->returnDate);
        // Log::info('Pickup time: ' . $this->pickupTime);
        // Log::info('Return time: ' . $this->returnTime);

        return view('livewire.frontend.booking', [
            'disabledDates' => $this->disabledDates,
            'requiredDays' => $this->getRequiredDays(),
        ]);
    }
}
