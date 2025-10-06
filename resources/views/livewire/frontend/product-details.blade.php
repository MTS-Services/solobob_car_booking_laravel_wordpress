<section class="bg-white" x-data="{ showModal: false, modalOpen: false }" x-init="$watch('showModal', value => document.body.style.overflow = value ? 'hidden' : '')">
    @push('styles')
        <style>
            .swiper-button-next::after,
            .swiper-button-prev::after {
                display: none;
            }
        </style>
    @endpush

    {{-- Header Section --}}
    <div class="container mx-auto bg-white flex justify-between items-center py-4 px-3 lg:px-4 xl:px-6 2xl:px-2">
        <div class="flex flex-col space-y-2">
            <button wire:click="back"
                class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 
            rounded-lg transition-all duration-200">
                <flux:icon name="arrow-left" class="w-5 h-5" />
                <span>Back</span>
            </button>

            <h2 class="text-2xl font-normal text-gray-900">{{ $vehicle->year }} {{ $vehicle->title }}</h2>
            <div class="text-white text-base bg-accent w-fit px-3 rounded-md">
                ${{ number_format($vehicle->weekly_rate, 2) }} <span
                    class="text-xs sm:text-sm font-medium text-white">/Week</span>
            </div>
        </div>
        <div class="font-bold cursor-pointer" onclick="copyCurrentUrl(this)">
            <flux:icon name='link' class='w-6 h-6 text-gray-600 hover:text-blue-500 transition' />
        </div>
    </div>

    <div class="pb-2 xss:pb-3 xs:pb-6 sm:pb-10 container mx-auto">
        <div class="flex flex-col w-full xl:flex-row gap-6">
            {{-- Left Side - Image Slider --}}
            <div class="w-full xl:w-2/3 shadow-lg bg-white sm:px-2 pb-2 xss:pb-3 xs:pb-6 sm:pb-10">
                <div
                    class="swiper details-swiper bg-gray-100 w-96 xxs:w-[450px] xs:w-[550px] sm:w-[650px] md:w-[800px] lg:w-[950px] xl:w-[700px] 2xl:w-full h-64 xs:h-72 sm:h-80 md:h-96 lg:h-[28rem] xl:h-[32rem] rounded-lg overflow-hidden relative">
                    <div class="swiper-wrapper">
                        {{-- @php
                            $imagePath = asset('assets/images/default-car.png');

                            if ($vehicle->avatar) {
                                $cleanPath = str_replace('storage/', '', $vehicle->avatar);
                                $cleanPath = ltrim($cleanPath, '/');
                                $imagePath = asset('storage/' . $cleanPath);
                            }
                        @endphp --}}

                        {{-- Main vehicle image --}}
                        @foreach ($vehicle->images as $image)
                            <div class="swiper-slide">
                                <img src="{{ storage_url($image->image) }}" alt="{{ $vehicle->title }} image"
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/default-car.png') }}';">
                            </div>
                        @endforeach

                        {{-- Additional placeholder slides (you can add more images relation later) --}}
                        {{-- @for ($i = 0; $i < 4; $i++)
                            <div class="swiper-slide">
                                <img src="{{ storage_url($vehicle?->images?->first()?->image) }}" alt="{{ $vehicle->title }} image {{ $i + 2 }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/default-car.png') }}';">
                            </div>
                        @endfor --}}
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
                        <span class="text-lg xs:text-xl font-semibold">
                            Price ${{ number_format($vehicle->monthly_rate, 2) }}/Month
                        </span>
                    </div>

                    <div class="flex items-start gap-1 xs:gap-2 text-gray-700">
                        <flux:icon name="map-pin" class="w-4 h-4 xs:w-5 xs:h-5 mt-1 flex-shrink-0" />
                        <span class="text-sm xs:text-base">{{ $vehicle->owner?->address ?? 'Location Not Set' }}</span>
                    </div>

                    {{-- Vehicle Specifications --}}
                    <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <flux:icon name="users" class="w-5 h-5 text-gray-600" />
                            <span class="text-sm text-gray-700">{{ $vehicle->seating_capacity }} Seats</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon name="cog" class="w-5 h-5 text-gray-600" />
                            <span
                                class="text-sm text-gray-700">{{ $vehicle->transmission_type == 0 ? 'Automatic' : 'Manual' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon name="calendar" class="w-5 h-5 text-gray-600" />
                            <span class="text-sm text-gray-700">Year: {{ $vehicle->year }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon name="tag" class="w-5 h-5 text-gray-600" />
                            <span
                                class="text-sm text-gray-700">{{ $vehicle->category?->name ?? 'Uncategorized' }}</span>
                        </div>
                        @if ($vehicle->color)
                            <div class="flex items-center gap-2">
                                <flux:icon name="swatch" class="w-5 h-5 text-gray-600" />
                                <span class="text-sm text-gray-700">Color: {{ $vehicle->color }}</span>
                            </div>
                        @endif
                        @if ($vehicle->license_plate)
                            <div class="flex items-center gap-2">
                                <flux:icon name="identification" class="w-5 h-5 text-gray-600" />
                                <span class="text-sm text-gray-700">Plate: {{ $vehicle->license_plate }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($vehicle->description)
                        <div class="space-y-1 xs:space-y-2">
                            <h3 class="font-semibold text-gray-900 text-sm xs:text-base">Details:</h3>
                            <div class="text-gray-700 relative group text-sm xs:text-base" x-data="{ expanded: false, showButton: false }"
                                x-init="$nextTick(() => { showButton = $refs.text.scrollHeight > $refs.text.clientHeight; })">
                                <div :class="expanded ? '' : 'line-clamp-3'" x-ref="text">
                                    <p>{{ $vehicle->description }}</p>
                                </div>
                                <template x-if="showButton">
                                    <button @click="expanded = !expanded"
                                        class="text-zinc-600 hover:text-zinc-700 font-medium mt-1 transition-opacity duration-300 text-sm xs:text-base">
                                        <span class="text-zinc-500"
                                            x-text="expanded ? 'Read Less' : 'Read More...'"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    @endif

                    {{-- Additional Features --}}
                    {{-- @if ($vehicle->instant_booking || $vehicle->delivery_available)
                        <div class="flex gap-2 flex-wrap">
                            @if ($vehicle->instant_booking)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <flux:icon name="bolt" class="w-3 h-3 mr-1" />
                                    Instant Booking
                                </span>
                            @endif
                            @if ($vehicle->delivery_available)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <flux:icon name="truck" class="w-3 h-3 mr-1" />
                                    Delivery Available
                                    @if ($vehicle->delivery_fee)
                                        (${{ number_format($vehicle->delivery_fee, 2) }})
                                    @endif
                                </span>
                            @endif
                        </div>
                    @endif --}}
                </div>
            </div>

            {{-- Right Side - Booking Section --}}
            <div class="w-full xl:w-1/3 mt-6 2xl:mt-0">
                <div class="bg-white border border-gray-200 rounded-lg p-4 xs:p-5 sm:p-6 sticky top-0">
                    <div class="space-y-3 xs:space-y-4">
                        <div class="text-sm xs:text-base text-gray-600">
                            Available for booking
                        </div>

                        <button wire:click="$dispatch('open-booking-modal', { vehicleId: {{ $vehicle->id }} })"
                            class="w-full bg-zinc-500 hover:bg-zinc-600 text-white font-semibold py-2.5 xs:py-3 rounded-lg transition-colors text-sm xs:text-base">
                            Book Now
                        </button>

                        <button @click="modalOpen = true; document.body.classList.add('overflow-hidden')"
                            class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2.5 xs:py-3 rounded-lg transition-colors text-sm xs:text-base">
                            Get in touch
                        </button>

                        {{-- Owner Info --}}
                        @if ($vehicle->owner)
                            <div class="pt-3 xs:pt-4 border-t border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-2 text-sm xs:text-base">Owner Information</h3>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-700">{{ $vehicle->owner->name }}</p>
                                    @if ($vehicle->owner->email)
                                        <p class="text-sm text-gray-600">{{ $vehicle->owner->email }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

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

    {{-- Contact Modal --}}
    <div x-show="modalOpen" x-cloak @click="modalOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/30 bg-opacity-50"
        style="display: none;">
        <div @click.stop x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="bg-white rounded-lg shadow-xl max-w-xl w-full max-h-[90vh] overflow-y-auto">
            <div class="relative">
                <button @click="modalOpen = false" type="button"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-3xl font-light leading-none z-10">
                    &times;
                </button>
            </div>

            <div class="p-6 md:p-8">
                <h2 class="text-xl md:text-2xl font-semibold mb-6 text-gray-800 uppercase">
                    {{ $vehicle->year }} | {{ $vehicle->title }}
                </h2>

                {{-- <div class="">
                    <div class="space-y-4">
                        <form wire:submit.prevent="submitContact" method="POST">
                            @csrf
                            <div class="mb-4">
                                <input type="text" name="name" placeholder="Your Name"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            </div>

                            <div class="mb-4">
                                <input type="tel" name="phone" placeholder="Phone Number"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            </div>

                            <div class="mb-4">
                                <input type="email" name="email" placeholder="Email Address"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                            </div>

                            <div class="mb-4">
                                <textarea name="message" placeholder="Message *" rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent resize-none"></textarea>
                            </div>

                            <div class="flex items-start space-x-2 mb-4">
                                <input type="checkbox" name="sms_alerts" id="sms-alerts"
                                    class="mt-1 w-4 h-4 text-cyan-500 border-gray-300 rounded focus:ring-cyan-500">
                                <label for="sms-alerts" class="text-sm text-gray-700 leading-tight">
                                    Yes, I'd like to receive SMS alerts for booking confirmations and updates.
                                </label>
                            </div>

                            <p class="text-xs text-gray-500 italic mb-6">
                                Message and data rates may apply. Reply STOP to unsubscribe.
                            </p>

                            <button type="submit"
                                class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-3 rounded-lg transition-colors">
                                Get in touch
                            </button>
                        </form>
                    </div>
                </div> --}}
                <div class="w-full bg-transparent hidden lg:flex items-start justify-end z-1">
                    <div class="w-full max-w-xl py-8 flex h-[100%] justify-center items-center flex-col">
                        <h2 class="text-3xl sm:text-4xl font-bold text-black mb-6 sm:mb-8 text-center">GET IN TOUCH
                        </h2>

                        <form class="space-y-4 w-[100%]" wire:submit="contactSubmit">
                            @if (session()->has('submit_message'))
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <p class="text-primary"> {{ session('submit_message') }} </p>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" placeholder="First Name" wire:model="form.first_name"
                                        class="w-full px-3 py-2 border @if (!$errors->has('form.first_name')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif rounded bg-white focus:outline-none focus:border-zinc-600">
                                    @if ($errors->has('form.first_name'))
                                        <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                            {{ $errors->first('form.first_name') }}</small>
                                    @endif
                                </div>
                                <div>
                                    <input type="text" placeholder="Last Name" wire:model="form.last_name"
                                        class="w-full px-3 py-2 border @if (!$errors->has('form.last_name')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  border-gray-300 rounded bg-white text-gray-700 focus:outline-none focus:border-zinc-600">
                                    @if ($errors->has('form.last_name'))
                                        <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                            {{ $errors->first('form.last_name') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <input type="email" placeholder="Email" wire:model="form.email"
                                        class="w-full px-3 py-2 border  @if (!$errors->has('form.email')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  rounded bg-white  focus:outline-none focus:border-zinc-600">
                                    @if ($errors->has('form.email'))
                                        <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                            {{ $errors->first('form.last_name') }}</small>
                                    @endif
                                </div>
                                <div>
                                    <input type="tel" placeholder="Phone Number" wire:model="form.phone"
                                        class="w-full px-3 py-2 border @if (!$errors->has('form.phone')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  bg-white focus:outline-none focus:border-zinc-600">
                                    @if ($errors->has('form.phone'))
                                        <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                            {{ $errors->first('form.phone') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <textarea placeholder="Message" rows="4" wire:model="form.message"
                                    class="w-full px-3 py-2 border bg-white @if (!$errors->has('form.message')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif rounded bg-whitefocus:outline-none focus:border-zinc-600"></textarea>
                                @if ($errors->has('form.message'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                        {{ $errors->first('form.message') }}</small>
                                @endif
                            </div>
                            <button type="submit"
                                class="w-full bg-zinc-500 text-white py-3 rounded font-semibold hover:bg-yellow-800 transition">
                                SUBMIT
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Terms Modal --}}
    <div x-show="showModal" x-transition.opacity.duration.300ms @keydown.escape.window="showModal = false"
        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        style="display: none;">
        <div class="fixed inset-0 bg-black/30 bg-opacity-50 transition-opacity" @click="showModal = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.away="showModal = false"
                class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
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

                <div class="overflow-y-auto p-6 space-y-6 flex-1 scrollbar-hide"
                    style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .scrollbar-hide::-webkit-scrollbar {
                            display: none;
                        }
                    </style>

                    {{-- Terms content here (keeping original terms) --}}
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
                            period shall automatically extend on a day-to-day basis at the same daily rental rate.
                        </p>
                    </div>

                    {{-- Add more terms sections as needed --}}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', function() {
                const swiper = new Swiper(".details-swiper", {
                    loop: true,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });

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
            });
        </script>
    @endpush
</section>
