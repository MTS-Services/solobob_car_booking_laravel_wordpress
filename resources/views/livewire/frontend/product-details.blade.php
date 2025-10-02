<section class="bg-white" x-data="{ showModal: false }" x-init="$watch('showModal', value => document.body.style.overflow = value ? 'hidden' : '')">
    @push('styles')
        <style>
            /* Hide default Swiper arrows */
            .swiper-button-next::after,
            .swiper-button-prev::after {
                display: none;
            }
        </style>
    @endpush
    {{-- header section --}}
    <div class="container mx-auto bg-white flex justify-between items-center py-4 px-3 lg:px-4 xl:px-6 2xl:px-2">
        <div class="flex flex-col space-y-2">
            <div class="flex items-center gap-2">
                <flux:icon name="arrow-left" class="w-5 h-5 cursor-pointer" wire:click="back" />
                <button>Back</button>
            </div>
            <h2 class="text-2xl font-normal text-gray-900">2025 Nissan Sentra S</h2>
            <div class="text-white text-base bg-accent w-fit px-3 rounded-md">
                $99.00 <span class="text-xs sm:text-sm font-medium text-white">/Day</span>
            </div>
        </div>
        <div class="font-bold cursor-pointer" onclick="copyCurrentUrl(this)">
            <flux:icon name='link' class='w-6 h-6 text-gray-600 hover:text-blue-500 transition' />
        </div>
    </div>
    <div class=" pb-10 container mx-auto">
        <div class="flex flex-col w-full xl:flex-row gap-6">
            {{-- Left Side - Image Slider --}}
            <div class="w-full xl:w-2/3 shadow-lg bg-white px-2 ">
                <div
                    class="swiper details-swiper bg-gray-100 w-96 xxs:w-[450px] xs:w-[550px] sm:w-[650px] md:w-[800px]  lg:w-[950px] xl:w-[700px] 2xl:w-full h-64 xs:h-72 sm:h-80 md:h-96 lg:h-[28rem] xl:h-[32rem] rounded-lg overflow-hidden relative">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1619767886558-efdc259cde1a?w=800&h=600&fit=crop"
                                alt="Car image 1" class="w-full h-full object-cover" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1617531653332-bd46c24f2068?w=800&h=600&fit=crop"
                                alt="Car image 2" class="w-full h-full object-cover" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800&h=600&fit=crop"
                                alt="Car image 3" class="w-full h-full object-cover" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1614165936126-5bbf7aaa23b6?w=800&h=600&fit=crop"
                                alt="Car image 4" class="w-full h-full object-cover" />
                        </div>
                        <div class="swiper-slide">
                            <img src="https://images.unsplash.com/photo-1609521263047-f8f205293f24?w=800&h=600&fit=crop"
                                alt="Car image 5" class="w-full h-full object-cover" />
                        </div>
                    </div>
                    <div
                        class="swiper-button-next !w-10 !h-10 xs:w-12! xs:!h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-zinc-400 hover:scale-110 transition-all duration-300">
                        <flux:icon name="arrow-right" class="w-5! !h-5 xs:w-6! xs:!h-6 text-gray-800" />
                    </div>
                    <div
                        class="swiper-button-prev !w-10 !h-10 xs:w-12! xs:!h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-zinc-400 hover:scale-110 transition-all duration-300">
                        <flux:icon name="arrow-left" class="w-5! !h-5 xs:w-6! xs:!h-6 text-gray-800" />
                    </div>
                </div>

                {{-- Price and Details Section --}}
                <div class="mt-4 xs:mt-5 px-3 lg:px-4 xl:px-6 2xl:px-0 sm:mt-6 space-y-3 xs:space-y-4">
                    <div class="flex items-center gap-2 xs:gap-3 text-gray-900">
                        <span class="text-lg xs:text-xl font-semibold">Price $99.00 per day</span>
                    </div>

                    <div class="flex items-start gap-1 xs:gap-2 text-gray-700">
                        <flux:icon name="map-pin" class="w-4 h-4 xs:w-5 xs:h-5 mt-1 flex-shrink-0" />
                        <span class="text-sm xs:text-base">Pickup @ 1425 W Airport Fwy Irving TX 75062</span>
                    </div>

                    <div class="space-y-1 xs:space-y-2">
                        <h3 class="font-semibold text-gray-900 text-sm xs:text-base">Details :</h3>
                        <p class="text-gray-700 text-sm xs:text-base">Daily payouts as per Uber Earnings Clock- No
                            waiting weeks—your earnings hit your account every day.</p>
                    </div>

                    <div class="text-gray-700 leading-relaxed text-sm xs:text-base">
                        <p>2025 Nissan Sentra qualifies for Courier, Share, UberX ride tiers and rents for $99/day with
                            a $200 refundable deposit. Commercial rideshare insurance covering liability and damage
                            protection is included.</p>
                    </div>

                    <div class="text-gray-700 relative group text-sm xs:text-base" x-data="{ expanded: false, showButton: false }"
                        x-init="$nextTick(() => { showButton = $refs.text.scrollHeight > $refs.text.clientHeight; })">
                        <div :class="expanded ? '' : 'line-clamp-1'" x-ref="text">
                            <p>
                                Designed for cost-effective shifts with regular maintenance, this vehicle ensures
                                reliability and comfort. Perfect for rideshare drivers looking for a dependable and
                                fuel-efficient option. The Nissan Sentra offers excellent fuel economy, spacious
                                interior, and modern safety features that make it ideal for daily rideshare operations.
                            </p>
                        </div>
                        <template x-if="showButton">
                            <button @click="expanded = !expanded"
                                class="text-zinc-600 hover:text-zinc-700 font-medium mt-1 transition-opacity duration-300 text-sm xs:text-base">
                                <span class="text-zinc-500" x-text="expanded ? 'Read Less' : 'Read More...'"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Right Side - Booking Section --}}
            <div class="w-full xl:w-1/3 mt-6 2xl:mt-0">
                <div class="bg-white border border-gray-200 rounded-lg p-4 xs:p-5 sm:p-6 sticky top-0">
                    <div class="space-y-3 xs:space-y-4">
                        <div class="text-sm xs:text-base text-gray-600">
                            Oct 02 08:00 - Nov 01 23:30
                        </div>

                        <button
                            class="w-full bg-zinc-500 hover:bg-zinc-600 text-white font-semibold py-2.5 xs:py-3 rounded-lg transition-colors text-sm xs:text-base">
                            Book
                        </button>

                        <button
                            class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2.5 xs:py-3 rounded-lg transition-colors text-sm xs:text-base">
                            Get in touch
                        </button>

                        <div class="pt-3 xs:pt-4 border-t border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-2 xs:mb-3 text-sm xs:text-base">Policies</h3>
                            <p class="text-sm xs:text-base text-gray-600 leading-relaxed">
                                I hereby agree to the terms and conditions of the Lease Agreement with Host
                            </p>
                            <button @click="showModal = true"
                                class="text-zinc-600 hover:text-zinc-700 text-sm xs:text-base font-medium mt-1 xs:mt-2 transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="showModal" x-transition.opacity.duration.300ms @keydown.escape.window="showModal = false"
        class="fixed inset-0  z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        style="display: none;">
        {{-- Background Overlay --}}
        <div class="fixed inset-0 bg-black/30 bg-opacity-50 transition-opacity" @click="showModal = false"></div>

        {{-- Modal Container --}}
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.away="showModal = false"
                class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
                {{-- Modal Header --}}
                <div class="flex items-start justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Rental Agreement Terms & Conditions
                        </h3>
                    </div>
                    <button @click="showModal = false" type="button"
                        class="text-gray-400 hover:text-gray-500 transition-colors focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Body (Scrollable) --}}
                <div class="overflow-y-auto p-6 space-y-6 flex-1 scrollbar-hide"
                    style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .scrollbar-hide::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    {{-- Section 1 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            1. Rental Term, Booking Details & Extension Clause
                        </h4>
                        <p class="text-sm text-gray-700 mb-3">
                            This Agreement covers the rental period as set out above.
                        </p>
                        <p class="text-sm font-medium text-gray-900 mb-2">Extension Clause:</p>
                        <p class="text-sm text-gray-700">
                            If the Renter does not return the Rental Vehicle by the scheduled end date time, the rental
                            period shall automatically extend on a day-to-day basis at the same daily rental rate. All
                            other terms and conditions of this Agreement remain in full force during any extension. No
                            additional signature is required for such automatic extensions unless there is a material
                            change to the terms. Extensions beyond a predetermined continuous period may require written
                            confirmation by both parties.
                        </p>
                    </div>

                    {{-- Section 2 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            2. Payment Model Options
                        </h4>
                        <p class="text-sm text-gray-700 mb-3">
                            The Renter must select one of the following payment models:
                        </p>

                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900 mb-1">• Option 1 – Direct Payment Model:
                                </p>
                                <p class="text-sm text-gray-700">
                                    The Renter shall make all payments directly to the Owner. Daily rental fees,
                                    additional mileage charges, and other applicable fees will be paid by the Renter
                                    using the designated payment method. Failure to make timely payments may result in
                                    remote disablement of the vehicle or termination of this Agreement.
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-900 mb-1">• Option 2 – Fleet Program Payment
                                    Model:</p>
                                <p class="text-sm text-gray-700">
                                    The Renter participates in a Fleet Program. Under this model, all fares earned
                                    through rideshare or fleet platforms using the Rental Vehicle will be deposited into
                                    the Owner's designated Fleet Account. At the end of each payment period, the Owner
                                    will deduct the rental fee, any additional charges (including tolls, fees, or fuel
                                    discrepancies), and other agreed-upon expenses from the earnings before transferring
                                    the remaining balance to the Renter. Should the earnings be insufficient to cover
                                    these charges, the Renter must pay the difference immediately.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Section 3 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            3. Fuel Policy
                        </h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm font-medium text-gray-900">• Fuel Level at Pickup:</p>
                                <p class="text-sm text-gray-700">
                                    The fuel tank should be full at the time of pickup. If the fuel tank is not full,
                                    the Renter must immediately notify Fairpy.
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-900">• Fuel Level at Drop-off:</p>
                                <p class="text-sm text-gray-700">
                                    Upon return, the fuel level will be jointly recorded by both parties.
                                </p>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-900">• Fuel Discrepancy:</p>
                                <p class="text-sm text-gray-700 mb-1">
                                    If the fuel level at drop-off is lower than at pickup, the Renter agrees to pay for
                                    the difference based on the current fuel price, plus a $15 convenience fee for
                                    refueling.
                                </p>
                                <p class="text-sm italic text-gray-600">
                                    Example: If the vehicle is picked up with 95% fuel and returned with 75% fuel, the
                                    Renter shall be responsible for refilling the missing 20% of the tank plus the $15
                                    fee.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Section 4 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            4. Accident and Non-Drivable Vehicle Provision
                        </h4>
                        <p class="text-sm text-gray-700">
                            In the event of an accident that renders the Rental Vehicle non-drivable, responsibility for
                            damage shall be determined based on the extent of the damage and the applicable insurance
                            coverage. Fairpy reserves the right to provide a backup vehicle at its discretion.
                            Furthermore, if Fairpy deems it necessary to retain any portion of the rent paid in advance
                            to offset the deductible or additional costs arising from the accident, no refund shall be
                            provided for that portion.
                        </p>
                    </div>

                    {{-- Section 5 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            5. Scope of Use
                        </h4>
                        <p class="text-sm text-gray-700">
                            The Rental Vehicle is intended for personal or commercial rideshare purposes as agreed upon.
                            The Renter shall not use the vehicle for any illegal activities, racing, or purposes beyond
                            the scope of this agreement.
                        </p>
                    </div>

                    {{-- Section 6 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            6. Insurance Requirements
                        </h4>
                        <p class="text-sm text-gray-700">
                            The Renter must maintain valid insurance coverage throughout the rental period. Proof of
                            insurance must be provided before vehicle pickup. The insurance policy must meet the minimum
                            coverage requirements as specified by local regulations and this agreement.
                        </p>
                    </div>

                    {{-- Section 7 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            7. Vehicle Maintenance
                        </h4>
                        <p class="text-sm text-gray-700">
                            The Renter is responsible for basic vehicle maintenance during the rental period, including
                            checking oil levels, tire pressure, and ensuring the vehicle is kept clean. Any mechanical
                            issues must be reported immediately to the Owner.
                        </p>
                    </div>

                    {{-- Section 8 --}}
                    <div>
                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                            8. Termination of Agreement
                        </h4>
                        <p class="text-sm text-gray-700">
                            Either party may terminate this agreement with prior written notice. Early termination by
                            the Renter may result in penalties as outlined in the payment terms. The Owner reserves the
                            right to terminate the agreement immediately in cases of misuse, non-payment, or violation
                            of terms.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper(".details-swiper", {
                    loop: true,
                    
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
            });
        </script>
        <script>
            function copyCurrentUrl(el) {
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    el.innerHTML = `<flux:icon name='check' class='w-6 h-6 text-green-600 transition' />`;
                    setTimeout(() => {
                        el.innerHTML =
                            `<flux:icon name='link' class='w-6 h-6 text-gray-600 hover:text-blue-500 transition' />`;
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }
        </script>
    @endpush

</section>
