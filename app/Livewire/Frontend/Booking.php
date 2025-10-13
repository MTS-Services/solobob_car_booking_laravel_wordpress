<?php

namespace App\Livewire\Frontend;

use App\Models\Vehicle;
use App\Models\Booking as BookingModel;
use App\Models\UserDocuments;
use App\Models\BillingInformation;
use App\Models\Addresse;
use App\Models\BookingStatusTimeline;
use App\Models\BookingRelation;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public string $vehicleSlug = '';
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
    #[Rule('required|image|max:5120')]
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

    // Signature
    public string $userSignature = '';

    // License Details
    #[Rule('nullable|date')]
    public string $licenseIssueDate = '';

    #[Rule('nullable|date|after:today')]
    public string $licenseExpiryDate = '';

    // Disabled dates array
    public array $disabledDates = [];

    public function mount($slug)
    {
        $this->vehicleSlug = $slug;
        $this->loadVehicle();

        if (!$this->vehicle) {
            abort(404);
        }

        $this->upfrontAmountMonthly = $this->vehicle->monthly_rate + $this->vehicle->security_deposit_monthly;
        $this->upfrontAmountWeekly = $this->vehicle->weekly_rate + $this->vehicle->security_deposit_weekly;

        $this->loadDisabledDates();
        $this->prefillUserData();
    }

    /**
     * Load vehicle from database
     */
    protected function loadVehicle()
    {
        $this->vehicle = Vehicle::with(['images', 'relations.make', 'relations.model', 'category', 'bookings.timeline'])
            ->where('slug', $this->vehicleSlug)
            ->first();
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

            $existingDoc = UserDocuments::where('user_id', user()->id)
                ->latest()
                ->first();

            if ($existingDoc && $existingDoc->verification_status === UserDocuments::VERIFICATION_VERIFIED) {
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
     * Save signature from modal
     */
    public function saveSignature($signatureData)
    {
        $this->userSignature = $signatureData;
        $this->termsAccepted = true;
        $this->dispatch('close-terms-modal');
    }

    /**
     * Generate unique booking reference
     */
    protected function generateUniqueBookingReference(): string
    {
        do {
            $reference = 'BK-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        } while (BookingModel::where('booking_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Save verification data and upload files immediately
     */
    public function saveVerificationData()
    {
        try {
            $this->validate();

            if (empty($this->userSignature)) {
                session()->flash('error', 'Please sign the terms and conditions.');
                return;
            }

            $this->loadVehicle();

            $fileUploadService = app(\App\Services\FileUpload\FileUploadService::class);

            $licensePath = $fileUploadService->uploadImage(
                $this->license,
                'documents/licenses',
                800,
                null,
                'public',
                true
            );

            $selfiePath = $fileUploadService->uploadImage(
                $this->selfie,
                'documents/selfies',
                800,
                null,
                'public',
                true
            );

            $addressProofPath = $fileUploadService->upload(
                $this->addressProof,
                'documents/address-proofs',
                'public',
                false
            );

            $signaturePath = null;
            if (!empty($this->userSignature)) {
                $signatureData = str_replace('data:image/png;base64,', '', $this->userSignature);
                $signatureData = str_replace(' ', '+', $signatureData);
                $signatureImage = base64_decode($signatureData);

                $signatureName = 'signature_' . time() . '_' . user()->id . '.png';
                $signaturePath = 'documents/signatures/' . $signatureName;
                Storage::disk('public')->put($signaturePath, $signatureImage);
            }

            session([
                'temp_verification_data' => [
                    'licensePath' => $licensePath,
                    'selfiePath' => $selfiePath,
                    'addressProofPath' => $addressProofPath,
                    'signaturePath' => $signaturePath,
                    'licenseIssueDate' => $this->licenseIssueDate,
                    'licenseExpiryDate' => $this->licenseExpiryDate,
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'email' => $this->email,
                    'dob' => $this->dob,
                    'address' => $this->address,
                    'city' => $this->city,
                    'state' => $this->state,
                    'zip' => $this->zip,
                    'parkingAddress' => $this->parkingAddress,
                    'parkingCity' => $this->parkingCity,
                    'parkingState' => $this->parkingState,
                    'parkingZip' => $this->parkingZip,
                    'sameAsResidential' => $this->sameAsResidential,
                    'termsAccepted' => $this->termsAccepted,
                    'smsAlerts' => $this->smsAlerts,
                ],
                'temp_booking_data' => [
                    'vehicle_id' => $this->vehicle->id,
                    'vehicle_slug' => $this->vehicleSlug,
                    'pickup_date' => $this->pickupDate,
                    'return_date' => $this->returnDate,
                    'pickup_time' => $this->pickupTime,
                    'return_time' => $this->returnTime,
                    'rental_range' => $this->rentalRange,
                    'pickup_location_id' => $this->vehicle->pickup_location_id ?? null,
                    'weekly_rate' => $this->vehicle->weekly_rate,
                    'monthly_rate' => $this->vehicle->monthly_rate,
                    'security_deposit_weekly' => $this->vehicle->security_deposit_weekly,
                    'security_deposit_monthly' => $this->vehicle->security_deposit_monthly,
                ]
            ]);

            $this->currentStep = 4;

            session()->flash('success', 'Verification data saved. Please proceed with payment.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while saving verification data.');
        }
    }

    /**
     * Complete booking with database transaction
     */
    public function completeBooking()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please login to complete booking.');
            return;
        }

        try {
            DB::beginTransaction();

            $verificationData = session('temp_verification_data');
            $bookingData = session('temp_booking_data');

            if (!$verificationData || !$bookingData) {
                session()->flash('error', 'Session data expired. Please start over.');
                $this->currentStep = 2;
                return;
            }

            // Create billing information
            $latestBillingSortOrder = BillingInformation::where('user_id', user()->id)
                ->max('sort_order') ?? 0;

            $billingInfo = BillingInformation::create([
                'user_id' => user()->id,
                'sort_order' => $latestBillingSortOrder + 1,
                'first_name' => $verificationData['firstName'],
                'last_name' => $verificationData['lastName'],
                'email' => $verificationData['email'],
                'date_of_birth' => $verificationData['dob'],
                'created_by' => user()->id,
            ]);

            // Create residential address
            $latestAddressSortOrder = Addresse::where('user_id', user()->id)
                ->max('sort_order') ?? 0;

            $residentialAddress = Addresse::create([
                'user_id' => user()->id,
                'sort_order' => $latestAddressSortOrder + 1,
                'address_type' => Addresse::RESIDENTIAL,
                'address' => $verificationData['address'],
                'city' => $verificationData['city'],
                'state' => $verificationData['state'],
                'postal_code' => $verificationData['zip'],
                'is_default' => false,
                'created_by' => user()->id,
            ]);

            // Create parking address
            $parkingAddress = Addresse::create([
                'user_id' => user()->id,
                'sort_order' => $latestAddressSortOrder + 2,
                'address_type' => Addresse::PARKING,
                'address' => $verificationData['parkingAddress'],
                'city' => $verificationData['parkingCity'],
                'state' => $verificationData['parkingState'],
                'postal_code' => $verificationData['parkingZip'],
                'is_default' => false,
                'created_by' => user()->id,
            ]);

            // Create user documents
            $latestDocSortOrder = UserDocuments::where('user_id', user()->id)
                ->max('sort_order') ?? 0;

            $userDocument = UserDocuments::create([
                'user_id' => user()->id,
                'sort_order' => $latestDocSortOrder + 1,
                'licence' => $verificationData['licensePath'],
                'selfe_licence' => $verificationData['selfiePath'],
                'address_proof' => $verificationData['addressProofPath'],
                'issue_date' => $verificationData['licenseIssueDate'] ?: null,
                'expiry_date' => $verificationData['licenseExpiryDate'] ?: null,
                'verification_status' => UserDocuments::VERIFICATION_PENDING,
                'verified_at' => null,
                'created_by' => user()->id,
            ]);

            // Parse dates
            $pickupDateTime = Carbon::parse($bookingData['pickup_date'] . ' ' . $bookingData['pickup_time']);
            $returnDateTime = Carbon::parse($bookingData['return_date'] . ' ' . $bookingData['return_time']);

            // Generate unique booking reference
            $bookingReference = $this->generateUniqueBookingReference();

            // Calculate amounts
            $isWeekly = $bookingData['rental_range'] === 'weekly';
            $rentalRate = $isWeekly ? floatval($bookingData['weekly_rate']) : floatval($bookingData['monthly_rate']);
            $securityDeposit = $isWeekly ? floatval($bookingData['security_deposit_weekly']) : floatval($bookingData['security_deposit_monthly']);
            $subtotal = $rentalRate;
            $totalAmount = $subtotal + $securityDeposit;

            // Create booking
            $latestBookingSortOrder = BookingModel::where('user_id', user()->id)
                ->max('sort_order') ?? 0;

            $booking = BookingModel::create([
                'user_id' => user()->id,
                'vehicle_id' => $bookingData['vehicle_id'],
                'sort_order' => $latestBookingSortOrder + 1,
                'booking_reference' => $bookingReference,
                'pickup_date' => $pickupDateTime,
                'return_date' => $returnDateTime,
                'booking_date' => now(),
                'pickup_location_id' => $bookingData['pickup_location_id'],
                'return_location' => null,
                'subtotal' => $subtotal,
                'delivery_fee' => 0.00,
                'service_fee' => 0.00,
                'tax_amount' => 0.00,
                'security_deposit' => $securityDeposit,
                'total_amount' => $totalAmount,
                'booking_status' => BookingModel::BOOKING_STATUS_PENDING,
                'special_requests' => null,
                'reason' => null,
                'audit_by' => null,
                'created_by' => user()->id,
            ]);

            if (!$booking || !$booking->id) {
                throw new \Exception('Booking creation failed');
            }

            // Create timeline
            $latestTimelineSortOrder = BookingStatusTimeline::where('booking_id', $booking->id)
                ->max('sort_order') ?? 0;

            BookingStatusTimeline::create([
                'booking_id' => $booking->id,
                'sort_order' => $latestTimelineSortOrder + 1,
                'booking_status' => BookingModel::BOOKING_STATUS_PENDING,
                'created_by' => user()->id,
            ]);

            // Create booking relation
            BookingRelation::create([
                'booking_id' => $booking->id,
                'billing_information_id' => $billingInfo->id,
                'residential_address_id' => $residentialAddress->id,
                'parking_address_id' => $parkingAddress->id,
                'user_document_id' => $userDocument->id,
                'signature_path' => $verificationData['signaturePath'],
                'terms_accepted' => $verificationData['termsAccepted'],
                'sms_alerts' => $verificationData['smsAlerts'],
                'terms_accepted_at' => now(),
                'same_as_residential' => $verificationData['sameAsResidential'],
                'rental_range' => $bookingData['rental_range'],
            ]);

            DB::commit();

            // Clear session
            session()->forget(['temp_verification_data', 'temp_booking_data']);

            // Store booking reference
            session([
                'current_booking_id' => $booking->id,
                'booking_reference' => $bookingReference,
            ]);

            session()->flash('success', 'Booking completed successfully! Reference: ' . $bookingReference);

            return $this->redirect(route('booking-confirmation', ['id' => $booking->id]), navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'An error occurred while completing your booking. Please try again.');
            return;
        }
    }

    /**
     * Move to next step (for date selection)
     */
    public function nextStep()
    {
        try {
            if (!user()) {
                return redirect()->route('login');
            }

            $this->validate([
                'pickupDate' => 'required|date|after_or_equal:today',
                'returnDate' => 'required|date|after:pickupDate',
                'pickupTime' => 'required|string',
                'returnTime' => 'required|string',
            ]);

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