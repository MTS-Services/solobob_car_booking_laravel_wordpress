<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">

    <div class="bg-black max-w-7xl mx-auto rounded-lg overflow-hidden shadow-2xl border-4 ">
        <div class="flex flex-col md:flex-row">
            <!-- Left Side - Car Image -->
            <div class="w-full md:w-1/2 relative h-64 md:h-auto">
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80" alt="Luxury Car"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                     
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 bg-white p-8 md:p-10">
                <div class="max-w-md mx-auto">
                    <h1 class="text-3xl md:text-2xl font-semibold mb-2">YOUR GATEWAY TO</h1>
                    <h2 class="text-3xl md:text-2xl font-semibold mb-2">UNFORGETTABLE JOURNEYS</h2>
                    <h3 class="text-xl md:text-2xl font-semibold mb-6 text-[#B79347]">Login to Your Account</h3>

                    {{-- <p class="text-gray-600 text-sm mb-8">
                       Please verify your email address by clicking on the link we just emailed to you
                    </p> --}}
                    <flux:text class="text-center text-gray-500">
                                {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
                            </flux:text>

                     <div class="flex items-center justify-center p-4 sm:p-0">
                    <div class=" p-6 sm:p-8 w-full max-w-sm">
                        <div class="mt-4 flex flex-col gap-6">
                            

                            @if (session('status') == 'verification-link-sent')
                                <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </flux:text>
                            @endif

                            <div class="flex flex-col items-center justify-between space-y-3 ">
                                {{-- <flux:button wire:click="sendVerification" variant="primary" class="w-full ">
                                    {{ __('Resend verification email') }}
                                </flux:button> --}}

                                <button wire:click="sendVerification" type="submit"
                                    class="flex flex-col items-center justify-between space-y-3 text-white bg-[#B79347] hover:bg-[#B79347]/80 focus:ring-4 focus:outline-none focus:ring-[#B79347]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    {{ __('Resend verification email') }}
                                </button>

                                <flux:link class="text-sm cursor-pointer " wire:click="logout">
                                    {{ __('Log out') }}
                                </flux:link>
                            </div>
                        </div>
                    </div>
                </div>  
                </div>
            </div>
        </div>
    </div>
     

</div>






