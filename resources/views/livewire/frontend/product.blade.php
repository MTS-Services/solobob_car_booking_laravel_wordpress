    <section>
        {{-- inner banner --}}
        <div class=" w-full bg-gray-50 overflow-hidden h-[65vh]">
              {{-- <div class="relative w-full h-[65vh] bg-cover bg-center bg-no-repeat overflow-hidden"
            style="background-image: url('{{ asset('assets/images/inner_banner_bg.png') }}');"> --}}

            {{-- Overlay (optional, if you want a soft white tint on the image) --}}
            {{-- <div class="absolute inset-0 bg-text-primary/10 z-10"></div> --}}

            {{-- Main Content Container --}}
            <div class="relative z-50 container mx-auto px-4 sm:px-6 lg:px-8 h-full">
                <div class="flex items-center justify-between h-full">

                    {{-- Left Side - "Cars List" Text --}}
                    <div class="flex-1 flex justify-center">
                        <a href="#" wire:navigate
                            class="text-3xl lg:text-4xl font-normal text-gray-900 tracking-wide">
                            Cars List
                        </a>
                    </div>

                    {{-- Right Side - Car Image --}}
                    <div class="flex-1 flex justify-start items-center">
                        <div class="max-w-[550px] -translate-x-8">
                            <img src="{{ asset('assets/images/banner_car.png') }}" alt="Gray SUV Car"
                                class="w-full h-auto drop-shadow-2xl" />
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </section>
