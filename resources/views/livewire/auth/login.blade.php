<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">

    <div class="bg-black max-w-7xl mx-auto rounded-lg overflow-hidden shadow-2xl border-4 ">
        <div class="flex flex-col md:flex-row">
            <!-- Left Side - Car Image -->
            <div class="w-full md:w-1/2 relative h-64 md:h-auto">
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80" alt="Luxury Car"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <h2 class="text-lg md:text-xl font-semibold italic leading-tight mb-2">
                        Whether you're dreaming of sun-soaked beaches, bustling cityscapes, or serene mountain retreats,
                        your adventure starts here.
                    </h2>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 bg-white p-8 md:p-10">
                <div class="max-w-md mx-auto">
                    <h1 class="text-3xl md:text-2xl font-semibold mb-2">YOUR GATEWAY TO</h1>
                    <h2 class="text-3xl md:text-2xl font-semibold mb-2">UNFORGETTABLE JOURNEYS</h2>
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-[#B79347]">Login to Your Account</h3>

                    <p class="text-gray-600 text-sm mb-8">
                        From the buzz of iconic cities to the tranquility of hidden gems, we bring the world to your
                        fingertips. Start exploring today
                    </p>

                    <form method="POST" wire:submit="login" class="flex flex-col gap-6" class="space-y-4">
                        <!-- Email Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input wire:model="email" type="email" placeholder="enter your email" required autofocus
                                autocomplete="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input wire:model="password" type="password" placeholder="password" type="password" required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                                <span class="ml-2 text-gray-600">Keep me logged in</span>
                            </label>
                            <a href="{{ route('password.request') }}"
                                class="text-black font-medium hover:underline">Forgot your password?</a>
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit"
                            class="w-full bg-[#B79347] text-white py-3 rounded-md font-semibold hover:bg-gray-800 transition duration-200">
                            Log In
                        </button>
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Or</span>
                            </div>
                        </div>
                        <!-- Sign Up Link -->
                        <p class="text-center text-sm text-gray-600">
                            Don't have an account? <a href="{{ route('register') }}"
                                class="text-black font-medium hover:underline">Sign
                                Up</a>
                        </p>
                        <!-- Divider -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" wire:submit="login" class="flex flex-col gap-6">
                <flux:input
                    wire:model="email"
                    :label="__('Email address')"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                />

                <div class="relative">
                    <flux:input
                        wire:model="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="current-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </flux:link>
                    @endif
                </div>

                <flux:checkbox wire:model="remember" :label="__('Remember me')" />

                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                    <span>{{ __('Don\'t have an account?') }}</span>
                    <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
                </div>
            @endif
        </div>
    </div> --}}

</div>
