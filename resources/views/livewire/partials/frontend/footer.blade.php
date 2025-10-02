<footer class="bg-[#1A1A1A] text-white">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            <!-- Logo & Description -->
            <div>
                <div class="flex items-center mb-4">
                    <img src="{{ asset('assets/logo/transparent-logo.png') }}" alt="Logo" class="h-20 w-auto" />
                </div>
                <p class="text-gray-400 text-sm mb-4">
                    Flexible Car Rentals for Gig Workers & Local Businesses
                </p>
                <div class="flex gap-3">
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-zinc-500 flex items-center justify-center hover:bg-opacity-80 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24">
                            <path
                                d="M22 12.07c0-5.53-4.48-10-10-10S2 6.54 2 12.07c0 4.99 3.65 9.13 8.44 9.88v-6.99h-2.54v-2.89h2.54V9.41c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56v1.87h2.77l-.44 2.89h-2.33v6.99C18.35 21.2 22 17.06 22 12.07z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-zinc-500 flex items-center justify-center hover:bg-opacity-80 transition-colors">
                        <flux:icon name="twitter" class="w-6 h-6" />
                    </a>
                    <a href="#"
                        class="w-8 h-8 rounded-full bg-zinc-500 flex items-center justify-center hover:bg-opacity-80 transition-colors">
                        <flux:icon name="instagram" class="w-6 h-6" />
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-white">QUICK LINKS</h3>
                <ul class="space-y-2 text-gray-400">
                    <li>
                        <a href="/apply" class="hover:text-zinc-500 transition-colors flex items-center text-gray-400">
                            <span class="mr-2 ">
                                <flux:icon name="chevrons-right" class="w-4 stroke-zinc-500" />
                            </span> Apply
                        </a>
                    </li>
                    <li>
                        <a href="/contact" class="hover:text-zinc-500 transition-colors flex items-center text-gray-400">
                            <span class="mr-2 text-zinc-800">
                                <flux:icon name="chevrons-right" class="w-4 stroke-zinc-500" />
                            </span> Contact
                        </a>
                    </li>
                    <li>
                        <a href="/sign-agreement" class="hover:text-zinc-500 transition-colors flex items-center text-gray-400">
                            <span class="mr-2 text-zinc-500">
                                <flux:icon name="chevrons-right" class="w-4 stroke-zinc-500" />
                            </span> Sign Agreement
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-white">CONTACT INFO</h3>
                <ul class="space-y-3 text-gray-400">
                    <li class="flex items-center text-gray-400">
                        <span class="mr-2 text-zinc-500">
                            <flux:icon name="phone" class="w-4 stroke-zinc-500" />
                        </span> 0123456789
                    </li>
                    <li class="flex items-center text-gray-400">
                        <span class="mr-2 text-zinc-500">
                            <flux:icon name="mail" class="w-4 stroke-zinc-500" />
                        </span> moneylord513@gmail.com
                    </li>
                    <li class="flex items-center text-gray-400">
                        <span class="mr-2 text-zinc-500">
                            <flux:icon name="map-pin" class="w-4 stroke-zinc-500" />
                        </span> Grand Prairie, TX
                    </li>
                </ul>
            </div>

            <!-- Working Hours -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-white">WORKING HOURS</h3>
                <p class="text-gray-400 flex items-center">
                    <span class="mr-2 text-zinc-500">
                        <flux:icon name="clock-3" class="w-4 stroke-zinc-500" />
                    </span> Monday - Friday
                </p>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="bg-zinc-500 py-4">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-white">
                &copy; 2025 B33 Rentals. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>
