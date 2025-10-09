<div x-data="{
    currentStep: @entangle('currentStep').live,
    rentalRange: @entangle('rentalRange').live,
}">
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
                <div class=" rounded-lg p-6 lg:col-span-1">
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
                        {{-- STEP 2: Trip Date & Time Section - Replace your @case(2) section with this --}}
                        @case(2)
                            <div x-data="calendarComponent()" x-init="init()">
                                <h2 class="text-xl font-semibold mb-6">Trip Date & Time</h2>

                                @if ($errors->has('dateRange'))
                                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                        <p class="text-red-600 text-sm">{{ $errors->first('dateRange') }}</p>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between gap-5">
                                    <label class="block text-sm font-medium mb-2 flex-1 space-y-2">
                                        <span class="label">Pickup Date</span>
                                        <x-input type="text" x-model="pickupDateDisplay" readonly
                                            placeholder="Select pickup date" class="cursor-pointer" />
                                    </label>
                                    <label class="block text-sm font-medium mb-2 flex-1 space-y-2">
                                        <span class="label">Pickup Time</span>
                                        <x-input type="time" wire:model.live="pickupTime" />
                                    </label>
                                </div>

                                <div class="flex items-center justify-between gap-5">
                                    <label class="block text-sm font-medium mb-2 flex-1 space-y-2">
                                        <span class="label">Return Date</span>
                                        <x-input type="text" x-model="returnDateDisplay" readonly
                                            placeholder="Select return date" class="cursor-pointer" />
                                    </label>
                                    <label class="block text-sm font-medium mb-2 flex-1 space-y-2">
                                        <span class="label">Return Time</span>
                                        <x-input type="time" wire:model.live="returnTime" />
                                    </label>
                                </div>

                                <div class="mt-6 mb-4">
                                    <!-- Calendar Container - will be populated by Flatpickr -->
                                    <div wire:ignore>
                                        <div id="inline-date-calendar" class="w-full"></div>
                                        <p class="text-sm text-red-600 text-center mt-2" x-text="errorMessage"></p>
                                    </div>
                                </div>

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

                            @push('styles')
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                <style>
                                    /* Full width calendar styling */
                                    #inline-date-calendar {
                                        width: 100% !important;
                                    }

                                    .flatpickr-calendar.inline {
                                        width: 100% !important;
                                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
                                        display: block !important;
                                        padding: 10px;
                                        position: relative !important;
                                    }

                                    .flatpickr-calendar .flatpickr-rContainer {
                                        width: 100% !important;
                                    }

                                    .flatpickr-wrapper {
                                        width: 100% !important;
                                        display: block !important;
                                    }

                                    .flatpickr-calendar .flatpickr-innerContainer {
                                        width: 100% !important;
                                    }

                                    .flatpickr-months {
                                        width: 100% !important;
                                    }

                                    .flatpickr-month {
                                        width: 100% !important;
                                    }

                                    .flatpickr-days {

                                        width: 100% !important;
                                    }

                                    .dayContainer {
                                        width: 100% !important;
                                        min-width: 100% !important;
                                        max-width: 100% !important;
                                        display: flex !important;
                                        flex-wrap: wrap !important;
                                        justify-content: space-between !important;
                                    }

                                    .flatpickr-day {

                                        flex: 0 0 14.28% !important;
                                        max-width: 14.28% !important;
                                        height: 42px !important;
                                        line-height: 42px !important;
                                        margin: 0 !important;
                                    }

                                    /* Highlight disabled dates */
                                    .flatpickr-day.flatpickr-disabled,
                                    .flatpickr-day.flatpickr-disabled:hover {
                                        background: #fee2e2 !important;
                                        color: #991b1b !important;
                                        cursor: not-allowed !important;
                                        border-color: #fecaca !important;
                                        margin-top: 2px !important;
                                    }

                                    /* Selected range styling */
                                    .flatpickr-day.selected,
                                    .flatpickr-day.startRange,
                                    .flatpickr-day.endRange {
                                        background: #71717a !important;
                                        border-color: #71717a !important;
                                        color: white !important;
                                    }

                                    .flatpickr-day.selected.inRange,
                                    .flatpickr-day.startRange.inRange,
                                    .flatpickr-day.endRange.inRange,
                                    .flatpickr-day.inRange {
                                        background: #e4e4e7 !important;
                                        border-color: #e4e4e7 !important;
                                        color: #18181b !important;
                                        box-shadow: -5px 0 0 #e4e4e7, 5px 0 0 #e4e4e7 !important;
                                    }

                                    .flatpickr-day.selected.startRange,
                                    .flatpickr-day.startRange.startRange,
                                    .flatpickr-day.endRange.startRange {
                                        border-radius: 50px 0 0 50px !important;
                                    }

                                    .flatpickr-day.selected.endRange,
                                    .flatpickr-day.startRange.endRange,
                                    .flatpickr-day.endRange.endRange {
                                        border-radius: 0 50px 50px 0 !important;
                                    }

                                    .flatpickr-day:hover:not(.flatpickr-disabled) {
                                        background: #f4f4f5 !important;
                                        border-color: #e4e4e7 !important;
                                    }
                                </style>
                            @endpush

                            @push('scripts')
                                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                <script>
                                    function calendarComponent() {
                                        return {
                                            calendarInstance: null,
                                            isUpdatingFromCalendar: false,
                                            pickupDateDisplay: '',
                                            returnDateDisplay: '',
                                            errorMessage: '',

                                            init() {
                                                this.pickupDateDisplay = this.formatDisplayDate(@this.pickupDate);
                                                this.returnDateDisplay = this.formatDisplayDate(@this.returnDate);

                                                this.$nextTick(() => {
                                                    this.initializeCalendar();
                                                });

                                                Livewire.on('rental-range-changed', () => {
                                                    this.destroyCalendar();
                                                    this.pickupDateDisplay = '';
                                                    this.returnDateDisplay = '';
                                                    this.errorMessage = '';
                                                    @this.pickupDate = '';
                                                    @this.returnDate = '';
                                                    setTimeout(() => {
                                                        this.initializeCalendar();
                                                    }, 100);
                                                });
                                            },

                                            formatDisplayDate(dateStr) {
                                                if (!dateStr) return '';
                                                const date = new Date(dateStr);
                                                const d = String(date.getDate()).padStart(2, '0');
                                                const m = String(date.getMonth() + 1).padStart(2, '0');
                                                const y = date.getFullYear();
                                                return `${d}/${m}/${y}`;
                                            },

                                            initializeCalendar() {
                                                const calendarElement = document.getElementById('inline-date-calendar');
                                                if (!calendarElement) return;

                                                const disabledDates = @json($disabledDates ?? []);
                                                const requiredDays = {{ $requiredDays ?? 7 }};
                                                const currentPickupDate = @this.pickupDate || '';
                                                const currentReturnDate = @this.returnDate || '';

                                                this.destroyCalendar();

                                                let defaultDates = [];
                                                if (currentPickupDate && currentReturnDate) {
                                                    defaultDates = [currentPickupDate, currentReturnDate];
                                                }

                                                this.calendarInstance = flatpickr("#inline-date-calendar", {
                                                    inline: true,
                                                    mode: "range",
                                                    dateFormat: "Y-m-d",
                                                    minDate: "today",
                                                    showMonths: 1,
                                                    disable: disabledDates,
                                                    static: true,
                                                    defaultDate: defaultDates,

                                                    onReady: (selectedDates, dateStr, instance) => {
                                                        const calendar = instance.calendarContainer;
                                                        if (calendar) {
                                                            calendar.style.width = '100%';
                                                            calendar.style.display = 'block';
                                                        }
                                                        if (defaultDates.length > 0) {
                                                            instance.setDate(defaultDates, false);
                                                        }
                                                    },

                                                    onChange: (selectedDates, dateStr, instance) => {
                                                        this.isUpdatingFromCalendar = true;

                                                        // Clear error when starting new selection
                                                        this.errorMessage = '';

                                                        if (selectedDates.length === 2) {
                                                            const start = selectedDates[0];
                                                            const end = selectedDates[1];

                                                            // Calculate days - set to midnight for accurate calculation
                                                            const startDate = new Date(start.getFullYear(), start.getMonth(), start
                                                                .getDate());
                                                            const endDate = new Date(end.getFullYear(), end.getMonth(), end.getDate());

                                                            const MS_PER_DAY = 1000 * 60 * 60 * 24;
                                                            const diffTime = endDate.getTime() - startDate.getTime();
                                                            const diffDays = Math.round(diffTime / MS_PER_DAY) + 1;

                                                            // ONLY show error if days don't match required days
                                                            if (diffDays !== requiredDays) {
                                                                const rentalType = requiredDays === 7 ? 'Weekly' : 'Monthly';
                                                                this.errorMessage =
                                                                    `${rentalType} rentals must be exactly ${requiredDays} days. You selected ${diffDays} ${diffDays === 1 ? 'day' : 'days'}.`;
                                                                instance.clear();
                                                                this.pickupDateDisplay = '';
                                                                this.returnDateDisplay = '';
                                                                @this.pickupDate = '';
                                                                @this.returnDate = '';
                                                                this.isUpdatingFromCalendar = false;
                                                                return;
                                                            }

                                                            // Check if any date in range is disabled
                                                            let hasDisabledDate = false;
                                                            let currentDate = new Date(startDate);

                                                            while (currentDate <= endDate) {
                                                                const year = currentDate.getFullYear();
                                                                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                                                                const day = String(currentDate.getDate()).padStart(2, '0');
                                                                const dateString = `${year}-${month}-${day}`;

                                                                if (disabledDates.includes(dateString)) {
                                                                    hasDisabledDate = true;
                                                                    break;
                                                                }
                                                                currentDate.setDate(currentDate.getDate() + 1);
                                                            }

                                                            if (hasDisabledDate) {
                                                                this.errorMessage =
                                                                    'Selected dates include unavailable dates. Please choose different dates.';
                                                                instance.clear();
                                                                this.pickupDateDisplay = '';
                                                                this.returnDateDisplay = '';
                                                                @this.pickupDate = '';
                                                                @this.returnDate = '';
                                                                this.isUpdatingFromCalendar = false;
                                                                return;
                                                            }

                                                            // Valid selection - clear error and update dates
                                                            this.errorMessage = '';

                                                            const formatStorageDate = (date) => {
                                                                const y = date.getFullYear();
                                                                const m = String(date.getMonth() + 1).padStart(2, '0');
                                                                const d = String(date.getDate()).padStart(2, '0');
                                                                return `${y}-${m}-${d}`;
                                                            };

                                                            const formatDisplayDate = (date) => {
                                                                const d = String(date.getDate()).padStart(2, '0');
                                                                const m = String(date.getMonth() + 1).padStart(2, '0');
                                                                const y = date.getFullYear();
                                                                return `${d}/${m}/${y}`;
                                                            };

                                                            this.pickupDateDisplay = formatDisplayDate(start);
                                                            this.returnDateDisplay = formatDisplayDate(end);
                                                            @this.pickupDate = formatStorageDate(start);
                                                            @this.returnDate = formatStorageDate(end);

                                                            setTimeout(() => {
                                                                this.isUpdatingFromCalendar = false;
                                                            }, 100);

                                                        } else if (selectedDates.length === 1) {
                                                            const date = selectedDates[0];

                                                            const formatStorageDate = (date) => {
                                                                const y = date.getFullYear();
                                                                const m = String(date.getMonth() + 1).padStart(2, '0');
                                                                const d = String(date.getDate()).padStart(2, '0');
                                                                return `${y}-${m}-${d}`;
                                                            };

                                                            const formatDisplayDate = (date) => {
                                                                const d = String(date.getDate()).padStart(2, '0');
                                                                const m = String(date.getMonth() + 1).padStart(2, '0');
                                                                const y = date.getFullYear();
                                                                return `${d}/${m}/${y}`;
                                                            };

                                                            this.pickupDateDisplay = formatDisplayDate(date);
                                                            this.returnDateDisplay = '';
                                                            @this.pickupDate = formatStorageDate(date);
                                                            @this.returnDate = '';

                                                            setTimeout(() => {
                                                                this.isUpdatingFromCalendar = false;
                                                            }, 100);

                                                        } else {
                                                            this.pickupDateDisplay = '';
                                                            this.returnDateDisplay = '';
                                                            @this.pickupDate = '';
                                                            @this.returnDate = '';

                                                            setTimeout(() => {
                                                                this.isUpdatingFromCalendar = false;
                                                            }, 100);
                                                        }
                                                    }
                                                });
                                            },

                                            destroyCalendar() {
                                                if (this.calendarInstance) {
                                                    this.calendarInstance.destroy();
                                                    this.calendarInstance = null;
                                                }
                                            }
                                        }
                                    }
                                </script>
                            @endpush
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

                                        <!-- Selfie Upload -->
                                        <div class="mb-6">
                                            <label class="block text-sm font-medium mb-2">Selfie with License</label>
                                            <div
                                                class="border-2 border-dashed rounded-lg text-center transition cursor-pointer relative p-6 h-36 flex items-center justify-center border-gray-300 hover:border-zinc-500">
                                                <input type="file" wire:model="selfie"
                                                    class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*"
                                                    capture="user">

                                                <div wire:loading.remove wire:target="selfie"
                                                    class="w-full h-full flex items-center justify-center">
                                                    @if ($selfie)
                                                        <div
                                                            class="relative group h-full w-full flex flex-col items-center justify-center">
                                                            <img src="{{ $selfie->temporaryUrl() }}" alt="Selfie Preview"
                                                                class="w-full h-full object-contain rounded-md">
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
                                                        <div class="text-gray-600">
                                                            <i class="fas fa-camera text-2xl text-zinc-500 mb-2"></i>
                                                            <p class="text-sm">Click to <b>Open Camera</b> and take your Selfie
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>

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
                                            <input wire:model="termsAccepted" type="checkbox" required
                                                class="w-4 h-4 text-zinc-500 rounded mt-1">
                                            <span class="ml-2 text-sm text-gray-700">
                                                I have Read and Accept Terms & Conditions <span class="text-red-500">*</span>
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
                            <div>
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
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-zinc-500 focus:border-transparent">
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium mb-2">Cardholder Name</label>
                                        <input x-model="paymentData.cardName" type="text" placeholder="John Doe" required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-zinc-500 focus:border-transparent">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium mb-2">Expiry Date</label>
                                            <input x-model="paymentData.expiry" type="text" placeholder="MM/YY" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-zinc-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium mb-2">CVV</label>
                                            <input x-model="paymentData.cvv" type="text" placeholder="123" required
                                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-zinc-500 focus:border-transparent">
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
                        @break

                        @default
                            {{-- show something went wrong --}}
                            <div class="text-center">
                                <h2 class="text-2xl font-semibold mb-4">Something went wrong</h2>
                                <p class="text-gray-600">Please try again later.</p>
                            </div>
                    @endswitch
                </div>
            </div>
        </div>


    </div>
</div>
