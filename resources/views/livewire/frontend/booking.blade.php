<div x-data="{
    currentStep: @entangle('currentStep').live,
    rentalRange: @entangle('rentalRange').live,
    termsModalOpen: false,
    signaturePad: null,

    initSignaturePad() {
        const canvas = document.getElementById('signature-pad');
        if (canvas && !this.signaturePad) {
            this.signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1,
                maxWidth: 2.5
            });
            this.resizeCanvas();
        }
    },

    resizeCanvas() {
        const canvas = document.getElementById('signature-pad');
        if (canvas && this.signaturePad) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const rect = canvas.getBoundingClientRect();

            // Set display size (css pixels)
            canvas.style.width = '100%';
            canvas.style.height = '128px';

            // Set actual size in memory (scaled for extra pixel density)
            canvas.width = rect.width * ratio;
            canvas.height = rect.height * ratio;

            // Scale all drawing operations by the ratio
            const ctx = canvas.getContext('2d');
            ctx.scale(ratio, ratio);

            // Set canvas to match its container size
            canvas.getContext('2d').scale(ratio, ratio);

            // Clear and redraw if there was previous data
            this.signaturePad.clear();
        }
    },

    clearSignature() {
        if (this.signaturePad) {
            this.signaturePad.clear();
        }
    },

    acceptTerms() {
        if (this.signaturePad && !this.signaturePad.isEmpty()) {
            const signatureData = this.signaturePad.toDataURL();
            @this.call('saveSignature', signatureData);
            this.termsModalOpen = false;
        } else {
            alert('Please provide your signature before accepting.');
        }
    }
}" x-init="$watch('termsModalOpen', value => {
    if (value) {
        setTimeout(() => {
            initSignaturePad();
        }, 150);
    }
});

window.addEventListener('close-terms-modal', () => {
    termsModalOpen = false;
});

