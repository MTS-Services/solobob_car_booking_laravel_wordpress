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
                            <input   wire:model="email" type="email" placeholder="enter your email"  required  autofocus  autocomplete="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input  wire:model="password" type="password" placeholder="password"  type="password"  required autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center">
                                <input type="checkbox"
                                    class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                                <span class="ml-2 text-gray-600">Keep me logged in</span>
                            </label>
                            <a href="#" class="text-black font-medium hover:underline">Forgot your password?</a>
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit"
                            class="w-full bg-[#B79347] text-white py-3 rounded-md font-semibold hover:bg-gray-800 transition duration-200">
                            Log In
                        </button>
                        <!-- Sign Up Link -->
                        <p class="text-center text-sm text-gray-600">
                            Don't have an account? <a href="#" class="text-black font-medium hover:underline">Sign
                                Up</a>
                        </p>


                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Or</span>
                            </div>
                        </div>

                        <!-- Social Login Buttons -->
                        <button type="button"
                            class="w-full bg-white border-2 border-gray-300 text-gray-700 py-3 rounded-md font-semibold hover:bg-gray-50 transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" viewBox="0 0 48 48">
                                <g>
                                    <path fill="#4285F4"
                                        d="M24 9.5c3.54 0 6.49 1.22 8.62 3.23l6.41-6.41C34.64 2.54 29.74 0 24 0 14.82 0 6.91 5.82 2.99 14.29l7.89 6.13C12.6 13.97 17.82 9.5 24 9.5z" />
                                    <path fill="#34A853"
                                        d="M46.14 24.55c0-1.64-.15-3.22-.42-4.74H24v9.01h12.44c-.54 2.91-2.18 5.38-4.66 7.04l7.19 5.6C43.96 37.13 46.14 31.41 46.14 24.55z" />
                                    <path fill="#FBBC05"
                                        d="M10.88 28.42A14.49 14.49 0 0 1 9.5 24c0-1.54.26-3.03.72-4.42l-7.89-6.13A23.97 23.97 0 0 0 0 24c0 3.82.92 7.43 2.54 10.55l8.34-6.13z" />
                                    <path fill="#EA4335"
                                        d="M24 48c6.48 0 11.93-2.14 15.91-5.82l-7.19-5.6c-2 1.35-4.56 2.16-8.72 2.16-6.18 0-11.4-4.47-13.09-10.45l-8.34 6.13C6.91 42.18 14.82 48 24 48z" />
                                    <path fill="none" d="M0 0h48v48H0z" />
                                </g>
                            </svg>
                            Sign up with Google
                        </button>

                        <button type="button"
                            class="w-full bg-black text-white py-3 rounded-md font-semibold hover:bg-gray-800 transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.53 4.08l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z" />
                            </svg>
                            Sign Up with Apple
                        </button>

                        <button type="button"
                            class="w-full bg-blue-600 text-white py-3 rounded-md font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center gap-2">
                            <span class="text-xl">f</span>
                            Log in with Facebook
                        </button>
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
