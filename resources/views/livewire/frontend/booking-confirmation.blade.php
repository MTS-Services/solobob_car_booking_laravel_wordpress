<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Success Message -->
        <div class="max-w-3xl mx-auto">
            <!-- Success Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-green-100 rounded-full p-4">
                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Booking Confirmed!</h1>
                <p class="text-gray-600 mb-4">Thank you for your reservation. Your booking has been successfully confirmed.</p>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-700">
                        <span class="font-semibold">Booking Reference:</span>
                        <span class="text-lg font-bold ml-2">{{ $booking->booking_reference }}</span>
                    </p>
                </div>

                <p class="text-sm text-gray-500">
                    A confirmation email has been sent to <strong>{{ session('temp_verification_data.email') ?? $booking->user->email }}</strong>
                </p>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3">Booking Details</h2>

                <!-- Vehicle Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Vehicle Information</h3>
                    <div class="flex gap-4">
                        @if($booking->vehicle?->images?->first())
                            <img src="{{ storage_url($booking->vehicle->images->first()->image) }}" 
                                 alt="{{ $booking->vehicle->title }}"
                                 class="w-32 h-24 object-cover rounded-lg">
                        @endif
                        <div>
                            <p class="font-semibold text-lg">{{ $booking->vehicle->title }}</p>
                            <p class="text-gray-600">
                                {{ $booking->vehicle->relations?->first()?->make?->name ?? 'N/A' }} - 
                                {{ $booking->vehicle->relations?->first()?->model?->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-500">Year: {{ $booking->vehicle->year ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rental Period -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Rental Period</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Pickup Date & Time</p>
                            <p class="font-semibold">{{ $booking->pickup_date->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Return Date & Time</p>
                            <p class="font-semibold">{{ $booking->return_date->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <p class="text-sm text-gray-600">
                            Total Duration: <span class="font-semibold">{{ $booking->rental_duration_days }} days</span>
                        </p>
                    </div>
                </div>

                <!-- Pickup Location -->
                @if($booking->pickupLocation)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Pickup Location</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="font-semibold">{{ $booking->pickupLocation->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $booking->pickupLocation->address ?? 'Address not available' }}</p>
                    </div>
                </div>
                @endif

                <!-- Payment Summary -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Payment Summary</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Rental Cost:</span>
                            <span class="font-semibold">${{ number_format($booking->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Security Deposit:</span>
                            <span class="font-semibold">${{ number_format($booking->security_deposit, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Service Fee:</span>
                            <span class="font-semibold">${{ number_format($booking->service_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Tax:</span>
                            <span class="font-semibold">${{ number_format($booking->tax_amount, 2) }}</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold">Total Paid:</span>
                                <span class="text-lg font-bold text-green-600">${{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Status -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Booking Status</h3>
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold text-yellow-800">{{ $booking->booking_status_label }}</p>
                                <p class="text-sm text-yellow-700">Your booking is awaiting confirmation from our team. You'll receive an update shortly.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">What's Next?</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="bg-blue-100 rounded-full p-2 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">1. Check Your Email</h4>
                            <p class="text-sm text-gray-600">We've sent a confirmation email with all the details of your booking.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-green-100 rounded-full p-2 mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">2. Wait for Confirmation</h4>
                            <p class="text-sm text-gray-600">Our team will verify your documents and confirm your booking within 24 hours.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-purple-100 rounded-full p-2 mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">3. Prepare for Pickup</h4>
                            <p class="text-sm text-gray-600">Bring your driver's license and be ready at the pickup location on time.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 flex-col sm:flex-row">
                <a href="{{ route('home') }}" wire:navigate
                   class="flex-1 bg-zinc-500 text-white text-center py-3 rounded-lg hover:bg-zinc-600 transition font-medium">
                    Back to Home
                </a>
                <a href="{{ route('user.my-bookings') }}" wire:navigate
                   class="flex-1 bg-gray-800 text-white text-center py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                    View My Bookings
                </a>
                <button wire:click="downloadReceipt"
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    Download Receipt
                </button>
            </div>

            <!-- Support Contact -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Need help? Contact us at 
                    <a href="mailto:support@fairpyrental.com" class="text-blue-600 hover:underline">support@fairpyrental.com</a>
                    or call 
                    <a href="tel:+1234567890" class="text-blue-600 hover:underline">+1 (234) 567-890</a>
                </p>
            </div>
        </div>
    </div>
</div>