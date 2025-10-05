<div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.js" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .signature-container canvas {
            border: 1px solid #ccc;
            border-radius: 8px;
            cursor: crosshair;
        }
    </style>

    <div class="bg-gray-50" x-data="bookingApp()">
        <!-- Main Content - Two Column Layout -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-semibold mb-8">Reserve Your Car</h1>

            <!-- Progress Steps -->
            <div class="mb-12">
                <div class="flex items-center justify-between max-w-4xl mx-auto">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 h-8 rounded-full bg-[#bb8106] flex items-center justify-center text-white mb-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-xs md:text-sm font-medium">Rental</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 -mx-4"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white mb-2"
                            :class="currentStep >= 2 ? 'bg-[#bb8106]' : 'bg-gray-300'">
                            <span class="text-sm font-semibold">2</span>
                        </div>
                        <span class="text-xs md:text-sm font-medium"
                            :class="currentStep >= 2 ? '' : 'text-gray-500'">Review</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 -mx-4"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mb-2"
                            :class="currentStep >= 3 ? 'bg-[#bb8106] text-white' : 'bg-gray-300 text-gray-600'">
                            <span class="text-sm font-semibold">3</span>
                        </div>
                        <span class="text-xs md:text-sm"
                            :class="currentStep >= 3 ? 'font-medium' : 'text-gray-500'">Checkout</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-gray-300 -mx-4"></div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center flex-1">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 mb-2">
                            <span class="text-sm font-semibold">4</span>
                        </div>
                        <span class="text-xs md:text-sm text-gray-500">Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Sidebar - Car Details -->
                <div class=" rounded-lg p-6 lg:col-span-1">
                    <h2 class="text-xl font-semibold mb-6">Car Details</h2>

                    <div class="flex gap-4 mb-6">
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=200&h=150&fit=crop"
                            alt="2020 Nissan Rogue" class="w-32 h-24 object-cover rounded-lg">
                        <div>
                            <h3 class="font-semibold text-lg">2020 Nissan Rogue</h3>
                            <p class="text-sm text-gray-600">4425 W Airport Fwy Irving TX 75062</p>
                            <p class="text-sm text-gray-600">Oct 02 08:00 - Nov 01 23:30</p>
                        </div>
                    </div>

                    <h3 class="font-semibold mb-4">Payment Frequency</h3>
                    <div class="flex gap-4 mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="frequency" value="daily" wire:model="paymentFrequency"
                                class="w-4 h-4 text-[#bb8106]">
                            <span class="ml-2">Daily</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="frequency" value="weekly" wire:model="paymentFrequency"
                                class="w-4 h-4 text-[#bb8106]">
                            <span class="ml-2">Weekly</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="frequency" value="now" wire:model="paymentFrequency"
                                class="w-4 h-4 text-[#bb8106]">
                            <span class="ml-2">Now</span>
                        </label>
                    </div>

                    <p class="text-sm text-gray-600 italic mb-6">Book for any duration but make micropayments everyday
                        or weekly.</p>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-semibold">Upfront payment</span>
                            <span class="font-semibold">{{ $this->formatCurrency($this->upfrontPayment) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>
                                @if ($this->paymentFrequency === 'now')
                                    Total Rental Cost
                                @elseif ($this->paymentFrequency === 'weekly')
                                    Rental Cost (7 Days @ {{ $this->formatCurrency($dailyPrice) }}/day)
                                @else
                                    Rental Cost (1 Day @ {{ $this->formatCurrency($dailyPrice) }}/day)
                                @endif
                            </span>
                            <span>{{ $this->formatCurrency($this->rentalCost) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-4">
                            <span>Security Deposit</span>
                            <span>{{ $this->formatCurrency($securityDeposit) }}</span>
                        </div>
                    </div>



                    <div x-data="{ contactModalOpen: false }">
                        <button @click="contactModalOpen = true"
                            class="w-full bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition mb-4">
                            Check Availability
                        </button>

                        <div x-show="contactModalOpen" x-cloak
                            class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center p-4 sm:p-6 z-50"
                            @click.self="contactModalOpen = false">

                            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full **mx-2**" @click.stop>

                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-center">
                                        <h2 class="text-xl font-semibold text-gray-800">2025 NISSAN SENTRA S</h2>
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
                                        <img src="{{ asset('assets/images/banner_car.png') }}"
                                            alt="2025 Nissan Sentra S"
                                            class="w-full h-auto object-cover rounded-lg shadow-md">
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <input type="text" placeholder="Jhone Doe" value="Jhone Doe"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#bb8106] focus:border-[#bb8106] text-sm">
                                        <input type="text" placeholder="017017017" value="017017017"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#bb8106] focus:border-[#bb8106] text-sm">
                                    </div>

                                    <input type="email" placeholder="Info@mail.com" value="Info@mail.com"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#bb8106] focus:border-[#bb8106] text-sm">

                                    <textarea placeholder="Message *" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#bb8106] focus:border-[#bb8106] text-sm resize-none"></textarea>

                                    <div class="flex items-start space-x-3 pt-2">
                                        <input id="sms-alert" type="checkbox"
                                            class="mt-1 w-4 h-4 text-[#bb8106] bg-gray-100 border-gray-300 rounded focus:ring-[#bb8106]">
                                        <label for="sms-alert" class="text-xs text-gray-700">
                                            Yes, I'd like to receive SMS alerts from Fairpy rental for booking
                                            confirmations,
                                            payment updates, support messages, and important reminders.
                                            <span class="block text-gray-500 mt-0.5">
                                                Message and data rates may apply. Reply **STOP** to unsubscribe.
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-4 border-t">
                                    <button
                                        class="w-full bg-[#bb8106] text-white py-3 rounded-lg hover:bg-[#bb8106] transition font-medium">
                                        Get in touch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600">
                        {{ $this->paymentDescription }}
                    </p>
                </div>

                <!-- Right Content - Forms -->
                <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
                    <!-- Step 1: Trip Date & Time -->
                    <div x-show="currentStep === 1">
                        <h2 class="text-xl font-semibold mb-6">Trip Date & Time</h2>

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Start Date</label>
                            <input type="date" value="10/02/2025"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">

                            <label class="block text-sm font-medium mb-2">Start Time</label>
                            <select class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 bg-white">
                                <option>8:00 AM</option>
                                <option>9:00 AM</option>
                                <option>10:00 AM</option>
                                <option>11:00 AM</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Return Date</label>
                            <input type="date" value="11/01/2025"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">

                            <label class="block text-sm font-medium mb-2">Return Time</label>
                            <select class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-6 bg-white">
                                <option>8:00 AM</option>
                                <option>9:00 AM</option>
                                <option>10:00 AM</option>
                                <option>11:00 AM</option>
                            </select>
                        </div>

                        <div class="flex gap-4 flex-col sm:flex-row">
                            <button @click="!isLoggedIn ? showSignupModal = true : currentStep = 2"
                                class="flex-1 bg-[#bb8106] text-white py-3 rounded-lg hover:bg-[#bb8106] transition font-medium">
                                Continue Booking
                            </button>
                            <button
                                class="flex-1 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                                Back to Car Details
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Verification Documents -->
                    <div x-show="currentStep === 2" x-cloak>
                        <h2 class="text-xl font-semibold mb-6">Verification Documents</h2>

                        <form @submit.prevent="currentStep = 3">
                            <!-- File Upload Sections -->
                            <div x-data="{
                                verificationData: { license: null, licensePreview: null, selfie: null, selfiePreview: null, addressProof: null, addressProofPreview: null },
                                // Function to handle file selection and generate a preview URL
                                handleFileChange(event, fileKey, previewKey) {
                                    const file = event.target.files[0];
                                    this.verificationData[fileKey] = file;
                                    if (file) {
                                        this.verificationData[previewKey] = URL.createObjectURL(file);
                                    } else {
                                        this.verificationData[previewKey] = null;
                                    }
                                },
                                // Function to clear a file and its preview
                                clearFile(fileKey, previewKey) {
                                    this.verificationData[fileKey] = null;
                                    this.verificationData[previewKey] = null;
                                    // Optional: Reset the file input value so the same file can be selected again
                                    this.$refs[fileKey].value = '';
                                }
                            }">

                                <div class="mb-6">
                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-[#bb8106] transition cursor-pointer relative p-6">

                                        <input type="file" x-ref="license"
                                            class="absolute inset-0 opacity-0 cursor-pointer"
                                            @change="handleFileChange($event, 'license', 'licensePreview')">

                                        <div x-show="!verificationData.licensePreview">
                                            <p class="text-gray-600 text-sm">Drag & drop your **License(s)** here, or
                                                Click to Select</p>
                                        </div>

                                        <div x-show="verificationData.licensePreview" class="relative group">
                                            <img :src="verificationData.licensePreview" alt="License Preview"
                                                class="w-full h-auto max-h-48 object-contain rounded-md">

                                            <button @click.prevent.stop="clearFile('license', 'licensePreview')"
                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>

                                            <p class="text-green-600 text-xs mt-2"
                                                x-text="verificationData.license ? verificationData.license.name : ''">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function verificationComponent() {
                                        return {
                                            verificationData: {
                                                selfie: null,
                                                selfiePreview: null
                                            },

                                            openCamera() {
                                                this.$refs.selfie.click();
                                            },

                                            handleFileChange(event, fileKey, previewKey) {
                                                const file = event.target.files[0];
                                                if (file) {
                                                    this.verificationData[fileKey] = file;

                                                    // --- USE FileReader for better mobile support ---
                                                    const reader = new FileReader();
                                                    reader.onload = (e) => {
                                                        this.verificationData[previewKey] = e.target.result;
                                                    };
                                                    reader.readAsDataURL(file);
                                                }
                                            },

                                            clearFile(fileKey, previewKey) {
                                                this.verificationData[fileKey] = null;
                                                this.verificationData[previewKey] = null;
                                                this.$refs[fileKey].value = '';
                                            }
                                        }
                                    }
                                </script>

                                <div class="mb-6" x-data="verificationComponent()">
                                    <div
                                        class="border-2 border-dashed rounded-lg text-center transition cursor-pointer relative p-6 h-36 flex items-center justify-center border-gray-300 hover:border-[#bb8106]">

                                        <input type="file" x-ref="selfie" class="hidden"
                                            @change="handleFileChange($event, 'selfie', 'selfiePreview')"
                                            accept="image/*" capture="user">

                                        <!-- Show placeholder before upload -->
                                        <div x-show="!verificationData.selfiePreview"
                                            class="h-full w-full flex items-center justify-center"
                                            @click="openCamera()">
                                            <div class="text-gray-600">
                                                <i class="fas fa-camera text-2xl text-[#bb8106] mb-2"></i>
                                                <p class="text-sm">Click to <b>Open Camera</b> and take your Selfie</p>
                                            </div>
                                        </div>

                                        <!-- Show preview after capture -->
                                        <div x-show="verificationData.selfiePreview"
                                            class="relative group h-full w-full flex flex-col items-center justify-center">

                                            <img :src="verificationData.selfiePreview" alt="Selfie Preview"
                                                class="w-full h-full object-contain rounded-md">

                                            <button @click.prevent.stop="clearFile('selfie', 'selfiePreview')"
                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition z-20 pointer-events-auto">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            <p class="text-green-600 text-xs mt-2"
                                                x-text="verificationData.selfie ? verificationData.selfie.name : ''">
                                            </p>
                                        </div>

                                    </div>
                                    <div x-data="{ isModalOpen: false }">
                                        <p class="text-xs text-gray-500 mt-2">
                                            Click
                                            <a href="#" @click.prevent="isModalOpen = true"
                                                class="text-[#bb8106] underline">
                                                here
                                            </a>
                                            to know the **Approved Form of Selfie with License**.
                                        </p>

                                        <div x-show="isModalOpen" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                                            role="dialog" aria-modal="true">

                                            <div @click="isModalOpen = false"
                                                class="fixed inset-0 bg-gray-500/50 bg-opacity-75 transition-opacity">
                                            </div>

                                            <div
                                                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                                <div x-show="isModalOpen" x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                                                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                                        <div
                                                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                            <button type="button" @click="isModalOpen = false"
                                                                class="inline-flex w-full justify-right rounded-md bg-[#bb8106] px-3 py-2 text-sm font-semibold text-white  hover:bg-[#a07406] sm:ml-3 sm:w-auto">
                                                                X
                                                            </button>
                                                        </div>
                                                        <div class="sm:flex sm:items-start flex-col">

                                                            <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4"
                                                                id="modal-title">
                                                                Valid form of License with selfie
                                                            </h3>

                                                            <div class="w-full text-center mb-4">
                                                                <img src="{{ asset('assets/images/banner_car.png') }}"
                                                                    alt="Example of valid selfie with license"
                                                                    class="max-w-full h-auto mx-auto" />
                                                            </div>

                                                            <div class="text-sm text-gray-700 w-full space-y-3">
                                                                <p><strong>Use Your Smartphone:</strong> Open your
                                                                    camera app on your smartphone and switch to the
                                                                    front-facing camera to prepare for the selfie.</p>

                                                                <p><strong>Position Your License:</strong> Hold your
                                                                    license at an angle that clearly displays all
                                                                    important information while ensuring it doesn't
                                                                    obscure your face. Adjust the distance so that both
                                                                    your face and the license are in focus.</p>

                                                                <p><strong>Center Your Face:</strong> Frame your face in
                                                                    the center of the shot. Position your license close
                                                                    to your face, ensuring it's visible but not
                                                                    obstructing your facial features.</p>

                                                                <p><strong>Capture Multiple Shots:</strong> Take several
                                                                    photos in quick succession to give yourself a
                                                                    variety of angles and expressions to choose from.
                                                                    Experiment with slight adjustments in positioning
                                                                    for better results.</p>

                                                                <p><strong>Review and Select:</strong> After capturing
                                                                    your selfie, go through the images and select the
                                                                    one that best represents your desired look. Consider
                                                                    clarity, expression, and the visibility of your
                                                                    license when making your choice.</p>
                                                            </div>

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-6">
                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-[#bb8106] transition cursor-pointer relative p-6">

                                        <input type="file" x-ref="addressProof"
                                            class="absolute inset-0 opacity-0 cursor-pointer"
                                            @change="handleFileChange($event, 'addressProof', 'addressProofPreview')">

                                        <div x-show="!verificationData.addressProofPreview">
                                            <p class="text-gray-600 text-sm">Drag & drop your **Address proof** here,
                                                or Click to Select</p>
                                        </div>

                                        <div x-show="verificationData.addressProofPreview" class="relative group">
                                            <img :src="verificationData.addressProofPreview"
                                                alt="Address Proof Preview"
                                                class="w-full h-auto max-h-48 object-contain rounded-md">

                                            <button
                                                @click.prevent.stop="clearFile('addressProof', 'addressProofPreview')"
                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>

                                            <p class="text-green-600 text-xs mt-2"
                                                x-text="verificationData.addressProof ? verificationData.addressProof.name : ''">
                                            </p>
                                        </div>
                                    </div>
                                    <div x-data="{ isAddressModalOpen: false }">
                                        <p class="text-xs text-gray-500 mt-2">
                                            Click
                                            <a href="#" @click.prevent="isAddressModalOpen = true"
                                                class="text-[#bb8106] underline">
                                                here
                                            </a>
                                            to know approved form of Address proof
                                        </p>

                                        <div x-show="isAddressModalOpen" x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
                                            role="dialog" aria-modal="true">

                                            <div @click="isAddressModalOpen = false"
                                                class="fixed inset-0 bg-black/50 bg-opacity-70 transition-opacity">
                                            </div>

                                            <div
                                                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                                <div x-show="isAddressModalOpen"
                                                    x-transition:enter="ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave="ease-in duration-200"
                                                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                                                    <div class="bg-white p-6 relative">

                                                        <button type="button" @click="isAddressModalOpen = false"
                                                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                                stroke-width="1.5" stroke="currentColor"
                                                                aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>

                                                        <h3 class="text-xl font-normal text-gray-900 mb-4 pt-1"
                                                            id="modal-title">
                                                            Valid form of Address proof
                                                        </h3>

                                                        <div class="text-sm text-gray-700 space-y-4">
                                                            <p>To complete your booking, you must upload a recent proof
                                                                of address so we can verify your residential
                                                                information.</p>

                                                            <p class="font-medium text-black">Accepted documents
                                                                include:</p>

                                                            <ul class="list-disc ml-5 space-y-2">
                                                                <li>
                                                                    Utility bill (electricity, gas, water) — **dated
                                                                    within the last 60 days**
                                                                </li>
                                                                <li>
                                                                    Bank statement or credit card statement — **dated
                                                                    within the last 60 days**
                                                                </li>
                                                                <li>
                                                                    Government-issued document (e.g., IRS/DMV letter,
                                                                    tax notice)
                                                                </li>
                                                                <li>
                                                                    Internet/cable bill or phone bill — **dated within
                                                                    the last 60 days**
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Information -->
                            <h3 class="font-semibold mb-4">Billing Information</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <input x-model="verificationData.firstName" type="text" placeholder="Jhone"
                                    required class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                <input x-model="verificationData.lastName" type="text" placeholder="Doe" required
                                    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <input x-model="verificationData.email" type="email" placeholder="info@mail.com"
                                    required class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                <input x-model="verificationData.dob" type="text" placeholder="01/01/2017"
                                    required class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                            </div>

                            <!-- Residential Address -->
                            <h3 class="font-semibold mb-4 mt-6">Residential Address</h3>
                            <input x-model="verificationData.address" type="text" placeholder="Address" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 bg-gray-50">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                <input x-model="verificationData.city" type="text" placeholder="City" required
                                    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                <input x-model="verificationData.state" type="text" placeholder="State" required
                                    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                <input x-model="verificationData.zip" type="text" placeholder="Zip" required
                                    class="border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                            </div>

                            <!-- Car Parking Location -->
                            <h3 class="font-semibold mb-4 mt-6">Car Parking Location</h3>
                            <label class="flex items-center mb-4 cursor-pointer">
                                <input x-model="verificationData.sameAsResidential" type="checkbox"
                                    class="w-4 h-4 text-[#bb8106] rounded">
                                <span class="ml-2 text-sm text-gray-600">Same as Residential Address</span>
                            </label>
                            <input x-model="verificationData.parkingAddress" type="text" placeholder="Address"
                                :disabled="verificationData.sameAsResidential"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 disabled:bg-gray-100 bg-gray-50">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                                <input x-model="verificationData.parkingCity" type="text" placeholder="City"
                                    :disabled="verificationData.sameAsResidential"
                                    class="border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                                <input x-model="verificationData.parkingState" type="text" placeholder="State"
                                    :disabled="verificationData.sameAsResidential"
                                    class="border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                                <input x-model="verificationData.parkingZip" type="text" placeholder="Zip"
                                    :disabled="verificationData.sameAsResidential"
                                    class="border border-gray-300 rounded-lg px-4 py-2 disabled:bg-gray-100 bg-gray-50">
                            </div>

                            <!-- Terms & Conditions Checkbox -->
                            <div class="mb-6">
                                <label class="flex items-start mb-3 cursor-pointer">
                                    <input x-model="verificationData.termsAccepted" type="checkbox" required
                                        class="w-4 h-4 text-[#bb8106] rounded mt-1" @click="openAgreementModal()">
                                    <span class="ml-2 text-sm text-gray-700">
                                        I have Read and Accept Terms & Conditions <span class="text-red-500">*</span>
                                    </span>
                                </label>
                            </div>

                            <!-- SMS Alerts -->
                            <label class="flex items-start mb-6 cursor-pointer">
                                <input x-model="verificationData.smsAlerts" type="checkbox"
                                    class="w-4 h-4 text-[#bb8106] rounded mt-1">
                                <span class="ml-2 text-sm text-gray-600">Yes, I'd like to receive SMS alerts from
                                    Fairental for booking confirmations, payment updates, support messages, and
                                    important reminders. <span class="italic">Message and data rates may apply. Reply
                                        STOP to unsubscribe.</span></span>
                            </label>

                            <div class="flex gap-4 flex-col sm:flex-row">
                                <button type="submit"
                                    class="flex-1 bg-[#bb8106] text-white py-3 rounded-lg hover:bg-[#bb8106] transition font-medium">
                                    Confirm & Proceed
                                </button>
                                <button type="button" @click="currentStep = 1"
                                    class="flex-1 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                                    Back to Booking Review
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 3: Payment Details -->
                    <div x-show="currentStep === 3" x-cloak>
                        <h2 class="text-xl font-semibold mb-6">Payment Details</h2>

                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h4 class="font-semibold mb-2">Booking Summary</h4>
                            <p class="text-sm text-gray-600">2020 Nissan Rogue</p>
                            <p class="text-sm text-gray-600">Oct 02 - Nov 01, 2025</p>
                            <div class="border-t mt-3 pt-3">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Rental Cost</span>
                                    <span>$99.00</span>
                                </div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Security Deposit</span>
                                    <span>$200.00</span>
                                </div>
                                <div class="flex justify-between font-semibold mt-2 pt-2 border-t">
                                    <span>Total Due Now</span>
                                    <span>$299.00</span>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="completeBooking()">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Card Number</label>
                                <input x-model="paymentData.cardNumber" type="text"
                                    placeholder="1234 5678 9012 3456" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#bb8106] focus:border-transparent">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Cardholder Name</label>
                                <input x-model="paymentData.cardName" type="text" placeholder="John Doe" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#bb8106] focus:border-transparent">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Expiry Date</label>
                                    <input x-model="paymentData.expiry" type="text" placeholder="MM/YY" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#bb8106] focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">CVV</label>
                                    <input x-model="paymentData.cvv" type="text" placeholder="123" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#bb8106] focus:border-transparent">
                                </div>
                            </div>

                            <div class="flex gap-4 flex-col sm:flex-row">
                                <button type="submit"
                                    class="flex-1 bg-green-500 text-white py-3 rounded-lg hover:bg-green-600 transition font-medium">
                                    Complete Booking - $299.00
                                </button>
                                <button type="button" @click="currentStep = 2"
                                    class="flex-1 bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition font-medium">
                                    Back to Verification
                                </button>
                            </div>

                            <p class="text-center text-xs text-gray-500 mt-4">
                                🔒 Your payment is secure and encrypted
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signup Modal -->
        <div x-show="showSignupModal" x-cloak
            class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center p-4 z-50"
            @click.self="showSignupModal = false">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6" @click.stop>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold">Sign Up</h3>
                    <button @click="showSignupModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="signup()">

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Email Address</label>
                        <input x-model="signupData.email" type="email" required
                            class="w-full border border-[#bb8106] rounded-lg px-4 py-2  focus:ring-[#bb8106] focus:border-[#bb8106]">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Password</label>
                        <input x-model="signupData.password" type="password" required
                            class="w-full border border-[#bb8106] rounded-lg px-4 py-2  focus:ring-[#bb8106] focus:border-[#bb8106]">
                    </div>

                    <button type="submit"
                        class="w-full bg-[#bb8106] text-white py-3 rounded-lg hover:bg-[#bb8106] transition font-medium">
                        Sign Up & Continue
                    </button>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Already have an account? <a href="#" class="text-[#bb8106] hover:underline">Log In</a>
                    </p>
                </form>
            </div>
        </div>

        <!-- Agreement Modal -->
        <div x-show="agreementModalOpen" x-cloak
            class="fixed inset-0 bg-black/50 bg-opacity-50 flex items-center justify-center p-4 z-50"
            @click.self="agreementModalOpen = false">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] flex flex-col" @click.stop>

                <div class="bg-gradient-to-r from-[#bb8106] to-[#bb8106] text-white p-6 rounded-t-xl flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Preliminary Agreement</h2>
                        <button @click="agreementModalOpen = false" class="text-white hover:text-gray-200 transition">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <p class="text-blue-100 mt-2">FAIRPY RENTAL CAR AGREEMENT</p>
                </div>

                <div class="p-6 overflow-y-auto flex-grow">

                    <div class="mb-6 items-center flex justify-center">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="2025 Nissan Sentra S"
                            class="w-50 h-20 object-contain rounded-lg shadow-md">
                    </div>

                    <div class="mb-8 space-y-4">
                        <div class="">
                            <h2 class="text-lg font-semibold mb-2">Terms and Conditions</h2>
                        </div>

                        <div class=" space-y-2">
                            <h3 class="text-md font-semibold mb-2">Rental Information</h3>
                            <p class="text-sm">• <span class="font-medium">Start:</span> 10-02-2025 12:30 PM</p>
                            <p class="text-sm">• <span class="font-medium">End:</span> 11-01-2025 12:30 PM</p>
                            <p class="text-sm">• <span class="font-medium">Booking Price:</span> $99 / Day</p>
                            <p class="text-sm">• <span class="font-medium">Rental Payment Plan:</span> Daily</p>
                            <p class="text-sm">• <span class="font-medium">Security Deposit:</span> $200.00</p>
                            <p class="text-sm">• <span class="font-medium">Included Distance:</span> Unlimited miles
                            </p>
                            <p class="text-sm">• <span class="font-medium">Pickup Location:</span> 4425 W Airport Fwy
                                Irving TX 75062</p>
                            <p class="text-sm">• <span class="font-medium">Protection Plan:</span> Default</p>
                        </div>

                        <div class=" space-y-1">
                            <h3 class="text-md font-semibold mb-2">Vehicle & Pickup Details</h3>
                            <p class="text-sm">• <span class="font-medium">Plate Number:</span> WBW9358</p>
                            <p class="text-sm">• <span class="font-medium">Make:</span> Nissan</p>
                            <p class="text-sm">• <span class="font-medium">Model:</span> Sentra</p>
                            <p class="text-sm">• <span class="font-medium">VIN:</span> 3N1AB8BV8SY263953</p>
                            <p class="text-sm">• <span class="font-medium">Year:</span> 2025</p>
                            <p class="text-sm">• <span class="font-medium">Color:</span> Black</p>
                            <p class="text-sm">• <span class="font-medium">Current Mileage:</span> N/A</p>
                            <p class="text-sm">• <span class="font-medium">Fuel Type:</span> Gas</p>
                        </div>


                        <div class=" ">
                            <h3 class="text-md font-semibold mb-2">Driver Details</h3>
                            <p class="text-sm">• <span class="font-medium">Driver Full Name:</span> Jhone Doe</p>
                        </div>


                        <div class=" space-y-4">
                            <h3 class="text-md font-semibold">1. Rental Term, Booking Details & Extension Clause</h3>
                            <p class="text-sm">This Agreement covers the rental period as set out above.</p>
                            <p class="text-sm font-medium">Extension Clause:</p>
                            <p class="text-sm">If the Renter does not return the Rental Vehicle by the scheduled end
                                date/time, the rental period shall automatically extend on a day-to-day basis at the
                                same daily rental rate... </p>
                        </div>

                        <div class=" space-y-2">
                            <h3 class="text-md font-semibold">2. Payment Model Options</h3>
                            <p class="text-sm">• Option 1 – Direct Payment Model: The Renter shall make all payments
                                directly to the Owner...</p>
                            <p class="text-sm">• Option 2 – Fleet Program Payment Model: The Renter participates in a
                                Fleet Program...</p>
                        </div>

                        <div class=" space-y-2">
                            <h3 class="text-md font-semibold">3. Fuel Policy</h3>
                            <p class="text-sm">• Fuel Level at Pickup: The fuel tank should be full at the time of
                                pickup...</p>
                            <p class="text-sm">• Fuel Level at Drop-off: Upon return, the fuel level will be jointly
                                recorded...</p>
                            <p class="text-sm">• Fuel Discrepancy: If the fuel level at drop-off is lower than at
                                pickup...</p>
                        </div>

                        <div class=" ">
                            <h3 class="text-md font-semibold">4. Accident and Non-Drivable Vehicle Provision</h3>
                            <p class="text-sm">In the event of an accident that renders the Rental Vehicle
                                non-drivable, responsibility for damage shall be determined...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">5. Scope of Use</h3>
                            <p class="text-sm">• The Rental Vehicle may be used for ridesharing, carshare, or other
                                fleet programs...</p>
                            <p class="text-sm">Prohibited Uses: – Racing, towing, off-roading...</p>
                            <p class="text-sm">Additional Provisions: – Acknowledgment of Existing Damage...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">6. Vehicle Tracking and Disabling</h3>
                            <p class="text-sm">The Rental Vehicle is equipped with GPS tracking, AirTags, and
                                geofencing technology...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">7. Recovery Compensation Policy</h3>
                            <p class="text-sm">If the Renter fails to return the vehicle to its designated location,
                                the following fees shall apply...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">8. Additional Responsibilities & Liabilities</h3>
                            <p class="text-sm">• Security Deposit & Damage Coverage...</p>
                            <p class="text-sm">• Smoking & Pet Policy...</p>
                            <p class="text-sm">• Traffic Violations...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">9. Governing Law and Dispute Resolution</h3>
                            <p class="text-sm">This Agreement shall be governed by the laws of the applicable
                                jurisdiction...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">10. Termination of Agreement</h3>
                            <p class="text-sm">This Agreement may be terminated immediately if...</p>
                        </div>

                        <div class="">
                            <h3 class="text-md font-semibold">11. Indemnification, Liability & Security</h3>
                            <p class="text-sm">The Renter agrees to indemnify, defend, and hold harmless the Owner...
                            </p>
                        </div>


                        <div class=" space-y-4">
                            <p class="text-sm font-medium">IN WITNESS WHEREOF, the parties hereto have executed this
                                Agreement as of the date set forth below.</p>
                            <div>
                                <p class="text-sm font-medium">ACCEPTED BY OWNER:</p>
                                <p class="text-sm">Name: Fairpy INC</p>
                                <p class="text-sm">Date: 10-02-2025</p>
                                <p class="text-sm">Signature: __________</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium">ACCEPTED BY RENTER:</p>
                                <p class="text-sm">Name: Jhone Doe</p>
                                <p class="text-sm">Date: 10-02-2025</p>
                                <p class="text-sm">Signature: __________</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t pt-3 p-6 bg-white flex-shrink-0">


                    <div x-show="!signatureActive">
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg h-32 flex items-center justify-center cursor-pointer hover:bg-gray-100 transition"
                            @click="startSignature()">
                            <template x-if="!signatureData">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-signature text-2xl mb-2"></i>
                                    <p>Click to sign here</p>
                                </div>
                            </template>
                            <template x-if="signatureData">
                                <div class="text-center">
                                    <img :src="signatureData" alt="Signature" class="max-h-24 mx-auto">
                                    <p class="text-green-600 mt-2"><i class="fas fa-check-circle mr-1"></i> Signed</p>
                                </div>
                            </template>
                        </div>

                        <div class="flex justify-between mt-3">
                            <button x-show="signatureData" @click="signatureData = null"
                                class="text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt mr-1"></i> Clear Signature
                            </button>

                        </div>
                    </div>

                    <div x-show="signatureActive" class="signature-container">
                        <div class="bg-white border-2 border-gray-300 rounded-lg overflow-hidden">
                            <canvas x-ref="signatureCanvas" class="w-full h-48 bg-white touch-none"
                                @mousedown="startDrawing($event)" @mousemove="draw($event)" @mouseup="stopDrawing()"
                                @mouseleave="stopDrawing()" @touchstart="startDrawing($event)"
                                @touchmove="draw($event)" @touchend="stopDrawing()">
                            </canvas>
                        </div>

                        <div class="flex justify-between mt-3">
                            <button @click="clearSignature()" class="text-sm text-red-500 hover:text-red-700">
                                <i class="fas fa-eraser mr-1"></i> Clear
                            </button>
                            <button @click="saveSignature()" class="text-sm text-[#bb8106] hover:text-[#bb8106]">
                                <i class="fas fa-check mr-1"></i> Save Signature
                            </button>
                            <button @click="cancelSignature()" class="text-sm text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-b-xl border-t flex-shrink-0">
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <button @click="acceptAgreement()"
                            :class="!signatureData ? 'opacity-50 cursor-not-allowed' : ''" :disabled="!signatureData"
                            class="flex-1 bg-[#bb8106] hover:bg-[#bb8106] text-white py-3 px-4 rounded-lg transition duration-200 font-medium flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i> Accept & Continue
                        </button>
                        <button @click="agreementModalOpen = false"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-3 px-4 rounded-lg transition duration-200 font-medium">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function bookingApp() {
            return {
                // Main app state
                showSignupModal: false,
                isLoggedIn: false,
                currentStep: 1,
                agreementModalOpen: false,

                // Signature state
                signatureActive: false,
                signatureData: null,
                isDrawing: false,
                lastX: 0,
                lastY: 0,

                // Data models
                signupData: {
                    name: '',
                    email: '',
                    password: ''
                },
                paymentData: {
                    cardNumber: '',
                    cardName: '',
                    expiry: '',
                    cvv: ''
                },
                verificationData: {
                    license: null,
                    selfie: null,
                    addressProof: null,
                    firstName: '',
                    lastName: '',
                    email: '',
                    dob: '',
                    address: '',
                    city: '',
                    state: '',
                    zip: '',
                    parkingAddress: '',
                    parkingCity: '',
                    parkingState: '',
                    parkingZip: '',
                    sameAsResidential: false,
                    termsAccepted: false,
                    smsAlerts: false
                },

                // Methods
                signup() {
                    this.showSignupModal = false;
                    this.isLoggedIn = true;
                    this.currentStep = 2;
                },

                openAgreementModal() {
                    this.agreementModalOpen = true;
                },

                completeBooking() {
                    alert('🎉 Booking Confirmed! Thank you for choosing our service. Redirecting to confirmation page...');
                    this.currentStep = 1;
                    this.isLoggedIn = false;
                },

                // Signature methods
                startSignature() {
                    this.signatureActive = true;
                    this.$nextTick(() => {
                        this.setupCanvas();
                    });
                },

                setupCanvas() {
                    const canvas = this.$refs.signatureCanvas;
                    const ctx = canvas.getContext('2d');

                    canvas.width = canvas.offsetWidth;
                    canvas.height = canvas.offsetHeight;

                    ctx.strokeStyle = '#000';
                    ctx.lineWidth = 2;
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';

                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                },

                getCanvasCoordinates(event) {
                    const canvas = this.$refs.signatureCanvas;
                    const rect = canvas.getBoundingClientRect();

                    let clientX, clientY;

                    if (event.type.includes('touch')) {
                        clientX = event.touches[0].clientX;
                        clientY = event.touches[0].clientY;
                    } else {
                        clientX = event.clientX;
                        clientY = event.clientY;
                    }

                    return {
                        x: clientX - rect.left,
                        y: clientY - rect.top
                    };
                },

                startDrawing(event) {
                    event.preventDefault();
                    this.isDrawing = true;
                    const coords = this.getCanvasCoordinates(event);
                    this.lastX = coords.x;
                    this.lastY = coords.y;
                },

                draw(event) {
                    if (!this.isDrawing) return;
                    event.preventDefault();

                    const canvas = this.$refs.signatureCanvas;
                    const ctx = canvas.getContext('2d');
                    const coords = this.getCanvasCoordinates(event);

                    ctx.beginPath();
                    ctx.moveTo(this.lastX, this.lastY);
                    ctx.lineTo(coords.x, coords.y);
                    ctx.stroke();

                    this.lastX = coords.x;
                    this.lastY = coords.y;
                },

                stopDrawing() {
                    this.isDrawing = false;
                },

                clearSignature() {
                    const canvas = this.$refs.signatureCanvas;
                    const ctx = canvas.getContext('2d');
                    ctx.fillStyle = 'white';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                },

                saveSignature() {
                    const canvas = this.$refs.signatureCanvas;
                    this.signatureData = canvas.toDataURL();
                    this.signatureActive = false;
                },

                cancelSignature() {
                    this.signatureActive = false;
                },

                acceptAgreement() {
                    if (!this.signatureData) {
                        alert('Please provide your signature before accepting the agreement.');
                        return;
                    }

                    this.verificationData.termsAccepted = true;
                    this.agreementModalOpen = false;
                    alert('Agreement accepted successfully!');
                }
            }
        }
    </script>
</div>
