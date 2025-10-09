<section class="container mx-auto mt-5">
    <div class="grid lg:grid-cols-3 gap-5">
        {{-- Left Column: Profile Image and Role --}}
        <div class="flex flex-col h-auto shadow rounded-xl p-6">
            <h1 class="text-xl text-bg-black font-bold">Profile Image</h1>

            <div class="w-28 h-28 rounded-full mx-auto mt-10 border-4 border-black overflow-hidden cursor-pointer"
                onclick="document.getElementById('imageUpload').click()">

                @if ($newImage)
                    <img src="{{ $newImage->temporaryUrl() }}" alt="New Profile Image Preview"
                        class="w-full h-full object-cover">
                @else
                    {{-- <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 text-4xl">{{ $profile->modified_image }}</span>
                    </div> --}}
                    <img src="{{ $profile->modified_image }}" alt="Profile Image" class="w-full h-full object-cover">
                @endif

            </div>

            <input type="file" id="imageUpload" wire:model.live="newImage" accept="image/*" class="hidden">

            <div class="text-center mt-2" wire:loading wire:target="newImage">
                <span class="text-sm text-gray-500">Uploading...</span>
            </div>

            @error('newImage')
                <span class="text-red-500 text-xs text-center mt-1 block">{{ $message }}</span>
            @enderror

            <div class="flex flex-col items-center justify-between mt-6">
                <h1 class="text-2xl font-bold text-center">{{ $profile->name }}</h1>
                <h1 class="text-gray-600">{{ $profile->is_admin_label }}</h1>
            </div>

            {{-- Member Since --}}
            <div class="flex items-start space-x-2">
                <span class="text-gray-500">📅</span>
                <div>
                    <p class="text-gray-500 mb-1">Member Since</p>
                    <p class="font-medium">{{ $profile->created_at_formatted }}</p>
                </div>
            </div>

            {{-- Last Updated --}}
            <div class="flex items-start space-x-2">
                <span class="text-gray-500">📝</span>
                <div>
                    <p class="text-gray-500 mb-1">Last Updated</p>
                    <p class="font-medium">{{ $profile->updated_at_formatted }}</p>
                </div>
            </div>

            {{-- Account Status --}}
            <div class="flex items-start space-x-2">
                <span class="text-gray-500">🟢</span>
                <div>
                    <p class="text-gray-500 mb-1">Account Status</p>
                    <span
                        class="px-3 py-1 rounded-full text-xs badge badge-soft {{ $profile->status_color }} transition">
                        {{ $profile->status_label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Right Column: Profile Information --}}
        <div class="bg-white shadow rounded-xl p-6 col-span-1 lg:col-span-2 relative">
            <h2 class="text-lg font-semibold mb-6">Profile Information</h2>

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="adminUpdate">
                <div class="grid md:grid-cols-2 gap-6 text-sm">
                    {{-- Full Name --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500">👤</span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Full Name</p>
                            <input type="text" wire:model.defer="name"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your name">
                            @error('name')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email Address --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500">📧</span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Email Address</p>
                            <input type="email" wire:model.defer="email"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your email">
                            @error('email')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Phone Number --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"><flux:icon name="phone" class="w-5 h-5 text-gray-500" /></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Phone Number</p>
                            <input type="tel" wire:model.defer="number"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your Phone">
                            @error('number')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    {{-- Date of Birth --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"><flux:icon name="calendar" class="w-5 h-5 text-gray-500" /></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Date of Birth</p>
                            <input type="date" wire:model.defer="date_of_birth"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your Phone">
                            @error('date_of_birth')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"><flux:icon name="map-pin" class="w-5 h-5 text-gray-500" /></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">Address</p>
                            <input type="address" wire:model.defer="address"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your address">
                            @error('address')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- City --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"><flux:icon name="home" class="w-5 h-5 text-gray-500" /></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">City</p>
                            <input type="city" wire:model.defer="city"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your city">
                            @error('city')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- state --}}
                    <div class="flex items-start space-x-2">
                        <span class="text-gray-500"><flux:icon name="map" class="w-5 h-5 text-gray-500" /></span>
                        <div class="flex-1">
                            <p class="text-gray-500 mb-1">State</p>
                            <input type="state" wire:model.defer="state"
                                class="border border-gray-300 rounded-md shadow-sm w-full text-base font-medium p-2 focus:ring-2 focus:ring-black focus:border-transparent"
                                placeholder="Enter your state">
                            @error('state')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Set as Default --}}
                    <div class="flex items-start space-x-2">
                        <div class="flex-1">
                            <div class="flex items-center justify-start gap-5">
                                <input type="checkbox" wire:model.defer="is_default" id="is_default">
                                <label for="is_default" class="text-gray-500 label flex-1">Set as Default
                                    Address</label>
                            </div>
                            @error('is_default')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <button type="submit"
                        class="px-6 py-2 rounded-md dis abled:opacity-50 disabled:cursor-not-allowed "
                        wire:loading.attr="disabled" wire:target="adminUpdate">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-500 hover:bg-zinc-600 rounded-lg transition-colors duration-200">
                            <span class="text-white" wire:loading.remove wire:target="adminUpdate">Update</span>
                            <span class="text-white" wire:loading wire:target="adminUpdate">Saving...</span>
                        </span>
                    </button>
                </div>

            </form>
        </div>

    </div>

</section>
