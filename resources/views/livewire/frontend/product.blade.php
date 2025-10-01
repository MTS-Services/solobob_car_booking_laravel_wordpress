    <section>
        {{-- inner banner --}}
        <div class="relative  w-full bg-gray-50 overflow-hidden h-[65vh]">

            {{-- Blue Diagonal Stripes Background --}}
            {{-- <div class="absolute inset-0 pointer-events-none"> --}}
            {{-- Main Large Blue Diagonal Stripe --}}
            {{-- <div class="absolute top-0 right-[-35%] h-full w-[65%] bg-zinc-500 skew-x-[-35deg] origin-top-right"></div> --}}

            {{-- White Diagonal Stripe --}}
            {{-- <div class="absolute top-0 right-[20%] h-full w-[2%] bg-white z-40 skew-x-[-35deg] origin-top-right"></div> --}}

            {{-- Secondary Blue Diagonal Stripe --}}
            {{-- <div class="absolute top-0 right-[-20%] h-full w-[52%] bg-zinc-500 skew-x-[-35deg] origin-top-right"></div> --}}
            {{-- </div> --}}

            {{-- Main Content Container --}}
            <div class=" z-50 container mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex items-center justify-between h-full">

                    {{-- Left Side - "Cars List" Text --}}
                    <div class="flex-1 flex justify-center">
                        <a href="#" wire:navigate
                            class="text-3xl lg:text-4xl font-normal text-gray-900 tracking-wide">
                            Cars List
                        </a>
                    </div>

                    {{-- Right Side - Car Image --}}
                    <div class="flex-1 flex justify-start items-center z-50!">
                        <div class="max-w-[600px] -translate-x-8">
                            <img src="{{ asset('assets/images/banner_car.png') }}" alt="Gray SUV Car"
                                class="w-full h-auto drop-shadow-2xl" />
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