window.addEventListener('resize', () => {
    if (termsModalOpen && signaturePad) {
        resizeCanvas();
    }
});">
    <style>
        [x-cloak] {
            display: none !important;
        }

        .signature-container {
            position: relative;
            width: 100%;
        }

        .signature-container canvas {
            border: 2px solid #d1d5db;
            border-radius: 8px;
            cursor: crosshair;
            touch-action: none;
            width: 100%;
            height: 128px;
            display: block;
        }
    </style>
    <!-- Include Signature Pad Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.7/signature_pad.umd.min.js"></script>


    <div class="bg-gray-50">
        <!-- Main Content - Two Column Layout -->
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-semibold mb-8">Reserve Your Car</h1>

            <!-- Progress Steps -->
            <div class="mb-12">
                <div class="flex items-center justify-between max-w-4xl mx-auto">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 h-8 rounded-full bg-zinc-500 flex items-center justify-center text-white mb-2">
                            <flux:icon name="check" class="w-5 h-5 stroke-white" />
                        </div>
                        <span class="text-xs md:text-sm font-medium">Rental</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 -mx-4"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-white mb-2 {{ $currentStep >= 2 ? 'bg-zinc-500' : 'bg-gray-300' }}">
                            @if ($currentStep > 2)
                                <flux:icon name="check" class="w-5 h-5 stroke-white" />
                            @else
                                <span class="text-sm font-semibold {{ $currentStep >= 2 ? 'text-white' : '' }}">2</span>
                            @endif
                        </div>
                        <span class="text-xs md:text-sm font-medium"
                            :class="currentStep >= 2 ? '' : 'text-gray-500'">Review</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 -mx-4"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-white mb-2 {{ $currentStep >= 3 ? 'bg-zinc-500' : 'bg-gray-300' }}">
                            @if ($currentStep > 3)
                                <flux:icon name="check" class="w-5 h-5 stroke-white" />
                            @else
                                <span class="text-sm font-semibold {{ $currentStep >= 3 ? 'text-white' : '' }}">3</span>
                            @endif
                        </div>
                        <span class="text-xs md:text-sm">Checkout</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 -mx-4"></div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-white mb-2 {{ $currentStep >= 4 ? 'bg-zinc-500' : 'bg-gray-300' }}">
                            @if ($currentStep > 4)
                                <flux:icon name="check" class="w-5 h-5 stroke-white" />
                            @else
                                <span class="text-sm font-semibold {{ $currentStep >= 4 ? 'text-white' : '' }}">4</span>
                            @endif
                        </div>
                        <span class="text-xs md:text-sm text-gray-500">Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Sidebar - Car Details -->
                <div class="rounded-lg p-6 lg:col-span-1">
                    <h2 class="text-xl font-semibold mb-6">Car Details</h2>

                    <div class="flex gap-4 mb-6">
                        <img src="{{ storage_url($vehicle?->images?->first()?->image) }}" alt="2020 Nissan Rogue"
                            class="w-32 h-24 object-cover rounded-lg">
                        <div>
                            <h3 class="font-semibold text-lg">{{ $vehicle?->title ?? 'Unknown' }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $vehicle?->relations?->first()?->make?->name ?? 'make' }} -
                                {{ $vehicle?->relations?->first()?->model?->name ?? 'model' }}
                            </p>
                        </div>
                    </div>

                    <h3 class="font-semibold mb-4">Payment Frequency</h3>
                    <div class="flex gap-4 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="range" value="weekly" x-on:click="rentalRange = 'weekly'"
                                class="w-4 h-4" checked>
                            <span class="ml-2">Weekly</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="range" value="monthly" x-on:click="rentalRange = 'monthly'"
                                class="w-4 h-4">
                            <span class="ml-2">Monthly</span>
                        </label>
                    </div>

                    <p class="text-sm text-gray-600 italic mb-6">Book for any duration but make micropayments everyday
                        or weekly.</p>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Upfront payment</span>
                            <span class="font-semibold"
                                x-show="rentalRange == 'weekly' ? true : false">${{ $upfrontAmountWeekly }}</span>
                            <span class="font-semibold"
                                x-show="rentalRange == 'monthly' ? true : false">${{ $upfrontAmountMonthly }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Rental Cost </span>
                            <span x-show="rentalRange == 'weekly' ? true : false">${{ $vehicle?->weekly_rate }}</span>
                            <span
                                x-show="rentalRange == 'monthly' ? true : false">${{ $vehicle?->monthly_rate }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-4">
                            <span>Security Deposit</span>
                            <span
                                x-show="rentalRange == 'weekly' ? true : false">${{ $vehicle?->security_deposit_weekly }}</span>
                            <span
                                x-show="rentalRange == 'monthly' ? true : false">${{ $vehicle?->security_deposit_monthly }}</span>
                        </div>
                    </div>

                    <div x-data="{ contactModalOpen: false }">
                        <button @click="contactModalOpen = true"
                            class="w-full bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition mb-4">
                            Check Availability
                        </button>

                        <div x-show="contactModalOpen" x-cloak x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
                            class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center p-4 sm:p-6 z-50"
                            @click.self="contactModalOpen = false">

                            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full" @click.stop>

                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-center">
                                        <h2 class="text-xl font-semibold text-gray-800">
                                            {{ Str::limit($vehicle?->title, 15) ?? 'Unknown' }}
                                        </h2>
                                        <button @click="contactModalOpen = false"
                                            class="text-gray-500 hover:text-gray-700 transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="p-4 space-y-4">
                                    <div class="mb-4">
                                        <img src="{{ storage_url($vehicle?->images?->first()?->image) }}"
                                            alt="{{ $vehicle?->title ?? 'Unknown' }}"
                                            class="w-full h-auto object-contain rounded-lg shadow-md max-h-56">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <x-input type="text" placeholder="Enter name"
                                            value="{{ user()->name ?? '' }}" />
                                        <x-input type="text" placeholder="Phone Number"
                                            value="{{ user()->phone ?? '' }}" />
                                    </div>

                                    <x-input type="email" placeholder="Enter email"
                                        value="{{ user()->email ?? '' }}" />

                                    <textarea placeholder="Enter message" rows="4"
                                        class="textarea w-full px-4 py-2.5 bg-transparent border border-zinc-200 shadow rounded-lg focus:ring-0 focus:outline-2 focus:outline-zinc-500 transition resize-none"></textarea>

                                    <div class="flex items-start space-x-3 pt-2">
                                        <input id="sms-alert" type="checkbox" class="checkbox" />
                                        <label for="sms-alert" class="text-xs text-gray-700">
                                            Yes, I'd like to receive SMS alerts from Fairpy rental for booking
                                            confirmations,
                                            payment updates, support messages, and important reminders.
                                            <span class="block text-gray-500 mt-0.5">
                                                Message and data rates may apply. Reply STOP to unsubscribe.
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-4 border-t">
                                    <button
                                        class="w-full bg-zinc-500 text-white py-3 rounded-lg hover:bg-zinc-500 transition font-medium">
                                        Get in touch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600">
                        {{ $vehicle?->description }}
                    </p>
                </div>

                <!-- Right Content - Forms -->
                <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
                    @switch($currentStep)
                        {{-- STEP 2: Trip Date & Time Section --}}
                        @case(2)
                            <div>
                                <h2 class="text-xl font-semibold mb-6">Trip Date & Time</h2>

                                @if ($errors->has('dateRange'))
                                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                        <p class="text-red-600 text-sm">{{ $errors->first('dateRange') }}</p>
                                    </div>
                                @endif

                                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-700">
                                        <strong>Note:</strong>
                                        <span x-show="rentalRange === 'weekly'">
                                            Weekly rentals are for 7 days. Select your pickup date and the return date will be
                                            automatically set.
                                        </span>
                                        <span x-show="rentalRange === 'monthly'">
                                            Monthly rentals are for 30 days. Select your pickup date and the return date will be
                                            automatically set.
                                        </span>
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <label class="block space-y-2">
                                        <span class="text-sm font-medium">Pickup Date <span
                                                class="text-red-500">*</span></span>
                                        <x-input type="date" wire:model.live="pickupDate" min="{{ date('Y-m-d') }}"
                                            placeholder="Select pickup date" />
                                        @error('pickupDate')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </label>

                                    <label class="block space-y-2">
                                        <span class="text-sm font-medium">Pickup Time <span
                                                class="text-red-500">*</span></span>
                                        <x-input type="time" wire:model.live="pickupTime" />
                                        @error('pickupTime')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <label class="block space-y-2">
                                        <span class="text-sm font-medium">Return Date <span
                                                class="text-red-500">*</span></span>
                                        <x-input type="date" wire:model="returnDate" readonly
                                            class="bg-gray-100 cursor-not-allowed" placeholder="Auto-calculated" />
                                        @error('returnDate')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </label>

                                    <label class="block space-y-2">
                                        <span class="text-sm font-medium">Return Time <span
                                                class="text-red-500">*</span></span>
                                        <x-input type="time" wire:model.live="returnTime" />
                                        @error('returnTime')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                @if (!empty($pickupDate) && !empty($returnDate))
                                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                        <p class="text-sm text-green-700">
                                            <strong>Rental Duration:</strong>
                                            {{ \Carbon\Carbon::parse($pickupDate)->format('M d, Y') }}
                                            to
                                            {{ \Carbon\Carbon::parse($returnDate)->format('M d, Y') }}
                                            ({{ \Carbon\Carbon::parse($pickupDate)->diffInDays(\Carbon\Carbon::parse($returnDate)) }}
                                            days)
                                        </p>
                                    </div>
                                @endif

                                <div class="flex gap-4 flex-col sm:flex-row mt-6">
                                    <button wire:click="nextStep" type="button"
                                        class="flex-1 bg-zinc-500 text-white py-3 rounded-lg hover:bg-zinc-600 transition font-medium">
                                        Continue Booking
                                    </button>
                                    <a href="{{ route('product-details', $vehicle->slug) }}" wire:navigate
                                        class="block text-center flex-1 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                                        Back to Car Details
                                    </a>
                                </div>
                            </div>
                        @break

                        @case(3)
                            <div>
                                <h2 class="text-xl font-semibold mb-6">Verification Documents</h2>

                                <form wire:submit.prevent="saveVerificationData">
                                    <!-- File Upload Sections -->
                                    <div x-data="{
                                        handleFileChange(event, wirePropertyName) {
                                            const file = event.target.files[0];
                                            if (file) {
                                                @this.upload(wirePropertyName, file);
                                            }
                                        }
                                    }">

                                        <!-- License Upload -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium mb-2">Driver's License</label>
                                            <div
                                                class="border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-zinc-500 transition cursor-pointer relative p-6">
                                                <input type="file" wire:model="license"
                                                    class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">

                                                <div wire:loading.remove wire:target="license">
                                                    @if ($license)
                                                        <div class="relative group">
                                                            <img src="{{ $license->temporaryUrl() }}" alt="License Preview"
                                                                class="w-full h-auto max-h-48 object-contain rounded-md">
                                                            <button type="button" wire:click="$set('license', null)"
                                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <p class="text-gray-600 text-sm">Drag & drop your License here, or
                                                            Click to Select</p>
                                                    @endif
                                                </div>

                                                <div wire:loading wire:target="license" class="text-zinc-500">
                                                    <svg class="animate-spin h-8 w-8 mx-auto"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-sm mt-2">Uploading...</p>
                                                </div>
                                            </div>
                                            @error('license')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Selfie Upload with Camera -->

                                        <!-- Selfie Upload with Camera -->
                                        <div class="mb-6" x-data="{
                                            showCamera: false,
                                            videoStream: null,
                                            capturedImage: null,
                                        
                                            async startCamera() {
                                                this.showCamera = true;
                                                this.capturedImage = null;
                                        
                                                try {
                                                    const stream = await navigator.mediaDevices.getUserMedia({
                                                        video: { facingMode: 'user' },
                                                        audio: false
                                                    });
                                                    this.videoStream = stream;
                                        
                                                    this.$nextTick(() => {
                                                        const video = this.$refs.video;
                                                        if (video) {
                                                            video.srcObject = stream;
                                                        }
                                                    });
                                                } catch (error) {
                                                    alert('Unable to access camera: ' + error.message);
                                                    this.showCamera = false;
                                                }
                                            },
                                        
                                            stopCamera() {
                                                if (this.videoStream) {
                                                    this.videoStream.getTracks().forEach(track => track.stop());
                                                    this.videoStream = null;
                                                }
                                                this.showCamera = false;
                                            },
                                        
                                            capturePhoto() {
                                                const video = this.$refs.video;
                                                const canvas = this.$refs.canvas;
                                                const context = canvas.getContext('2d');
                                        
                                                canvas.width = video.videoWidth;
                                                canvas.height = video.videoHeight;
                                                context.drawImage(video, 0, 0);
                                        
                                                canvas.toBlob((blob) => {
                                                    const file = new File([blob], 'selfie.jpg', { type: 'image/jpeg' });
                                                    @this.upload('selfie', file);
                                                    this.capturedImage = canvas.toDataURL('image/jpeg');
                                                    this.stopCamera();
                                                }, 'image/jpeg', 0.9);
                                            },
                                        
                                            retakePhoto() {
                                                this.capturedImage = null;
                                                @this.set('selfie', null);
                                            }
                                        }">
                                            <label class="block text-sm font-medium mb-2">Selfie with License</label>

                                            <div
                                                class="border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-zinc-500 transition relative p-6">

                                                <!-- File Input (Hidden when camera is active) -->
                                                {{-- <input type="file" wire:model="selfie"
                                                    class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*"
                                                    x-show="!showCamera"> --}}

                                                <!-- Default State / Preview -->
                                                <div wire:loading.remove wire:target="selfie" x-show="!showCamera">
                                                    @if ($selfie)
                                                        <div class="relative group">
                                                            <img src="{{ $selfie->temporaryUrl() }}" alt="Selfie Preview"
                                                                class="w-full h-auto max-h-48 object-contain rounded-md">
                                                            <button type="button" wire:click="$set('selfie', null)"
                                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition z-20">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <p class="text-gray-600 text-sm mb-3">Drag & drop your Selfie here,
                                                                or Click to Select</p>
                                                            <button type="button" @click.prevent="startCamera()"
                                                                class="inline-flex items-center px-4 py-2 bg-zinc-500 text-white rounded-lg hover:bg-zinc-600 transition text-sm font-medium z-20 relative">
                                                                <svg class="w-5 h-5 mr-2" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                                    </path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z">
                                                                    </path>
                                                                </svg>
                                                                Take Photo with Camera
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Camera View -->
                                                <div x-show="showCamera" x-cloak class="space-y-4">
                                                    <div class="relative bg-black rounded-lg overflow-hidden">
                                                        <video x-ref="video" autoplay playsinline
                                                            class="w-full max-h-96 object-contain">
                                                        </video>
                                                        <canvas x-ref="canvas" class="hidden"></canvas>
                                                    </div>

                                                    <div class="flex gap-3 justify-center">
                                                        <button type="button" @click="capturePhoto()"
                                                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                                            <svg class="w-5 h-5 inline mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                            </svg>
                                                            Capture
                                                        </button>
                                                        <button type="button" @click="stopCamera()"
                                                            class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Upload Loading State -->
                                                <div wire:loading wire:target="selfie" class="text-zinc-500">
                                                    <svg class="animate-spin h-8 w-8 mx-auto"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-sm mt-2">Uploading...</p>
                                                </div>
                                            </div>

                                            @error('selfie')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <!-- Address Proof Upload -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium mb-2">Address Proof</label>
                                            <div
                                                class="border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-zinc-500 transition cursor-pointer relative p-6">
                                                <input type="file" wire:model="addressProof"
                                                    class="absolute inset-0 opacity-0 cursor-pointer"
                                                    accept="image/*,application/pdf">

                                                <div wire:loading.remove wire:target="addressProof">
                                                    @if ($addressProof)
                                                        <div class="relative group">
                                                            @if (str_contains($addressProof->getMimeType(), 'pdf'))
                                                                <div class="text-center">
                                                                    <i class="fas fa-file-pdf text-4xl text-red-500 mb-2"></i>
                                                                    <p class="text-sm">
                                                                        {{ $addressProof->getClientOriginalName() }}</p>
                                                                </div>
                                                            @else
                                                                <img src="{{ $addressProof->temporaryUrl() }}"
                                                                    alt="Address Proof Preview"
                                                                    class="w-full h-auto max-h-48 object-contain rounded-md">
                                                            @endif
                                                            <button type="button" wire:click="$set('addressProof', null)"
                                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <p class="text-gray-600 text-sm">Drag & drop your Address Proof here,
                                                            or Click to Select</p>
                                                    @endif
                                                </div>

                                                <div wire:loading wire:target="addressProof" class="text-zinc-500">
                                                    <svg class="animate-spin h-8 w-8 mx-auto"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                                            stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-sm mt-2">Uploading...</p>
                                                </div>
                                            </div>
                                            @error('addressProof')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Billing Information -->
                                    <h3 class="font-semibold mb-4">Billing Information</h3>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <input wire:model="firstName" type="text" placeholder="First Name" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('firstName')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input wire:model="lastName" type="text" placeholder="Last Name" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('lastName')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <input wire:model="email" type="email" placeholder="Email" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('email')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input wire:model="dob" type="date" placeholder="Date of Birth" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('dob')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Residential Address -->
                                    <h3 class="font-semibold mb-4 mt-6">Residential Address</h3>
                                    <div class="mb-4">
                                        <input wire:model="address" type="text" placeholder="Street Address" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                        @error('address')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <input wire:model="city" type="text" placeholder="City" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('city')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input wire:model="state" type="text" placeholder="State" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('state')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input wire:model="zip" type="text" placeholder="Zip Code" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                            @error('zip')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Car Parking Location -->
                                    <h3 class="font-semibold mb-4 mt-6">Car Parking Location</h3>
                                    <label class="flex items-center mb-4 cursor-pointer">
                                        <input wire:model.live="sameAsResidential" type="checkbox"
                                            class="w-4 h-4 text-zinc-500 rounded">
                                        <span class="ml-2 text-sm text-gray-600">Same as Residential Address</span>
                                    </label>
                                    <div class="mb-4">
                                        <input wire:model="parkingAddress" type="text" placeholder="Parking Address"
                                            :disabled="$wire.sameAsResidential"
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                                        @error('parkingAddress')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                                        <div>
                                            <input wire:model="parkingCity" type="text" placeholder="City"
                                                :disabled="$wire.sameAsResidential"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                                            @error('parkingCity')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input wire:model="parkingState" type="text" placeholder="State"
                                                :disabled="$wire.sameAsResidential"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                                            @error('parkingState')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input wire:model="parkingZip" type="text" placeholder="Zip"
                                                :disabled="$wire.sameAsResidential"
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                                            @error('parkingZip')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Terms & Conditions -->
                                    <div class="mb-6">
                                        <label class="flex items-start mb-3 cursor-pointer">
                                            <input wire:model="termsAccepted" type="checkbox"
                                                @click.prevent="termsModalOpen = true"
                                                class="w-4 h-4 text-zinc-500 rounded mt-1">
                                            <span class="ml-2 text-sm text-gray-700">
                                                I have Read and Accept Terms & Conditions
                                                <span class="text-red-500">*</span>
                                                @if ($termsAccepted)
                                                    <span class="text-green-600 font-semibold ml-2">✓ Accepted</span>
                                                @endif
                                            </span>
                                        </label>
                                        @error('termsAccepted')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- SMS Alerts -->
                                    <label class="flex items-start mb-6 cursor-pointer">
                                        <input wire:model="smsAlerts" type="checkbox"
                                            class="w-4 h-4 text-zinc-500 rounded mt-1">
                                        <span class="ml-2 text-sm text-gray-600">
                                            Yes, I'd like to receive SMS alerts from Fairental for booking confirmations,
                                            payment updates, support messages, and important reminders.
                                            <span class="italic">Message and data rates may apply. Reply STOP to
                                                unsubscribe.</span>
                                        </span>
                                    </label>

                                    <div class="flex gap-4 flex-col sm:flex-row">
                                        <button type="submit" wire:loading.attr="disabled"
                                            class="flex-1 bg-zinc-500 text-white py-3 rounded-lg hover:bg-zinc-600 transition font-medium disabled:opacity-50">
                                            <span wire:loading.remove wire:target="saveVerificationData">Confirm &
                                                Proceed</span>
                                            <span wire:loading wire:target="saveVerificationData">Processing...</span>
                                        </button>
                                        <button type="button" wire:click="previousStep"
                                            class="flex-1 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                                            Back to Booking Review
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @break

                        @case(4)
                            <div x-data="{
                                paymentMethod: 'paypal',
                                rentalRange: 'weekly',
                                upfrontAmountWeekly: 550,
                                upfrontAmountMonthly: 2100,
                                vehicle: {
                                    title: 'Toyota Camry 2023',
                                    weekly_rate: 400,
                                    monthly_rate: 1500,
                                    security_deposit_weekly: 150,
                                    security_deposit_monthly: 600
                                }
                            }" class="max-w-2xl mx-auto">
                                <h2 class="text-xl font-semibold mb-6">Payment Details</h2>

                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <h4 class="font-semibold mb-2">Booking Summary</h4>
                                    <p class="text-sm text-gray-600" x-text="vehicle.title"></p>
                                    <p class="text-sm text-gray-600">Oct 10 - Oct 17, 2025</p>
                                    <div class="border-t mt-3 pt-3">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Rental Cost</span>
                                            <span x-show="rentalRange == 'weekly'" x-text="`$${vehicle.weekly_rate}`"></span>
                                            <span x-show="rentalRange == 'monthly'"
                                                x-text="`$${vehicle.monthly_rate}`"></span>
                                        </div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Security Deposit</span>
                                            <span x-show="rentalRange == 'weekly'"
                                                x-text="`$${vehicle.security_deposit_weekly}`"></span>
                                            <span x-show="rentalRange == 'monthly'"
                                                x-text="`$${vehicle.security_deposit_monthly}`"></span>
                                        </div>
                                        <div class="flex justify-between font-semibold mt-2 pt-2 border-t">
                                            <span>Total Due Now</span>
                                            <span x-show="rentalRange == 'weekly'" x-text="`$${upfrontAmountWeekly}`"></span>
                                            <span x-show="rentalRange == 'monthly'"
                                                x-text="`$${upfrontAmountMonthly}`"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 bg-white rounded-xl shadow-xl">
                                    <h2 class="text-2xl font-bold text-center mb-6">Select Payment Method</h2>

                                    <div class="space-y-4 mb-8">
                                        <label @click="paymentMethod = 'paypal'"
                                            class="flex items-center p-4 border rounded-lg cursor-pointer transition duration-150 ease-in-out"
                                            :class="{
                                                'border-zinc-500 ring-2 ring-zinc-200 bg-zinc-50': paymentMethod === 'paypal',
                                                'border-gray-300 hover:border-zinc-400': paymentMethod !== 'paypal'
                                            }">
                                            <input type="radio" name="payment_method" value="paypal" class="hidden" />
                                            <svg class="w-6 h-6 mr-3 text-zinc-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M7.746 17.616c.158 0 .285-.12.285-.265 0-.146-.127-.265-.285-.265h-.546c-2.43 0-4.498-1.574-4.708-3.793h.606c.157 0 .285-.12.285-.264 0-.145-.128-.265-.285-.265h-.64c.21-2.218 2.278-3.792 4.708-3.792h.546c.158 0 .285-.12.285-.265 0-.146-.127-.265-.285-.265h-.546C4.846 9.07 2.76 10.644 2.55 12.863h-.606c-.157 0-.285.12-.285.264 0 .146.128.265.285.265h.64c-.21 2.219 1.858 3.793 4.288 3.793h.546zM15.5 6.784h-3.414c-.158 0-.285.12-.285.265 0 .145.127.265.285.265h3.414c1.13 0 2.05.918 2.05 2.046v.818c0 .145.128.265.285.265s.285-.12.285-.265v-.818c0-1.442-1.17-2.614-2.614-2.614zM21.5 10.74c-.158 0-.285.12-.285.265v1.637c0 .145.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM15.5 13.99c-.158 0-.285.12-.285.265v1.637c0 .146.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM17.616 12.364c-.158 0-.285.12-.285.265v1.637c0 .146.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM19.73 10.24c-.158 0-.285.12-.285.265v1.637c0 .145.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM12.086 17.616c.158 0 .285-.12.285-.265 0-.146-.127-.265-.285-.265h-2.14c-1.13 0-2.05-.918-2.05-2.046v-.818c0-.145-.128-.265-.285-.265s-.285.12-.285.265v.818c0 1.442 1.17 2.614 2.614 2.614h2.14zM10.5 6.784c-.158 0-.285.12-.285.265v1.637c0 .145.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM8.384 10.74c.158 0 .285.12.285.265v1.637c0 .145-.127.265-.285.265s-.285-.12-.285-.265v-1.637c0-.145.127-.265.285-.265zM10.5 13.99c-.158 0-.285.12-.285.265v1.637c0 .146.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM12.616 10.24c.158 0 .285.12.285.265v1.637c0 .145-.127.265-.285.265s-.285-.12-.285-.265v-1.637c0-.145.127-.265.285-.265zM14.73 13.49c.158 0 .285.12.285.265v1.637c0 .146-.127-.265-.285-.265s-.285-.12-.285-.265v-1.637c0-.145.127-.265.285-.265zM16.846 9.74c-.158 0-.285.12-.285.265v1.637c0 .145.127.265.285.265s.285-.12.285-.265v-1.637c0-.145-.127-.265-.285-.265zM18.96 13.99c.158 0 .285-.12.285-.265 0-.146-.127-.265-.285-.265h-2.14c-1.13 0-2.05-.918-2.05-2.046v-.818c0-.145-.128-.265-.285-.265s-.285.12-.285.265v.818c0 1.442 1.17 2.614 2.614 2.614h2.14z">
                                                </path>
                                            </svg>
                                            <span class="font-semibold text-gray-800">Pay with PayPal</span>
                                        </label>

                                        <label @click="paymentMethod = 'stripe'"
                                            class="flex items-center p-4 border rounded-lg cursor-pointer transition duration-150 ease-in-out"
                                            :class="{
                                                'border-zinc-500 ring-2 ring-zinc-200 bg-zinc-50': paymentMethod === 'stripe',
                                                'border-gray-300 hover:border-zinc-400': paymentMethod !== 'stripe'
                                            }">
                                            <input type="radio" name="payment_method" value="stripe" class="hidden" />
                                            <svg class="w-6 h-6 mr-3 text-zinc-600" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1.615 15.35c-2.43 0-4.62-.977-6.077-2.756a.75.75 0 0 1 1.184-.937c1.175 1.48 3.003 2.378 4.893 2.378 2.06 0 3.73-.83 3.73-2.222 0-1.258-1.077-1.896-3.17-2.52l-1.058-.328c-2.26-.7-4.13-1.85-4.13-4.116 0-2.302 2.15-3.868 4.793-3.868 2.35 0 4.31.956 5.61 2.39a.75.75 0 0 1-1.157.96c-1.085-1.29-2.77-2.025-4.453-2.025-1.87 0-3.395.786-3.395 1.955 0 1.096.953 1.637 2.924 2.253l1.057.327c2.4.742 4.09 1.96 4.09 4.254 0 2.457-2.215 4.148-5.116 4.148z">
                                                </path>
                                            </svg>
                                            <span class="font-semibold text-gray-800">Pay with Stripe</span>
                                        </label>
                                    </div>

                                    {{-- <div x-show="paymentMethod === 'stripe'" x-transition
                                        class="mt-4 p-4 border border-purple-300 bg-purple-50 rounded-lg">
                                        <p class="text-sm text-gray-700 font-medium">
                                            Card details entry would go here (e.g., Stripe Elements).
                                        </p>
                                    </div> --}}

                                    <div class="mt-6">
                                        <button type="submit"
                                            class="w-full bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition font-medium">
                                            <span>
                                                Complete Booking - $
                                                <span x-show="rentalRange == 'weekly'" x-text="upfrontAmountWeekly"></span>
                                                <span x-show="rentalRange == 'monthly'" x-text="upfrontAmountMonthly"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @break

                        @default
                            <div class="text-center py-12">
                                <h2 class="text-2xl font-semibold mb-4">Something went wrong</h2>
                                <p class="text-gray-600">Please try again later.</p>
                            </div>
                    @endswitch
                </div>
            </div>
        </div>
    </div>

    <!-- Terms & Conditions Modal -->
    <div x-show="termsModalOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50"
        @click.self="termsModalOpen = false">

        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col"
            @click.stop x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            <!-- Modal Header -->
            <div class="p-6 border-b sticky top-0 bg-white z-10">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Preliminary Agreement</h2>
                    <button @click="termsModalOpen = false" class="text-gray-500 hover:text-gray-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body - Scrollable Content -->
            <div class="p-6 overflow-y-auto flex-1">
                <!-- Logo and Title -->
                <div class="text-center mb-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">FAIRPY RENTAL CAR AGREEMENT</h3>
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Fairental Logo" class="h-16">
                    </div>
                </div>

                <!-- Terms and Conditions Section -->
                <div class="mb-6">
                    <h4 class="font-bold text-lg mb-3 text-gray-800">Terms and Conditions</h4>
                </div>

                <!-- Rental Information -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-bold text-md mb-3 text-gray-800">Rental Information</h4>

                    <div class="space-y-2 text-sm">
                        <p><span class="font-semibold">Rental Period</span></p>
                        <p>• Start:
                            {{ !empty($pickupDate) && !empty($pickupTime) ? \Carbon\Carbon::parse($pickupDate . ' ' . $pickupTime)->format('m-d-Y H:i') : 'TBD' }}
                        </p>
                        <p>• End:
                            {{ !empty($returnDate) && !empty($returnTime) ? \Carbon\Carbon::parse($returnDate . ' ' . $returnTime)->format('m-d-Y H:i') : 'TBD' }}
                        </p>

                        <p class="mt-3">
                            <span class="font-semibold">Booking Price:</span>
                            <span x-show="rentalRange == 'weekly'">${{ $vehicle?->weekly_rate ?? 0 }} / Day (Weekly
                                Plan)</span>
                            <span x-show="rentalRange == 'monthly'">${{ $vehicle?->monthly_rate ?? 0 }} / Day (Monthly
                                Plan)</span>
                        </p>

                        <p>
                            <span class="font-semibold">Rental Payment Plan:</span>
                            <span x-text="rentalRange == 'weekly' ? 'Weekly' : 'Monthly'"></span>
                        </p>

                        <p>
                            <span class="font-semibold">Security Deposit:</span>
                            <span
                                x-show="rentalRange == 'weekly'">${{ $vehicle?->security_deposit_weekly ?? 0 }}</span>
                            <span
                                x-show="rentalRange == 'monthly'">${{ $vehicle?->security_deposit_monthly ?? 0 }}</span>
                        </p>

                        <p><span class="font-semibold">Pickup Location:</span>
                            {{ $vehicle?->pickup_location ?? '4425 W Airport Fwy Irving TX 75062' }}</p>
                    </div>
                </div>

                <!-- Vehicle & Pickup Details -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-bold text-md mb-3 text-gray-800">Vehicle & Pickup Details</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="space-y-2 text-sm">
                                <p>• <span class="font-semibold">Make:</span>
                                    {{ $vehicle?->relations?->first()?->make?->name ?? 'N/A' }}</p>
                                <p>• <span class="font-semibold">Model:</span>
                                    {{ $vehicle?->relations?->first()?->model?->name ?? 'N/A' }}</p>
                                <p>• <span class="font-semibold">Year:</span> {{ $vehicle?->year ?? 'N/A' }}</p>
                                <p>• <span class="font-semibold">Color:</span> {{ $vehicle?->color ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            @if ($vehicle?->images?->first()?->image)
                                <img src="{{ storage_url($vehicle->images->first()->image) }}"
                                    alt="{{ $vehicle?->title }}"
                                    class="w-full h-48 object-cover rounded-lg shadow-md">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Uploaded Documents -->
                @if ($license || $selfie || $addressProof)
                    <div class="mb-6">
                        <h4 class="font-bold text-md mb-3 text-gray-800">Your Uploaded Documents</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if ($license)
                                <div class="border rounded-lg p-3">
                                    <p class="text-xs font-semibold mb-2 text-gray-600">Driver's License</p>
                                    <img src="{{ $license->temporaryUrl() }}" alt="License"
                                        class="w-full h-32 object-cover rounded">
                                </div>
                            @endif
                            @if ($selfie)
                                <div class="border rounded-lg p-3">
                                    <p class="text-xs font-semibold mb-2 text-gray-600">Selfie with License</p>
                                    <img src="{{ $selfie->temporaryUrl() }}" alt="Selfie"
                                        class="w-full h-32 object-cover rounded">
                                </div>
                            @endif
                            @if ($addressProof)
                                <div class="border rounded-lg p-3">
                                    <p class="text-xs font-semibold mb-2 text-gray-600">Address Proof</p>
                                    @if (str_contains($addressProof->getMimeType(), 'pdf'))
                                        <div class="flex items-center justify-center h-32 bg-gray-100 rounded">
                                            <i class="fas fa-file-pdf text-4xl text-red-500"></i>
                                        </div>
                                    @else
                                        <img src="{{ $addressProof->temporaryUrl() }}" alt="Address Proof"
                                            class="w-full h-32 object-cover rounded">
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Detailed Terms Content -->
                <div class="mb-6 text-sm text-gray-700 space-y-4">
                    <h4 class="font-bold text-md text-gray-800">Agreement Terms</h4>

                    <p><span class="font-semibold">1. RENTAL AGREEMENT:</span> This agreement is entered into between
                        Fairpy Inc ("Owner") and {{ $firstName }} {{ $lastName }} ("Renter") for the rental of
                        the vehicle described above.</p>

                    <p><span class="font-semibold">2. PAYMENT:</span> The Renter agrees to pay the rental fees as
                        specified. Payment is due according to the selected payment plan (weekly or monthly). Late
                        payments may result in additional fees and/or termination of the rental agreement.</p>

                    <p><span class="font-semibold">3. SECURITY DEPOSIT:</span> A refundable security deposit is
                        required at the time of pickup. The deposit will be refunded within 7-14 business days after the
                        vehicle is returned in good condition, subject to inspection.</p>

                    <p><span class="font-semibold">4. INSURANCE:</span> The Renter must maintain valid auto insurance
                        coverage for the entire rental period. Proof of insurance must be provided before vehicle
                        pickup.</p>

                    <p><span class="font-semibold">5. VEHICLE CONDITION:</span> The Renter agrees to return the vehicle
                        in the same condition as received, normal wear and tear excepted. Any damage beyond normal wear
                        and tear will be charged to the Renter.</p>

                    <p><span class="font-semibold">6. PROHIBITED USES:</span> The vehicle shall not be used for: (a)
                        illegal purposes; (b) racing or speed contests; (c) towing; (d) transporting hazardous
                        materials; (e) off-road driving; (f) driving under the influence of alcohol or drugs.</p>

                    <p><span class="font-semibold">7. MAINTENANCE:</span> The Renter is responsible for checking oil,
                        tire pressure, and other fluid levels regularly. Any mechanical issues must be reported
                        immediately to the Owner.</p>

                    <p><span class="font-semibold">8. ACCIDENTS & DAMAGES:</span> In the event of an accident, the
                        Renter must: (a) notify police if required by law; (b) notify the Owner immediately; (c) provide
                        a complete accident report; (d) not admit fault or liability.</p>

                    <p><span class="font-semibold">9. RETURN:</span> The vehicle must be returned on or before the
                        return date and time specified. Late returns will incur additional charges. The vehicle must be
                        returned with the same fuel level as at pickup.</p>

                    <p><span class="font-semibold">10. TERMINATION:</span> The Owner reserves the right to terminate
                        this agreement and repossess the vehicle if the Renter breaches any terms, including non-payment
                        or misuse of the vehicle.</p>

                    <p><span class="font-semibold">11. LIABILITY:</span> The Renter assumes full responsibility for any
                        traffic violations, parking tickets, toll charges, and any other charges or damages incurred
                        during the rental period.</p>

                    <p class="font-semibold mt-6">IN WITNESS WHEREOF, the parties hereto have executed this Agreement
                        as of the date set forth below.</p>
                </div>

                <!-- Signatures Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Owner Signature -->
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <h5 class="font-bold text-sm mb-3">ACCEPTED BY OWNER:</h5>
                        <p class="text-sm mb-1"><span class="font-semibold">Name:</span> Fairpy INC</p>
                        <p class="text-sm mb-1"><span class="font-semibold">Date:</span> {{ date('m-d-Y') }}</p>
                        <div class="mt-3">
                            <p class="text-sm font-semibold mb-2">Signature:</p>
                            <div class="border bg-white p-2 rounded h-32 flex items-center justify-center">
                                <img src="{{ asset('images/owner-signature.png') }}" alt="Owner Signature"
                                    class="h-full object-contain">
                            </div>
                        </div>
                    </div>

                    <!-- Renter Signature - FIXED -->
                    <div class="border rounded-lg p-4 bg-blue-50">
                        <h5 class="font-bold text-sm mb-3">ACCEPTED BY RENTER:</h5>
                        <p class="text-sm mb-1"><span class="font-semibold">Name:</span> {{ $firstName ?? 'N/A' }}
                            {{ $lastName ?? '' }}</p>
                        <p class="text-sm mb-1"><span class="font-semibold">Date:</span> {{ date('m-d-Y') }}</p>
                        <div class="mt-3">
                            <p class="text-sm font-semibold mb-2">Signature: <span class="text-red-500">*</span></p>
                            <div class="signature-container">
                                <canvas id="signature-pad"></canvas>
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button type="button" @click="clearSignature()"
                                    class="text-xs text-red-600 hover:text-red-800 font-medium px-3 py-1 bg-red-50 rounded hover:bg-red-100 transition">
                                    Clear Signature
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t bg-gray-50 sticky bottom-0">
                <div class="flex gap-4">
                    <button type="button" @click="acceptTerms()"
                        class="flex-1 bg-cyan-500 text-white py-3 rounded-lg hover:bg-cyan-600 transition font-medium">
                        I Accept & Sign
                    </button>
                    <button type="button" @click="termsModalOpen = false"
                        class="flex-1 bg-gray-600 text-white py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
