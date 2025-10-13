<div class="min-h-screen bg-zinc-900 py-8 px-4 sm:px-6 lg:px-8 text-white">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-4xl font-extrabold text-zinc-100 mb-2">Complete Your Secure Deposit</h1>

            {{-- Payment Security Info --}}
            <div class="mt-6 p-5 rounded-2xl bg-zinc-800/50 border border-zinc-700">
                <h2 class="text-xl font-semibold text-emerald-400 mb-2">🔒 Secure & Reliable Payments</h2>
                <p class="text-zinc-400 leading-relaxed">
                    Your payment security is our top priority. All transactions are encrypted and processed through
                    trusted gateways like <span class="text-white font-semibold">PayPal</span> and
                    <span class="text-white font-semibold">Stripe</span> to ensure complete protection of your personal
                    and financial information.
                </p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-xl shadow-lg">
                <p class="text-emerald-400 font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl shadow-lg">
                <p class="text-red-400 font-medium flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Booking Details --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Vehicle Information --}}
                <div class="bg-zinc-800/50 backdrop-blur-sm rounded-2xl p-6 border border-zinc-700 shadow-xl">
                    <div class="flex justify-between">
                        <h2 class="text-2xl font-bold text-zinc-100 mb-5 border-b border-zinc-700/50 pb-3">Vehicle
                            Details</h2>
                        <p class="text-zinc-400 text-lg">
                            Booking Reference:
                            <span
                                class="text-emerald-400 font-mono font-semibold">{{ $booking->booking_reference }}</span>
                        </p>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Vehicle Image --}}
                        @if ($booking->vehicle && $booking->vehicle->images->count() > 0)
                            <div class="md:w-1/3 flex-shrink-0">
                                <div
                                    class="aspect-video bg-zinc-900 rounded-xl overflow-hidden shadow-lg border border-zinc-700">
                                    <img src="{{ storage_url($booking->vehicle->images->first()->image) }}"
                                        alt="{{ $booking->vehicle->title }}"
                                        class="w-full h-full object-cover transition duration-300 hover:scale-[1.03]">
                                </div>
                            </div>
                        @endif

                        {{-- Vehicle Info --}}
                        <div class="flex-1 space-y-4">
                            <h3 class="text-3xl font-extrabold text-emerald-400">
                                {{ $booking->vehicle?->title ?? 'N/A' }}</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-2 bg-zinc-700/30 rounded-lg">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider">Category</p>
                                    <p class="text-zinc-100 font-medium">
                                        {{ $booking->vehicle?->category?->name ?? 'N/A' }}</p>
                                </div>
                                <div class="p-2 bg-zinc-700/30 rounded-lg">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider">Year</p>
                                    <p class="text-zinc-100 font-medium">{{ $booking->vehicle?->year ?? 'N/A' }}</p>
                                </div>
                                <div class="p-2 bg-zinc-700/30 rounded-lg">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider">Color</p>
                                    <p class="text-zinc-100 font-medium">{{ $booking->vehicle?->color ?? 'N/A' }}</p>
                                </div>
                                <div class="p-2 bg-zinc-700/30 rounded-lg">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider">License Plate</p>
                                    <p class="text-zinc-100 font-medium font-mono">
                                        {{ $booking->vehicle?->license_plate ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Booking Information --}}
                <div class="bg-zinc-800/50 backdrop-blur-sm rounded-2xl p-6 border border-zinc-700 shadow-xl">
                    <h2 class="text-2xl font-bold text-zinc-100 mb-5 border-b border-zinc-700/50 pb-3">Rental & Trip
                        Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Rental Period</p>
                            <p class="text-zinc-100 font-medium capitalize text-lg">
                                {{ $booking->relation?->rental_range ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Duration</p>
                            <p class="text-zinc-100 font-medium text-lg">{{ number_format($booking->rental_duration_days ?? 0, 2) }} Days
                            </p>
                        </div>
                        <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Pickup Date</p>
                            <p class="text-zinc-100 font-medium text-lg">
                                {{ $booking->humanReadableDateTime($booking->pickup_date) }}</p>
                        </div>
                        <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Return Date</p>
                            <p class="text-zinc-100 font-medium text-lg">
                                {{ $booking->humanReadableDateTime($booking->return_date) }}</p>
                        </div>
                        <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600 md:col-span-2">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Pickup Location</p>
                            <p class="text-zinc-100 font-medium text-lg">{{ $booking->pickupLocation?->name ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                @if ($booking->billingInformation)
                    <div class="bg-zinc-800/50 backdrop-blur-sm rounded-2xl p-6 border border-zinc-700 shadow-xl">
                        <h2 class="text-2xl font-bold text-zinc-100 mb-5 border-b border-zinc-700/50 pb-3">Customer
                            Information</h2>
                        @php $billing = $booking->billingInformation; @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Full Name</p>
                                <p class="text-zinc-100 font-medium text-lg">{{ $billing->first_name }}
                                    {{ $billing->last_name }}</p>
                            </div>
                            <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Email</p>
                                <p class="text-zinc-100 font-medium text-lg truncate">{{ $billing->email }}</p>
                            </div>
                            <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Date of Birth</p>
                                <p class="text-zinc-100 font-medium text-lg">
                                    {{ \Carbon\Carbon::parse($billing->date_of_birth)->format('M d, Y') }}</p>
                            </div>
                            <div class="bg-zinc-700/50 rounded-lg p-4 border border-zinc-600">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Booking Date</p>
                                <p class="text-zinc-100 font-medium text-lg">
                                    {{ $booking->humanReadableDateTime($booking->booking_date) }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Payment Summary --}}
            <div class="lg:col-span-1">
                <div
                    class="bg-zinc-800/70 backdrop-blur-lg rounded-2xl p-6 border border-zinc-700 shadow-2xl sticky top-8">

                    {{-- Added Security Title --}}
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-emerald-400 mb-2 flex items-center">
                            <flux:icon name="shield-check" class="w-8 h-8 mr-2 text-white" stroke="gray"></flux:icon>
                            {{-- <svg class="w-6 h-6 mr-2 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg> --}}
                            Secure Payment Summary
                        </h2>
                        <p class="text-zinc-400 text-sm">Review your booking charges before securely completing your
                            payment via the selected method. Your payment details are protected with <strong class="text-gray-300">bank-grade
                                encryption (SSL)</strong>.</p>
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-100">
                            <span class="text-gray-100">Rental Subtotal (x{{ $booking->rental_duration_days ?? 0 }} days)</span>
                            <span
                                class="font-medium text-lg text-gray-50">${{ number_format($booking->subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-100">
                            <span class="text-gray-100">Delivery Fee</span>
                            <span
                                class="font-medium text-lg text-gray-50">${{ number_format($booking->delivery_fee ?? 0, 2) }}</span>
                        </div>
                        {{-- <div class="flex justify-between text-gray-100">
                            <span class="text-gray-100">Service Fee</span>
                            <span
                                class="font-medium text-lg text-gray-50">${{ number_format($booking->service_fee ?? 0, 2) }}</span>
                        </div> --}}
                        {{-- <div class="flex justify-between text-gray-100">
                            <span class="text-gray-100">Tax (VAT/GST)</span>
                            <span
                                class="font-medium text-lg text-gray-50">${{ number_format($booking->tax_amount ?? 0, 2) }}</span>
                        </div> --}}
                        <div class="flex justify-between text-gray-100 pb-4 border-b border-zinc-700">
                            <span class="text-gray-100">Security Deposit (Refundable)</span>
                            <span
                                class="font-medium text-lg text-gray-50">${{ number_format($booking->security_deposit ?? 0, 2) }}</span>
                        </div>
                        <div class="pt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-white">Total Due Now</span>
                                <span
                                    class="text-3xl font-extrabold text-emerald-400">${{ number_format($booking->total_amount ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Compact Payment Method Selection --}}
                    <div class="mb-6 w-full">
                        <h2 class="text-lg font-semibold text-zinc-100 mb-3">Select Payment Method</h2>
                        <div class="flex gap-4 w-full">

                            {{-- PayPal --}}
                            <button wire:click="selectPaymentMethod('paypal')" type="button"
                                class="flex flex-col w-1/2 items-center p-3 rounded-2xl border-2 transition-all duration-300 transform
            {{ $selectedPaymentMethod === 'paypal'
                ? 'border-emerald-400 bg-emerald-500/10 shadow-[0_0_15px_rgba(16,185,129,0.4)] scale-105'
                : 'border-zinc-700 bg-zinc-700/30 hover:border-blue-400 hover:scale-105' }}">
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center shadow-md">
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 2.05A.77.77 0 0 1 5.7 1.5h6.068c1.88 0 3.248.339 4.068 1.007.82.67 1.249 1.735 1.249 3.15 0 .468-.044.92-.132 1.36a5.857 5.857 0 0 1-.41 1.31 4.502 4.502 0 0 1-.738 1.09 5.087 5.087 0 0 1-1.096.87 6.746 6.746 0 0 1-1.41.618 9.191 9.191 0 0 1-1.699.28h-.03c-.018 0-.035.002-.052.005-.017.003-.033.008-.048.013h-3.37l-1.164 7.436zm6.416-14.153a1.414 1.414 0 0 0-.44-.035H9.86l-.956 6.096h2.452c.84 0 1.534-.198 2.065-.594.53-.395.795-.984.795-1.767 0-.672-.18-1.147-.54-1.426-.36-.279-.9-.418-1.62-.418a6.412 6.412 0 0 0-.564.144z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-white mt-2 font-medium">PayPal</span>
                            </button>

                            {{-- Stripe --}}
                            <button wire:click="selectPaymentMethod('stripe')" type="button"
                                class="flex flex-col w-1/2 items-center p-3 rounded-2xl border-2 transition-all duration-300 transform
            {{ $selectedPaymentMethod === 'stripe'
                ? 'border-purple-400 bg-purple-500/10 shadow-[0_0_15px_rgba(139,92,246,0.4)] scale-105'
                : 'border-zinc-700 bg-zinc-700/30 hover:border-purple-400 hover:scale-105' }}">
                                <div
                                    class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center shadow-md">
                                    <svg class="w-7 h-7 text-white" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.594-7.305h.003z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-white mt-2 font-medium">Stripe</span>
                            </button>

                        </div>
                    </div>

                    {{-- Pay Now Button --}}
                    <button wire:click="processPayment" wire:loading.attr="disabled" wire:target="processPayment"
                        class="w-full py-4 bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-extrabold text-lg rounded-xl transition-all duration-200 shadow-xl shadow-emerald-500/30 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-emerald-500/50">
                        <span wire:loading.remove wire:target="processPayment">
                            <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Proceed to Payment
                        </span>
                        <span wire:loading wire:target="processPayment" class="flex items-center">
                            <svg class="animate-spin h-6 w-6 mr-2 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing Payment...
                        </span>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
