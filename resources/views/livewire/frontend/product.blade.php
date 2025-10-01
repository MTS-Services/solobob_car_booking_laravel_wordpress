    <section>
        {{-- inner banner --}}
        <div class="relative w-full h-[65vh] bg-cover bg-center bg-no-repeat overflow-hidden"
            style="background-image: url('{{ asset('assets/images/inner_banner_bg.png') }}');">
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
                        <div class="max-w-[450px] -translate-x-8">
                            <img src="{{ asset('assets/images/banner_car.png') }}" alt="Gray SUV Car"
                                class="w-full h-auto drop-shadow-2xl" />
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="max-w-7xl bg-white mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <div
                    class="w-full bg-white rounded-xl shadow-2xl overflow-hidden transform hover:scale-[1.02] transition duration-300 ease-in-out">

                    <!-- Image Section -->
                    <div class="relative">
                        <!-- Dynamic Image -->
                        <div class="h-58 ">
                            <img class="w-full h-full object-cover" src="{{ asset('assets/images/car (1).avif') }}"
                                alt="Product Image">
                        </div>

                        <!-- Overlay Badge -->
                        <span
                            class="absolute bottom-2 left-2 bg-accent text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow-lg tracking-wider">
                            Courier, Share, UberX
                        </span>

                        <!-- Logo Overlay -->
                        <div class="absolute bottom-2 right-4 text-white p-1 ">
                            <flux:icon name="eye" class="w-5 h-5" />

                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-4">
                        <!-- Title and Price Row -->
                        <div class="p-2">
                            <div class="flex justify-between  items-center mb-2">
                                <div>
                                    <p class="text-base  font-normal text-gray-700 uppercase leading-none">2025 Nissan  Kicks  S
                                    </p>
                                    {{-- <h2 class="text-xl font-extrabold text-gray-900 leading-tight">ELANTRA SEL SPORT
                                    </h2> --}}
                                </div>
                                <div class="text-right text-gray-900 font-bold text-xl">
                                    $99 <span class="text-sm font-medium text-gray-500 ml-1">/Day</span>
                                </div>

                            </div>

                            <!-- Location -->
                            <div class="flex items-center text-sm  text-gray-500">
                                <flux:icon name="map-pin" class="text-zinc-500 mr-2 w-5 h-5" />
                                <span>Dallas, Texas</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 my-2"></div>

                        <!-- Features Row -->
                        <div class="flex justify-between items-center text-gray-600">

                            <!-- Persons -->
                            <div class="flex items-center text-sm">
                                <flux:icon name="users" class="text-zinc-500 mr-1 w-5 h-5" />
                                <span class="font-semibold text-gray-800">5</span> Persons
                            </div>

                            <!-- CarPlay -->
                            <div class="flex items-center text-sm">
                                {{-- <flux:icon name="smartphone" class="text-zinc-500 mr-1 w-5 h-5" /> --}}
                                <flux:icon name="smartphone" class="w-5 h-5 text-zinc-500" />
                                CarPlay
                            </div>

                            <!-- Trips -->
                            <div class="flex items-center text-sm">
                                <flux:icon name="calendar" class="text-zinc-500 mr-1 w-5 h-5" />
                                <span class="font-semibold text-gray-800">4</span> Trips
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-6">

                            <!-- Book Button -->
                            <button
                                class="flex-1 flex items-center justify-center bg-accent text-white py-2! px-2! text-sm rounded-lg font-semibold shadow-md hover:bg-zinc-700 transition duration-150 transform hover:scale-[1.01]">
                                <flux:icon.book-open class="w-5 h-5 mr-2" />

                                Book
                            </button>

                            <!-- Get In Touch Button -->
                            <button
                                class="flex-1 bg-gray-800 text-white py-2! px-2! rounded-lg font-semibold shadow-md hover:bg-gray-700 transition duration-150 transform hover:scale-[1.01]">
                                Get In touch
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
