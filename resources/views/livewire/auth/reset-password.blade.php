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
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-[#B79347]">Reset password</h3>

                    <p class="text-gray-600 text-sm mb-4">
                        Please enter your new password below
                    </p>
                    <x-auth-session-status class="text-center mb-4" :status="session('status')" />

                    <form method="POST" wire:submit="resetPassword" class="flex flex-col gap-6" class="space-y-4">
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
                        @error('password')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <!-- Password Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm password</label>
                            <input wire:model="password_confirmation" type="password" placeholder="Confirm password" type="password"
                                required autocomplete="current-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit"
                            class="w-full bg-[#B79347] text-white py-3 rounded-md font-semibold hover:bg-gray-800 transition duration-200">
                            Reset password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="flex items-center justify-center min-h-screen p-4 sm:p-0">
        <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
            <div class="flex flex-col gap-6">
                <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

                <x-auth-session-status class="text-center" :status="session('status')" />

                <form method="POST" wire:submit="resetPassword" class="flex flex-col gap-6">
                    <flux:input wire:model="email" :label="__('Email')" type="email" required
                        autocomplete="email" />

                    <flux:input wire:model="password" :label="__('Password')" type="password" required
                        autocomplete="new-password" :placeholder="__('Password')" viewable />

                    <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password"
                        required autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

                    <div class="flex items-center justify-end">
                        <flux:button type="submit" variant="primary" class="w-full">
                            {{ __('Reset password') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}


</div>
