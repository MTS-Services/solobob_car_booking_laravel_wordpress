<!-- Header -->
<header x-data="{ toggleMenu: false }" class="bg-white shadow-md w-full">
    <div class="container">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="{{ asset('assets/logo/transparent-resizing-logo.png') }}" alt="Logo" class="h-12 md:h-20 w-auto" />
            </a>

            <!-- Navigation + Button -->
            <div class="flex items-center gap-8">
                <!-- Navigation Links (Desktop only) -->
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" wire:navigate
                        class="text-gray-900 hover:text-zinc-500 hover:-translate-y-1 transition-all duration-300 ease-in-out">
                        HOME
                    </a>
                    <a href="{{ route('products') }}" wire:navigate
                        class="text-gray-900 hover:text-zinc-500 hover:-translate-y-1 transition-all duration-300 ease-in-out">
                        PRODUCT
                    </a>
                    <a href="/"
                        class="text-gray-900 hover:text-zinc-500 hover:-translate-y-1 transition-all duration-300 ease-in-out">
                        APPLICATION
                    </a>
                    <a href="#"
                        class="text-gray-900 hover:text-zinc-500 hover:-translate-y-1 transition-all duration-300 ease-in-out">
                        CONTACT
                    </a>
                    <a href="#"
                        class="text-gray-900 hover:text-zinc-500 hover:-translate-y-1 transition-all duration-300 ease-in-out">
                        SIGN AGREEMENT
                    </a>
                </nav>

                <!-- Call-to-Action + Mobile Menu Button -->
                <div class="flex items-center gap-4">
                    <a href="/register"
                        class="bg-zinc-700 hover:bg-zinc-600 duration-300 text-white px-4 md:px-6 py-2 md:py-2.5 rounded-full font-medium">
                        EXPLORE OUR CAR
                    </a>

                    <!-- Mobile Menu Button (Visible only on small screens) -->
                    <button @click="toggleMenu = !toggleMenu"
                        class="lg:hidden p-2 rounded-lg bg-zinc-700 hover:bg-zinc-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- Sidebar -->
    {{-- transition left to right using alipine --}}
    <aside x-show="toggleMenu" x-transition 
        x-on:click.outside="toggleMenu = false"

        class="fixed top-0 right-0 z-50 p-2 h-screen transition-transform overflow-y-auto lg:hidden">
        <div class="p-4 w-full max-w-72 bg-zinc-50 rounded-lg shadow h-full ml-auto">

            <!-- Header: Logo & Close Button -->
            <div class="flex items-center justify-between mb-4">
                <a href="/" class="items-center justify-start inline-flex">
                    <img src="{{ asset('assets/logo/transparent-resizing-logo.png') }}" alt="Logo"
                        class="h-10 w-auto" />
                </a>
                <button x-on:click="toggleMenu = false"
                    class="p-2 rounded-lg bg-zinc-700 hover:bg-zinc-600 transition-colors">
                    <flux:icon name="x" class="w-6 h-6 text-white" />
                </button>
            </div>

            <!-- Navigation Links -->
            <nav>
                <a href="/"
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Home</a>
                <a href="/"
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Application</a>
                <a href="#"
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Contact</a>
                <a href="#"
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Sign
                    Agreement</a>

                <!-- If user is authenticated -->
                <a href="/profile"
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Profile</a>
                <a href="/dashboard"
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Dashboard</a>
                <button
                    class="block text-sm py-2 px-4 text-gray-900 hover:text-zinc-500 transition-all duration-300 ease-in-out uppercase">Logout</button>
            </nav>
        </div>
        </a>

</header>
