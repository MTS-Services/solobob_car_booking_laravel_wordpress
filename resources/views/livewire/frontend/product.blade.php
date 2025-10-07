<section x-data="{ showModal: false, modalOpen: false }">
    {{-- inner banner --}}
    <div class="relative w-full h-[40vh] bg-cover bg-center bg-no-repeat overflow-hidden"
        style="background-image: url('{{ asset('assets/images/inner_banner_bg.png') }}');">
        {{-- Main Content Container --}}
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">

                {{-- Left Side - "Cars List" Text --}}
                <div class="flex-1 flex justify-center">
                    <a href="#" wire:navigate class="text-3xl lg:text-4xl font-normal text-gray-900 tracking-wide">
                        Cars List
                    </a>
                </div>

                {{-- Right Side - Car Image --}}
                <div class="flex-1 flex justify-start items-center">
                    <div class="max-w-[400px] -translate-x-8">
                        <img src="{{ asset('assets/images/banner_car.png') }}" alt="Gray SUV Car"
                            class="w-full h-auto drop-shadow-2xl" />
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="max-w-7xl bg-white mx-auto px-4 py-4 sm:px-6 lg:px-8 xl:py-14">
        <div class="grid grid-cols-1 xxs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            <!-- Loop through the dynamic products data -->
            @forelse ($products as $vehicle)
                <div
                    class="w-full bg-white rounded-xl shadow-2xl overflow-hidden transform hover:scale-[1.02] transition duration-300 ease-in-out group">

                    <div class="relative">
                        <div
                            class="flex gap-1 absolute top-2 right-4 items-center bg-black/10 text-xs backdrop-blur-md rounded-full px-2 p-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span>
                                <flux:icon name="photo" class="w-4 h-4 text-white" />
                            </span>
                            <span class="text-gray-200 font-medium">
                                {{ $vehicle->id }}
                            </span>
                        </div>

                        <div class="h-48">
                            <!-- Dynamic Image Source -->
                            <a href="{{ route('product-details', ['slug' => $vehicle->slug]) }}" wire:navigate>
                                @if (isset($vehicle?->images) && $vehicle?->images?->count() > 0)
                                    <img class="w-full h-full object-cover"
                                        src="{{ storage_url($vehicle?->images?->first()?->image) }}"
                                        alt="{{ $vehicle->title }} Image">
                                @else
                                    <img src="{{ asset('assets/images/default/no_img.jpg') }}"
                                        alt="{{ $vehicle->title }} Image">
                                @endif
                            </a>
                        </div>

                        <!-- Dynamic Category Tag -->
                        <span
                            class="absolute bottom-2 left-2 bg-accent text-white text-xs xxs:text-sm font-semibold px-3 py-1.5 rounded-md shadow-lg tracking-wider">
                            {{ $vehicle->category?->name ?? 'Uncategorized' }}
                        </span>

                        <div class="absolute bottom-2 right-4 text-zinc-500 p-1">
                            <flux:icon name="eye" class="w-5 h-5" />
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="grow">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <!-- Dynamic Vehicle Title -->
                                    <p
                                        class="text-xs xs:text-sm md:text-base font-normal text-gray-700 uppercase leading-snug">
                                        {{ $vehicle->title }}
                                    </p>
                                </div>
                                <div class="text-right text-gray-900 font-bold text-lg md:text-xl flex-shrink-0 ml-2">
                                    <!-- Dynamic Daily Rate -->
                                    ${{ number_format($vehicle->weekly_rate, 2) }}
                                    <span class="text-xs sm:text-sm font-medium text-gray-500 ml-1">/Day</span>
                                </div>
                            </div>

                            <!-- Dynamic Owner Location -->
                            <div class="flex items-center text-xs sm:text-sm text-gray-500">
                                <flux:icon name="map-pin" class="text-zinc-500 mr-2 w-4 h-4 sm:w-5 sm:h-5" />
                                <span>{{ $vehicle->owner?->city ?? 'Location Not Set' }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 my-2"></div>

                        <div class="flex justify-between items-center text-gray-600 text-xs">
                            <!-- Dynamic Seating Capacity -->
                            <div class="flex items-center">
                                <flux:icon name="users" class="text-zinc-500 mr-1 w-4 h-4 sm:w-5 sm:h-5" />
                                <span class="font-semibold text-gray-800">{{ $vehicle->seating_capacity }}</span>
                                Persons
                            </div>

                            <!-- Dynamic Transmission Type -->
                            <div class="flex items-center">
                                <flux:icon name="cog" class="w-4 h-4 sm:w-5 sm:h-5 text-zinc-500 mr-1" />
                                {{ $vehicle->transmission_type == 0 ? 'Auto' : 'Manual' }}
                            </div>

                            <!-- Dynamic Year -->
                            <div class="flex items-center">
                                <flux:icon name="calendar" class="text-zinc-500 mr-1 w-4 h-4 sm:w-5 sm:h-5" />
                                <span class="font-semibold text-gray-800">{{ $vehicle->year }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-3 mt-4 sm:mt-6">

                            <a href="{{ route('booking') }}" wire:navigate
                                class="flex-1 flex items-center justify-center bg-accent text-white py-2 px-2 text-sm rounded-lg font-semibold shadow-md hover:bg-accent/90 transition duration-150 transform hover:scale-[1.01]">
                                <flux:icon.book-open class="w-5 h-5 mr-2" />
                                Book
                            </a>

                            <button @click="modalOpen = true; document.body.style.overflow = 'hidden'"
                                class="flex-1 flex items-center justify-center bg-gray-800 text-white py-2 px-2 text-sm rounded-lg font-semibold shadow-md hover:bg-gray-700 transition duration-150 transform hover:scale-[1.01]">
                                Get In touch
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <flux:icon name="inbox" class="w-16 h-16 mx-auto text-gray-400 mb-4" />
                    <p class="text-gray-500 text-lg">No vehicles available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Dynamic Pagination -->
        @if ($products->hasPages())
            <div class="flex justify-center items-center mt-8 mb-4 space-x-2">
                @php
                    $currentPage = $products->currentPage();
                    $totalPages = $products->lastPage();

                    // Calculate page range to display
                    $rangeWithDots = [];

                    if ($totalPages <= 5) {
                        // Show all pages if 5 or less
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $rangeWithDots[] = $i;
                        }
                    } else {
                        // Always show first page
                        $rangeWithDots[] = 1;

                        // Determine which pages to show around current page
                        $start = max(2, $currentPage - 1);
                        $end = min($totalPages - 1, $currentPage + 1);

                        // Add left ellipsis if needed
                        if ($start > 2) {
                            $rangeWithDots[] = '...';
                        }

                        // Add pages around current page
                        for ($i = $start; $i <= $end; $i++) {
                            $rangeWithDots[] = $i;
                        }

                        // Add right ellipsis if needed
                        if ($end < $totalPages - 1) {
                            $rangeWithDots[] = '...';
                        }

                        // Always show last page
                        $rangeWithDots[] = $totalPages;
                    }
                @endphp

                <!-- Previous Button -->
                <button wire:click="previousPage" @if ($currentPage === 1) disabled @endif
                    class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Page Numbers -->
                @foreach ($rangeWithDots as $page)
                    @if ($page === '...')
                        <button disabled
                            class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-400 cursor-default">
                            ...
                        </button>
                    @else
                        <button wire:click="gotoPage({{ $page }})"
                            class="w-10 h-10 flex items-center justify-center rounded-lg font-medium transition duration-150
                        @if ($currentPage === $page) bg-zinc-500 text-white @else border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 @endif">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach

                <!-- Next Button -->
                <button wire:click="nextPage" @if ($currentPage === $totalPages) disabled @endif
                    class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        @endif
        <div x-show="modalOpen" x-cloak @click="modalOpen = false; document.body.style.overflow = ''"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/30 bg-opacity-50"
            style="display: none;">
            <div @click.stop x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="relative">
                    <button @click="modalOpen = false; document.body.style.overflow = ''" type="button"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-3xl font-light leading-none z-10">
                        &times;
                    </button>
                </div>

                <div class="p-6 md:p-8">
                    <h2 class="text-xl md:text-2xl font-semibold mb-6 text-gray-800 uppercase">
                        {{ $vehicle->year }} {{ $vehicle->title }}
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="w-full">
                            <img src="{{ storage_url($vehicle->avatar) }}" alt="{{ $vehicle->title }}"
                                class="w-full h-64 md:h-80 object-cover rounded-lg">
                        </div>

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
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
