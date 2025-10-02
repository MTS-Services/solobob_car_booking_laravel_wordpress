 

<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">

     <div class="bg-black max-w-7xl mx-auto rounded-lg overflow-hidden shadow-2xl border-4 ">
        <div class="flex flex-col md:flex-row">
            <!-- Left Side - Car Image -->
            <div class="w-full md:w-1/2 relative h-64 md:h-auto">
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80" alt="Luxury Car"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                
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

                    <div class="flex flex-col gap-6">
                    <x-auth-header  :title="__('Create an account')"  :description="__('Enter your details below to create your account')"  />

                    <x-auth-session-status class="text-center " :status="session('status')" />
                              
                        <form method="POST" wire:submit="register" class="flex flex-col gap-6 ">
                            <flux:input   wire:model="name" :label="__('Name')"  type="text" required autofocus autocomplete="name"
                                :placeholder="__('Full name')" />

                            <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email" class="mt-4 "
                                placeholder="email@example.com" />  

                            <flux:input  wire:model="password" :label="__('Password')" type="password" required
                                autocomplete="new-password" :placeholder="__('Password')" viewable />

                            <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
                                autocomplete="new-password" :placeholder="__('Confirm password')" viewable />
                            <div class="flex items-center justify-end ">
                                
                            <button 
                                type="submit" 
                                class="w-full bg-[#B79347]  text-white font-medium py-2 px-4 rounded-lg">
                                Create account
                            </button>
                            </div>

                        </form>

                    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                        <span>{{ __('Already have an account?') }}</span>
                        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
                    </div>
                </div>
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