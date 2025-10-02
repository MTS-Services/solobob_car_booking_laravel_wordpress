<section class="relative h-full font-sans text-sm m-0 p-0">
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <style>
            /* Hide default Swiper arrows */
            .swiper-button-next::after,
            .swiper-button-prev::after {
                display: none;
            }
        </style>
    @endpush
    {{-- header section --}}
    <div class="max-w-7xl mx-auto bg-white flex justify-between items-center py-4">
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
    <div class="bg-gray-50 py-10">
        <div class="max-w-7xl mx-auto flex  flex-col lg:flex-row gap-6">
            {{-- Left Side - Image Slider --}}
            <div class="w-full lg:w-2/3">
                <div class="swiper mySwiper bg-gray-100 w-full h-96 rounded-lg overflow-hidden relative">
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
                        class="swiper-button-next w-10! h-10! bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-zinc-400 hover:scale-110 transition-all duration-300">
                        <flux:icon name="arrow-right" class="w-5! !h-5 text-gray-800" />
                    </div>
                    <div
                        class="swiper-button-prev w-10! h-10! bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-zinc-400 hover:scale-110 transition-all duration-300">
                        <flux:icon name="arrow-left" class="w-5! !h-5 text-gray-800" />
                    </div>
                </div>

                {{-- Price and Details Section --}}
                <div class="mt-6 space-y-4">
                    <div class="flex items-center gap-3 text-gray-900">
                        <span class="text-xl font-semibold">Price $99.00 per day</span>
                    </div>

                    <div class="flex items-start gap-2 text-gray-700">
                        <flux:icon name="map-pin" class="w-5 h-5 mt-1 flex-shrink-0" />
                        <span>Pickup @ 1425 W Airport Fwy Irving TX 75062</span>
                    </div>

                    <div class="space-y-2">
                        <h3 class="font-semibold text-gray-900">Details :</h3>
                        <p class="text-gray-700">Daily payouts as per Uber Earnings Clock- No waiting weeks—your
                            earnings hit your account every day.</p>
                    </div>

                    <div class="text-gray-700 leading-relaxed">
                        <p>2025 Nissan Sentra qualifies for Courier, Share, UberX ride tiers and rents for $99/day with
                            a $200 refundable deposit. Commercial rideshare insurance covering liability and damage
                            protection is included.</p>
                    </div>

                    <div class="text-gray-700 relative group" x-data="{ expanded: false, showButton: false }" x-init="$nextTick(() => {
                        showButton = $refs.text.scrollHeight > $refs.text.clientHeight;
                    })">

                        <!-- Text block with clamp -->
                        <div :class="expanded ? '' : 'line-clamp-1'" x-ref="text">
                            <p>
                                Designed for cost-effective shifts with regular maintenance, this vehicle ensures
                                reliability and comfort. Perfect for rideshare drivers looking for a dependable and
                                fuel-efficient option. The Nissan Sentra offers excellent fuel economy, spacious
                                interior, and modern safety features that make it ideal for daily rideshare operations.
                            </p>
                        </div>

                        <!-- Read More / Read Less button -->
                        <template x-if="showButton">
                            <button @click="expanded = !expanded"
                                class="text-zinc-600 hover:text-zinc-700 font-medium mt-1 transition-opacity duration-300">
                                <span x-text="expanded ? 'Read Less' : 'Read More...'"></span>
                            </button>
                        </template>
                    </div>

                </div>

            </div>

            {{-- Right Side - Booking Section --}}
            <div class="w-full lg:w-1/3">
                <div class="bg-white border border-gray-200 rounded-lg p-6 sticky top-4">
                    <div class="space-y-4">
                        <div class="text-sm text-gray-600">
                            Oct 02 08:00 - Nov 01 23:30
                        </div>

                        <button
                            class="w-full bg-zinc-500 hover:bg-zinc-600 text-white font-semibold py-3 rounded-lg transition-colors">
                            Book
                        </button>

                        <button
                            class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-lg transition-colors">
                            Get in touch
                        </button>

                        <div class="pt-4 border-t border-gray-200">
                            <h3 class="font-semibold text-gray-900 mb-3">Policies</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                I hereby agree to the terms and conditions of the Lease Agreement with Host
                            </p>
                            <button class="text-zinc-600 hover:text-zinc-700 text-sm font-medium mt-2">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            var swiper = new Swiper(".mySwiper", {
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
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
