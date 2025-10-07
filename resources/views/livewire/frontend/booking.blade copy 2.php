<div>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .signature-container canvas {
            border: 1px solid #d1d5db;
            /* Gray 300 */
            border-radius: 0.5rem;
            /* rounded-lg */
            cursor: crosshair;
            touch-action: none;
            /* Important for preventing scroll on touch devices */
        }
    </style>

    <div class="bg-white p-6 shadow-xl rounded-lg max-w-5xl mx-auto my-12">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Process Task Booking</h1>

        <!-- Progress Steps -->
        <div class="mb-12">
            <div class="flex items-center justify-between max-w-4xl mx-auto">
                @php
                $steps = [
                1 => 'Date & Preview',
                2 => 'User Info & Docs',
                3 => 'Payment Options',
                4 => 'Confirmation',
                ];
                @endphp

                @foreach ($steps as $stepNum => $title)
                @php
                $isCurrent = $currentStep === $stepNum;
                $isCompleted = $currentStep > $stepNum;
                $color = $isCompleted ? 'bg-green-500' : ($isCurrent ? 'bg-[#bb8106]' : 'bg-gray-300');
                $textColor = $isCurrent || $isCompleted ? 'text-gray-800 font-semibold' : 'text-gray-500';
                @endphp
                <!-- Step {{ $stepNum }} -->
                <div class="flex flex-col items-center flex-1 {{ $stepNum < 4 ? 'after:content-[\'\'] after:w-full after:h-1 after:bg-gray-200 after:inline-block' : '' }}">
                    <div class="w-10 h-10 rounded-full {{ $color }} flex items-center justify-center text-white mb-2 transition-all duration-300 shadow-md">
                        @if ($isCompleted)
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        @else
                        <span class="text-lg">{{ $stepNum }}</span>
                        @endif
                    </div>
                    <p class="text-sm text-center mt-1 {{ $textColor }}">{{ $title }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Form Container -->
        <form wire:submit.prevent="submit">
            <!-- STEP 1: DATE TIME SELECT & PREVIEW -->
            @if ($currentStep === 1)
            <div class="space-y-6 p-6 border border-gray-200 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-700 border-b pb-3 mb-4">Step 1: Select Date & Time</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label for="selectedDate" class="block text-sm font-medium text-gray-700">Select Start Date</label>
                        <input type="date" id="selectedDate" wire:model.live="selectedDate" min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                        @error('selectedDate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="selectedTime" class="block text-sm font-medium text-gray-700">Select Start Time</label>
                        <select id="selectedTime" wire:model.live="selectedTime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                            <option value="">Select a time</option>
                            @foreach (['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                            @endforeach
                        </select>
                        @error('selectedTime')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rental Days -->
                    <div class="md:col-span-2">
                        <label for="rentalDays" class="block text-sm font-medium text-gray-700">Rental Duration (Days)</label>
                        <input type="number" id="rentalDays" wire:model.live="rentalDays" min="1" max="365" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                        @error('rentalDays')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="mt-8 bg-gray-50 p-4 rounded-lg border">
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">Booking Preview</h3>
                    <dl class="grid grid-cols-2 gap-4 text-sm">
                        <dt class="font-medium text-gray-600">Start Date & Time:</dt>
                        <dd class="text-gray-900">{{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->format('M d, Y') : 'N/A' }} @if ($selectedTime) at {{ $selectedTime }} @endif</dd>

                        <dt class="font-medium text-gray-600">Duration:</dt>
                        <dd class="text-gray-900">{{ $rentalDays }} Day(s)</dd>

                        <dt class="font-medium text-gray-600">Daily Rate:</dt>
                        <dd class="text-gray-900">${{ number_format($dailyPrice, 2) }}</dd>

                        <dt class="font-medium text-gray-600">Subtotal:</dt>
                        <dd class="text-gray-900">${{ number_format($this->subtotal, 2) }}</dd>

                        <dt class="font-medium text-gray-600 border-t pt-2">Security Deposit:</dt>
                        <dd class="text-gray-900 border-t pt-2">${{ number_format($securityDeposit, 2) }}</dd>

                        <dt class="font-bold text-gray-800">Total Upfront Cost:</dt>
                        <dd class="font-bold text-lg text-[#bb8106]">${{ number_format($this->totalCost, 2) }}</dd>
                    </dl>
                </div>
            </div>
            @endif

            <!-- STEP 2: USER INFORMATION & AGREEMENT SIGN -->
            @if ($currentStep === 2)
            <div class="space-y-6 p-6 border border-gray-200 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-700 border-b pb-3 mb-4">Step 2: User Information & Agreement</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phone" wire:model="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <!-- Documentation/Agreement Placeholder -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                            <h4 class="text-lg font-medium text-yellow-800">Rental Agreement Document</h4>
                            <p class="text-sm text-yellow-700">By signing below, you agree to the terms and conditions outlined in the full rental agreement document (T&Cs placeholder).</p>
                        </div>
                    </div>

                    <!-- Digital Signature Pad -->
                    <div class="md:col-span-2 signature-container" x-data="signaturePad()">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Digital Signature</label>

                        <!-- Canvas Area -->
                        <canvas x-ref="signatureCanvas" width="400" height="150" class="w-full max-w-lg bg-white"
                            @mousedown="startDrawing" @mousemove="draw" @mouseup="stopDrawing" @mouseleave="stopDrawing"
                            @touchstart.passive="startDrawing" @touchmove.passive="draw" @touchend.passive="stopDrawing"></canvas>

                        <!-- Hidden Input to store Base64 data and send to Livewire -->
                        <input type="hidden" wire:model="signatureData" :value="signatureData">
                        @error('signatureData')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Controls -->
                        <div class="mt-3 space-x-2">
                            <button type="button" @click="clearSignature" class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                                Clear
                            </button>
                            <button type="button" @click="saveSignature" class="px-3 py-1 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                                Confirm Signature
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500" x-show="signatureData">Signature confirmed. Ready for submission!</p>
                    </div>

                    <!-- Terms Checkbox -->
                    <div class="md:col-span-2 flex items-center pt-4">
                        <input id="termsAccepted" type="checkbox" wire:model="termsAccepted" class="h-4 w-4 text-[#bb8106] border-gray-300 rounded focus:ring-[#bb8106]">
                        <label for="termsAccepted" class="ml-2 block text-sm text-gray-900">I confirm the information is correct and I accept the agreement.</label>
                        @error('termsAccepted')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- STEP 3: PAYMENT OPTIONS -->
            @if ($currentStep === 3)
            <div class="space-y-6 p-6 border border-gray-200 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-700 border-b pb-3 mb-4">Step 3: Select Payment Options</h2>

                <!-- Payment Option Selector -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Choose Payment Method</label>
                    @error('paymentOption')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    @foreach (['card' => 'Credit/Debit Card', 'paypal' => 'PayPal', 'bank' => 'Bank Transfer'] as $value => $label)
                    <div class="flex items-center">
                        <input id="payment-{{ $value }}" name="payment-method" type="radio" wire:model.live="paymentOption" value="{{ $value }}" class="h-4 w-4 text-[#bb8106] border-gray-300 focus:ring-[#bb8106]">
                        <label for="payment-{{ $value }}" class="ml-3 block text-sm font-medium text-gray-700">{{ $label }}</label>
                    </div>
                    @endforeach
                </div>

                <!-- Card Details Form (Conditional) -->
                <div x-show="$wire.paymentOption === 'card'" class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200 transition-all duration-300">
                    <h3 class="text-lg font-semibold mb-4">Card Details</h3>
                    <div class="grid grid-cols-6 gap-4">
                        <!-- Card Name -->
                        <div class="col-span-6">
                            <label for="card-name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                            <input type="text" id="card-name" wire:model="cardName" autocomplete="cc-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                            @error('cardName')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Card Number -->
                        <div class="col-span-6">
                            <label for="card-number" class="block text-sm font-medium text-gray-700">Card Number</label>
                            <input type="text" id="card-number" wire:model="cardNumber" autocomplete="cc-number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                            @error('cardNumber')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry & CVC -->
                        <div class="col-span-3">
                            <label for="card-expiry" class="block text-sm font-medium text-gray-700">Expiration (MM/YY)</label>
                            <input type="text" id="card-expiry" wire:model="cardExpiry" placeholder="01/25" maxlength="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                            @error('cardExpiry')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-3">
                            <label for="card-cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                            <input type="text" id="card-cvc" wire:model="cardCvc" placeholder="123" maxlength="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#bb8106] focus:ring-[#bb8106]">
                            @error('cardCvc')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div x-show="$wire.paymentOption !== 'card'" class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg transition-all duration-300">
                    <p class="text-sm text-blue-800">You selected {{ ucwords($paymentOption) }}. You will receive instructions to complete your payment upon final confirmation.</p>
                </div>

                <!-- Total Due Preview -->
                <div class="mt-8 pt-4 border-t-2 border-dashed">
                    <p class="text-xl font-bold text-gray-800 flex justify-between">
                        <span>Upfront Amount Due:</span>
                        <span class="text-[#bb8106]">${{ number_format($this->totalCost, 2) }}</span>
                    </p>
                </div>
            </div>
            @endif

            <!-- STEP 4: CONFIRMATION & OVERVIEW -->
            @if ($currentStep === 4)
            <div class="space-y-6 p-6 border border-gray-200 rounded-lg">
                <h2 class="text-2xl font-semibold text-gray-700 border-b pb-3 mb-4">Step 4: Review and Confirm</h2>

                @if (session()->has('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                    <span class="font-medium">Success!</span> {{ session('success') }}
                </div>
                @else
                <div class="space-y-8">
                    <!-- Summary Block -->
                    <div class="border p-4 rounded-lg bg-indigo-50">
                        <h3 class="text-xl font-bold text-indigo-800 mb-3">Booking Summary</h3>
                        <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            <dt class="font-medium text-gray-600">Start:</dt>
                            <dd class="text-gray-900">{{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }} at {{ $selectedTime }}</dd>

                            <dt class="font-medium text-gray-600">Duration:</dt>
                            <dd class="text-gray-900">{{ $rentalDays }} Day(s)</dd>

                            <dt class="font-medium text-gray-600">Total Upfront:</dt>
                            <dd class="text-[#bb8106] font-bold">${{ number_format($this->totalCost, 2) }}</dd>
                        </dl>
                    </div>

                    <!-- User Details Block -->
                    <div class="border p-4 rounded-lg">
                        <h3 class="text-xl font-bold text-gray-700 mb-3">Contact & Payment Details</h3>
                        <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            <dt class="font-medium text-gray-600">Customer Name:</dt>
                            <dd class="text-gray-900">{{ $name }}</dd>

                            <dt class="font-medium text-gray-600">Email:</dt>
                            <dd class="text-gray-900">{{ $email }}</dd>

                            <dt class="font-medium text-gray-600">Payment Method:</dt>
                            <dd class="text-gray-900">{{ ucwords($paymentOption) }}</dd>

                            <dt class="font-medium text-gray-600 border-t pt-2">Agreement Status:</dt>
                            <dd class="text-green-600 font-semibold border-t pt-2">Accepted (Signature Captured)</dd>
                        </dl>
                    </div>

                    <!-- Signature Preview (Optional) -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-700 mb-2">Captured Signature:</h4>
                        <img src="{{ $signatureData }}" alt="Digital Signature" class="w-full max-w-xs border border-gray-300 rounded-md">
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between pt-4 border-t">
                @if ($currentStep > 1 && $currentStep < 4)
                    <button type="button" wire:click="previousStep" class="px-6 py-2 border border-gray-300 rounded-full text-gray-700 bg-white hover:bg-gray-50 transition shadow-sm">
                    <span class="inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </span>
                    </button>
                    @else
                    <div class="w-1/4"></div>
                    @endif

                    @if ($currentStep < 4)
                        <button type="button" wire:click="nextStep" class="px-6 py-2 border border-transparent rounded-full text-white bg-[#bb8106] hover:bg-[#a07105] transition shadow-lg disabled:opacity-50" wire:loading.attr="disabled">
                        <span class="inline-flex items-center">
                            Next Step
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                        </button>
                        @elseif ($currentStep === 4 && !session()->has('success'))
                        <button type="submit" class="px-8 py-3 border border-transparent rounded-full text-white bg-green-600 hover:bg-green-700 transition shadow-xl font-bold disabled:opacity-50" wire:loading.attr="disabled">
                            <span class="inline-flex items-center">
                                <svg wire:loading.remove wire:target="submit" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <svg wire:loading wire:target="submit" class="animate-spin w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Confirm Booking
                            </span>
                        </button>
                        @endif
            </div>
        </form>
    </div>

    <!-- Alpine.js script for Signature Pad -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', () => ({
                isDrawing: false,
                lastX: 0,
                lastY: 0,
                ctx: null,
                signatureData: @entangle('signatureData'),

                init() {
                    this.setupCanvas();
                    // Clear canvas on Livewire reset (e.g., successful submission)
                    this.$watch('signatureData', (value) => {
                        if (value === '') {
                            this.clearCanvas();
                        }
                    });
                },

                setupCanvas() {
                    const canvas = this.$refs.signatureCanvas;
                    this.ctx = canvas.getContext('2d');
                    this.ctx.lineWidth = 3;
                    this.ctx.lineCap = 'round';
                    this.ctx.strokeStyle = '#000000';
                    this.clearCanvas(); // Initialize with white background
                },

                getCoordinates(event) {
                    const rect = this.$refs.signatureCanvas.getBoundingClientRect();
                    let x, y;

                    // Handle touch or mouse events
                    if (event.touches) {
                        x = event.touches[0].clientX - rect.left;
                        y = event.touches[0].clientY - rect.top;
                    } else {
                        x = event.clientX - rect.left;
                        y = event.clientY - rect.top;
                    }

                    // Clamp coordinates to stay within the canvas
                    x = Math.max(0, Math.min(x, this.$refs.signatureCanvas.width));
                    y = Math.max(0, Math.min(y, this.$refs.signatureCanvas.height));

                    return {
                        x,
                        y
                    };
                },

                startDrawing(event) {
                    this.isDrawing = true;
                    const coords = this.getCoordinates(event);
                    this.lastX = coords.x;
                    this.lastY = coords.y;
                    // Start new path on mousedown/touchstart
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastX, this.lastY);
                    this.ctx.lineTo(this.lastX + 0.5, this.lastY + 0.5); // Draw tiny dot for clicks
                    this.ctx.stroke();
                },

                draw(event) {
                    if (!this.isDrawing) return;
                    event.preventDefault(); // Prevent scrolling on touch devices during drawing

                    const coords = this.getCoordinates(event);

                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastX, this.lastY);
                    this.ctx.lineTo(coords.x, coords.y);
                    this.ctx.stroke();

                    this.lastX = coords.x;
                    this.lastY = coords.y;
                },

                stopDrawing() {
                    this.isDrawing = false;
                },

                clearCanvas() {
                    this.ctx.clearRect(0, 0, this.$refs.signatureCanvas.width, this.$refs.signatureCanvas.height);
                    // Optionally set a white background to ensure transparency is not an issue when converting to data URL
                    this.ctx.fillStyle = 'white';
                    this.ctx.fillRect(0, 0, this.$refs.signatureCanvas.width, this.$refs.signatureCanvas.height);
                    this.signatureData = ''; // Clear the Livewire model data
                },

                saveSignature() {
                    const canvas = this.$refs.signatureCanvas;
                    this.signatureData = canvas.toDataURL('image/png');
                },
            }))
        })
    </script>
</div>