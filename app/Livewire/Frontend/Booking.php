<?php

namespace App\Livewire\Frontend;

use App\Models\Vehicle;
use App\Models\Booking as BookingModel;
use App\Models\UserDocuments;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
    use WithFileUploads;

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

    // File uploads
    #[Rule('required|image|max:5120')] // 5MB max
    public $license = null;

    #[Rule('required|image|max:5120')]
    public $selfie = null;

    #[Rule('required|mimes:jpg,jpeg,png,pdf|max:5120')]
    public $addressProof = null;

    // Billing Information
    #[Rule('required|string|max:255')]
    public string $firstName = '';

    #[Rule('required|string|max:255')]
    public string $lastName = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('required|date|before:today')]
    public string $dob = '';

    // Residential Address
    #[Rule('required|string|max:500')]
    public string $address = '';

    #[Rule('required|string|max:255')]
    public string $city = '';

    #[Rule('required|string|max:255')]
    public string $state = '';

    #[Rule('required|string|max:20')]
    public string $zip = '';

    // Parking Address
    public bool $sameAsResidential = false;

    #[Rule('required|string|max:500')]
    public string $parkingAddress = '';

    #[Rule('required|string|max:255')]
    public string $parkingCity = '';

    #[Rule('required|string|max:255')]
    public string $parkingState = '';

    #[Rule('required|string|max:20')]
    public string $parkingZip = '';

    // Terms and SMS
    #[Rule('accepted')]
    public bool $termsAccepted = false;

    public bool $smsAlerts = false;

    // License Details
    #[Rule('nullable|date')]
    public string $licenseIssueDate = '';

    #[Rule('nullable|date|after:today')]
    public string $licenseExpiryDate = '';

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
        $this->prefillUserData();
    }

    /**
     * Prefill user data if logged in
     */
    protected function prefillUserData()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->firstName = $user->first_name ?? '';
            $this->lastName = $user->last_name ?? '';
            $this->email = $user->email ?? '';

            // Check if user has existing documents
            $existingDoc = UserDocuments::where('user_id', user()->id)
                ->latest()
                ->first();

            if ($existingDoc && $existingDoc->verification_status === UserDocuments::VERIFICATION_VERIFIED) {
                // Optionally prefill some data from verified documents
                $this->licenseIssueDate = $existingDoc->issue_date?->format('Y-m-d') ?? '';
                $this->licenseExpiryDate = $existingDoc->expiry_date?->format('Y-m-d') ?? '';
            }
        }
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
     * Updated when rental range changes
     */
    public function updatedRentalRange()
    {
        $this->pickupDate = '';
        $this->returnDate = '';
    }

    /**
     * Auto-calculate return date when pickup date changes
     */
    public function updatedPickupDate($value)
    {
        if (!empty($value)) {
            try {
                $pickup = Carbon::parse($value);
                $days = $this->rentalRange === 'weekly' ? 7 : 30;
                $return = $pickup->copy()->addDays($days);
                
                $this->returnDate = $return->format('Y-m-d');
            } catch (\Exception $e) {
                $this->returnDate = '';
            }
        } else {
            $this->returnDate = '';
        }
    }

    /**
     * Auto-fill parking address when checkbox is toggled
     */
    public function updatedSameAsResidential($value)
    {
        if ($value) {
            $this->parkingAddress = $this->address;
            $this->parkingCity = $this->city;
            $this->parkingState = $this->state;
            $this->parkingZip = $this->zip;
        } else {
            $this->parkingAddress = '';
            $this->parkingCity = '';
            $this->parkingState = '';
            $this->parkingZip = '';
        }
    }

    /**
     * Save verification data temporarily and move to next step
     * Data is NOT saved to database yet - only stored in session
     */
    public function saveVerificationData()
    {
        try {
            // Validate all fields
            $this->validate();

            // Store uploaded files temporarily in session
            // We'll move them to permanent storage after payment
            session([
                'temp_verification_data' => [
                    // Temporary file paths (still in Livewire's temp storage)
                    'license' => $this->license->getRealPath(),
                    'license_name' => $this->license->getClientOriginalName(),
                    'license_mime' => $this->license->getMimeType(),

                    'selfie' => $this->selfie->getRealPath(),
                    'selfie_name' => $this->selfie->getClientOriginalName(),
                    'selfie_mime' => $this->selfie->getMimeType(),

                    'addressProof' => $this->addressProof->getRealPath(),
                    'addressProof_name' => $this->addressProof->getClientOriginalName(),
                    'addressProof_mime' => $this->addressProof->getMimeType(),

                    // License dates
                    'licenseIssueDate' => $this->licenseIssueDate,
                    'licenseExpiryDate' => $this->licenseExpiryDate,

                    // Billing information
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'email' => $this->email,
                    'dob' => $this->dob,

                    // Residential address
                    'address' => $this->address,
                    'city' => $this->city,
                    'state' => $this->state,
                    'zip' => $this->zip,

                    // Parking address
                    'parkingAddress' => $this->parkingAddress,
                    'parkingCity' => $this->parkingCity,
                    'parkingState' => $this->parkingState,
                    'parkingZip' => $this->parkingZip,
                    'sameAsResidential' => $this->sameAsResidential,

                    // Terms and SMS
                    'termsAccepted' => $this->termsAccepted,
                    'smsAlerts' => $this->smsAlerts,
                ],
                'temp_booking_data' => [
                    'vehicle_id' => $this->vehicle->id,
                    'pickup_date' => $this->pickupDate,
                    'return_date' => $this->returnDate,
                    'pickup_time' => $this->pickupTime,
                    'return_time' => $this->returnTime,
                    'rental_range' => $this->rentalRange,
                ]
            ]);

            // Move to payment step
            $this->currentStep = 4;

            session()->flash('success', 'Verification data validated. Please proceed with payment.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Verification data validation error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while validating your data. Please try again.');
        }
    }

    /**
     * Complete booking - Save everything to database after payment
     * This should be called from step 4 after payment is successful
     */
    public function completeBooking()
    {
        try {
            DB::beginTransaction();

            // Get temporary data from session
            $verificationData = session('temp_verification_data');
            $bookingData = session('temp_booking_data');

            if (!$verificationData || !$bookingData) {
                throw new \Exception('Session data expired. Please start over.');
            }

            // Initialize FileUploadService
            $fileUploadService = app(\App\Services\FileUpload\FileUploadService::class);

            // Now permanently upload files using FileUploadService
            $licensePath = $fileUploadService->uploadImage(
                new \Illuminate\Http\UploadedFile(
                    $verificationData['license'],
                    $verificationData['license_name'],
                    $verificationData['license_mime'],
                    null,
                    true
                ),
                'documents/licenses',
                800,
                null,
                'public',
                true
            );

            $selfiePath = $fileUploadService->uploadImage(
                new \Illuminate\Http\UploadedFile(
                    $verificationData['selfie'],
                    $verificationData['selfie_name'],
                    $verificationData['selfie_mime'],
                    null,
                    true
                ),
                'documents/selfies',
                800,
                null,
                'public',
                true
            );

            $addressProofPath = $fileUploadService->upload(
                new \Illuminate\Http\UploadedFile(
                    $verificationData['addressProof'],
                    $verificationData['addressProof_name'],
                    $verificationData['addressProof_mime'],
                    null,
                    true
                ),
                'documents/address-proofs',
                'public',
                false
            );

            // Get the latest sort_order for this user
            $latestSortOrder = UserDocuments::where('user_id', user()->id)
                ->max('sort_order') ?? 0;

            // Create user documents record
            $userDocument = UserDocuments::create([
                'user_id' => user()->id,
                'sort_order' => $latestSortOrder + 1,
                'licence' => $licensePath,
                'selfe_licence' => $selfiePath,
                'address_proof' => $addressProofPath,
                'issue_date' => $verificationData['licenseIssueDate'] ?: null,
                'expiry_date' => $verificationData['licenseExpiryDate'] ?: null,
                'verification_status' => UserDocuments::VERIFICATION_PENDING,
                'verified_at' => null,
                'created_by' => user()->id,
            ]);

            // Create booking record
            $booking = BookingModel::create([
                'user_id' => user()->id,
                'vehicle_id' => $bookingData['vehicle_id'],

                // Dates and times
                'pickup_date' => $bookingData['pickup_date'],
                'return_date' => $bookingData['return_date'],
                'pickup_time' => $bookingData['pickup_time'],
                'return_time' => $bookingData['return_time'],
                'booking_date' => now(),

                // Billing information
                'first_name' => $verificationData['firstName'],
                'last_name' => $verificationData['lastName'],
                'email' => $verificationData['email'],
                'date_of_birth' => $verificationData['dob'],

                // Residential address
                'residential_address' => $verificationData['address'],
                'residential_city' => $verificationData['city'],
                'residential_state' => $verificationData['state'],
                'residential_zip' => $verificationData['zip'],

                // Parking address
                'parking_address' => $verificationData['parkingAddress'],
                'parking_city' => $verificationData['parkingCity'],
                'parking_state' => $verificationData['parkingState'],
                'parking_zip' => $verificationData['parkingZip'],
                'same_as_residential' => $verificationData['sameAsResidential'],

                // Terms and preferences
                'terms_accepted' => $verificationData['termsAccepted'],
                'sms_alerts' => $verificationData['smsAlerts'],

                // Pricing based on rental range
                'rental_rate' => $bookingData['rental_range'] === 'weekly'
                    ? $this->vehicle->weekly_rate
                    : $this->vehicle->monthly_rate,
                'security_deposit' => $bookingData['rental_range'] === 'weekly'
                    ? $this->vehicle->security_deposit_weekly
                    : $this->vehicle->security_deposit_monthly,
                'subtotal' => $bookingData['rental_range'] === 'weekly'
                    ? $this->vehicle->weekly_rate
                    : $this->vehicle->monthly_rate,
                'total_amount' => ($bookingData['rental_range'] === 'weekly'
                    ? $this->vehicle->weekly_rate + $this->vehicle->security_deposit_weekly
                    : $this->vehicle->monthly_rate + $this->vehicle->security_deposit_monthly),

                // Rental information
                'rental_range' => $bookingData['rental_range'],

                // Link to user documents
                'user_document_id' => $userDocument->id,

                // Status - NOW CONFIRMED after payment
                'booking_status' => BookingModel::BOOKING_STATUS_PENDING,
                'payment_status' => 'completed',

                // Created by
                'created_by' => user()->id,
            ]);

            DB::commit();

            // Clear session data
            session()->forget(['temp_verification_data', 'temp_booking_data']);

            // Store final booking ID
            session(['current_booking_id' => $booking->id]);

            session()->flash('success', 'Booking completed successfully!');

            // Redirect to confirmation page
            return redirect()->route('booking-confirmation', $booking->id);
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded files if any error occurs
            if (isset($licensePath)) {
                $fileUploadService->delete($licensePath);
            }
            if (isset($selfiePath)) {
                $fileUploadService->delete($selfiePath);
            }
            if (isset($addressProofPath)) {
                $fileUploadService->delete($addressProofPath);
            }

            Log::error('Booking completion error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * Move to next step (for date selection)
     */
    public function nextStep()
    {
        try {
            // Validate date fields
            $this->validate([
                'pickupTime' => 'required|string',
                'returnTime' => 'required|string',
            ]);
            // Move to verification step
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

    public function render()
    {
        return view('livewire.frontend.booking', [
            'disabledDates' => $this->disabledDates,
            'requiredDays' => $this->getRequiredDays(),
        ]);
    }
}