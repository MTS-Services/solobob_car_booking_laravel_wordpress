<div x-data="{
    currentStep: @entangle('currentStep').live,
    rentalRange: @entangle('rentalRange').live,
}">
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Full width calendar styling */
        .flatpickr-calendar.inline {
            width: 100% !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
            display: block !important;
            padding: 10px;
        }

        .flatpickr-calendar .flatpickr-rContainer {
            width: 100% !important;
        }

        .flatpickr-calendar .flatpickr-months {
            padding: 10px 0;
            /* width: 100% !important; */
        }

        .flatpickr-calendar .flatpickr-month {
            /* height: auto; */
            /* width: 100% !important; */
        }

        .flatpickr-calendar .flatpickr-days {
            width: 100% !important;
        }

        .flatpickr-calendar .dayContainer {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .flatpickr-day {
            /* flex: 1;
            max-width: 14.28%;
            height: 45px;
            line-height: 45px;
            margin: 2px 0; */

            flex: 0 0 14.28% !important;
            max-width: 14.28% !important;
            height: 42px !important;
            line-height: 42px !important;
        }

        /* Disabled dates styling */
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.flatpickr-disabled:hover {
            background: #fee2e2 !important;
            color: #991b1b !important;
            cursor: not-allowed !important;
            border-color: #fecaca !important;
        }

        /* Selected range styling */
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #71717a !important;
            border-color: #71717a !important;
            color: white !important;
        }

        .flatpickr-day.inRange {
            background: #e4e4e7 !important;
            border-color: #e4e4e7 !important;
            color: #18181b !important;
            box-shadow: -5px 0 0 #e4e4e7, 5px 0 0 #e4e4e7 !important;
        }

        .flatpickr-day.selected.startRange,
        .flatpickr-day.startRange.startRange {
            border-radius: 50px 0 0 50px !important;
        }

        .flatpickr-day.selected.endRange,
        .flatpickr-day.endRange.endRange {
            border-radius: 0 50px 50px 0 !important;
        }

        .flatpickr-day:hover:not(.flatpickr-disabled) {
            background: #f4f4f5 !important;
            border-color: #e4e4e7 !important;
        }
    </style>

    <div class="bg-gray-50">
        <!-- Main Content -->
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
                        <img src="{{ storage_url($vehicle?->images?->first()?->image) }}" alt="{{ $vehicle?->title }}"
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
                            <input type="radio" name="range" value="weekly" wire:model.live="rentalRange"
                                class="w-4 h-4" checked>
                            <span class="ml-2">Weekly</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="range" value="monthly" wire:model.live="rentalRange"
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
                                x-show="rentalRange == 'weekly'">${{ $upfrontAmountWeekly }}</span>
                            <span class="font-semibold"
                                x-show="rentalRange == 'monthly'">${{ $upfrontAmountMonthly }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>Rental Cost</span>
                            <span x-show="rentalRange == 'weekly'">${{ $vehicle?->weekly_rate }}</span>
                            <span x-show="rentalRange == 'monthly'">${{ $vehicle?->monthly_rate }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 mb-4">
                            <span>Security Deposit</span>
                            <span x-show="rentalRange == 'weekly'">${{ $vehicle?->security_deposit_weekly }}</span>
                            <span x-show="rentalRange == 'monthly'">${{ $vehicle?->security_deposit_monthly }}</span>
                        </div>
                    </div>

                    <button class="w-full bg-gray-800 text-white py-3 rounded-lg hover:bg-gray-700 transition mb-4">
                        Check Availability
                    </button>

                    <p class="text-sm text-gray-600">
                        {{ $vehicle?->description }}
                    </p>
                </div>

                <!-- Right Content - Forms -->
                <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
                    @if ($currentStep === 2)
                        <div>
                            <h2 class="text-xl font-semibold mb-6">Trip Date & Time</h2>

                            @if ($errors->has('dateRange'))
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-red-600 text-sm">{{ $errors->first('dateRange') }}</p>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <label class="block space-y-2">
                                    <span class="text-sm font-medium">Pickup Date</span>
                                    <input type="text" id="pickup-date" wire:model="pickupDate" readonly
                                        placeholder="Select pickup date"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                </label>
                                <label class="block space-y-2">
                                    <span class="text-sm font-medium">Pickup Time</span>
                                    <input type="time" wire:model="pickupTime"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                                <label class="block space-y-2">
                                    <span class="text-sm font-medium">Return Date</span>
                                    <input type="text" id="return-date" wire:model="returnDate" readonly
                                        placeholder="Select return date"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50">
                                </label>
                                <label class="block space-y-2">
                                    <span class="text-sm font-medium">Return Time</span>
                                    <input type="time" wire:model="returnTime"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                </label>
                            </div>

                            <div class="mb-6">
                                <div id="inline-calendar"></div>
                                <p class="text-sm text-red-600 text-center mt-2" id="calendar-error"></p>
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
                        @endpush

                        @push('scripts')
                            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                            <script>
                                document.addEventListener('livewire:init', () => {
                                    let calendarInstance = null;

                                    // Get initial data from Livewire
                                    const component = @this;
                                    let disabledDates = @json($disabledDates ?? []);
                                    let requiredDays = {{ $requiredDays ?? 7 }};

                                    function initCalendar() {
                                        const calendarElement = document.getElementById('inline-calendar');
                                        const errorElement = document.getElementById('calendar-error');

                                        if (!calendarElement) return;

                                        // Destroy existing instance
                                        if (calendarInstance) {
                                            calendarInstance.destroy();
                                        }

                                        // Create new calendar
                                        calendarInstance = flatpickr(calendarElement, {
                                            inline: true,
                                            mode: "range",
                                            dateFormat: "Y-m-d",
                                            minDate: "today",
                                            disable: disabledDates.map(date => date),

                                            onChange: function(selectedDates, dateStr, instance) {
                                                errorElement.textContent = '';

                                                if (selectedDates.length === 2) {
                                                    const start = selectedDates[0];
                                                    const end = selectedDates[1];

                                                    // Calculate days (inclusive)
                                                    const diffTime = Math.abs(end - start);
                                                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                                                    // Validate exact days requirement
                                                    if (diffDays !== requiredDays) {
                                                        const rentalType = requiredDays === 7 ? 'weekly' : 'monthly';
                                                        errorElement.textContent =
                                                            `Please select exactly ${requiredDays} days for your ${rentalType} rental. You selected ${diffDays} days.`;
                                                        instance.clear();
                                                        component.set('pickupDate', '');
                                                        component.set('returnDate', '');
                                                        return;
                                                    }

                                                    // Check if any date in range is disabled
                                                    let hasDisabledDate = false;
                                                    let currentDate = new Date(start);

                                                    while (currentDate <= end) {
                                                        const dateString = currentDate.toISOString().split('T')[0];
                                                        if (disabledDates.includes(dateString)) {
                                                            hasDisabledDate = true;
                                                            break;
                                                        }
                                                        currentDate.setDate(currentDate.getDate() + 1);
                                                    }

                                                    if (hasDisabledDate) {
                                                        errorElement.textContent =
                                                            'Selected date range includes unavailable dates. Please choose different dates.';
                                                        instance.clear();
                                                        component.set('pickupDate', '');
                                                        component.set('returnDate', '');
                                                        return;
                                                    }

                                                    // Format dates for display and Livewire
                                                    const formatDate = (date) => {
                                                        const year = date.getFullYear();
                                                        const month = String(date.getMonth() + 1).padStart(2, '0');
                                                        const day = String(date.getDate()).padStart(2, '0');
                                                        return `${year}-${month}-${day}`;
                                                    };

                                                    const pickupFormatted = formatDate(start);
                                                    const returnFormatted = formatDate(end);

                                                    // Update display inputs
                                                    document.getElementById('pickup-date').value = pickupFormatted;
                                                    document.getElementById('return-date').value = returnFormatted;

                                                    // Update Livewire properties
                                                    component.set('pickupDate', pickupFormatted);
                                                    component.set('returnDate', returnFormatted);

                                                } else if (selectedDates.length === 1) {
                                                    const date = selectedDates[0];
                                                    const formatDate = (date) => {
                                                        const year = date.getFullYear();
                                                        const month = String(date.getMonth() + 1).padStart(2, '0');
                                                        const day = String(date.getDate()).padStart(2, '0');
                                                        return `${year}-${month}-${day}`;
                                                    };

                                                    const formatted = formatDate(date);
                                                    document.getElementById('pickup-date').value = formatted;
                                                    document.getElementById('return-date').value = '';
                                                    component.set('pickupDate', formatted);
                                                    component.set('returnDate', '');
                                                } else {
                                                    document.getElementById('pickup-date').value = '';
                                                    document.getElementById('return-date').value = '';
                                                    component.set('pickupDate', '');
                                                    component.set('returnDate', '');
                                                }
                                            }
                                        });
                                    }

                                    // Initialize calendar
                                    initCalendar();

                                    // Listen for rental range changes from Livewire
                                    Livewire.on('rental-range-changed', (event) => {
                                        requiredDays = event.requiredDays;
                                        if (calendarInstance) {
                                            calendarInstance.clear();
                                        }
                                        document.getElementById('calendar-error').textContent = '';
                                    });
                                });
                            </script>
                        @endpush
                    @endif

                    @if ($currentStep === 3)
                        <div>
                            <h2 class="text-xl font-semibold mb-6">Verification Documents</h2>
                            <p class="text-gray-600">Step 3 content goes here...</p>
                        </div>
                    @endif

                    @if ($currentStep === 4)
                        <div>
                            <h2 class="text-xl font-semibold mb-6">Payment Details</h2>
                            <p class="text-gray-600">Step 4 content goes here...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
