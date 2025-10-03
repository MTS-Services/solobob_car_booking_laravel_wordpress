<div class="container mx-auto p-6 space-y-6">
    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif

    <form wire:submit.prevent="updateProfile">
        <!-- Basic Information Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        wire:model="name"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror"
                        placeholder="Enter Full Name"
                    >
                    @error('name')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        wire:model="email"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror"
                        placeholder="Enter Email"
                    >
                    @error('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="number" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="number" 
                        wire:model="number"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition @error('number') border-red-500 @enderror"
                        placeholder="Enter Phone Number"
                    >
                    @error('number')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Address Information Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Address Information</h2>
            
            <!-- Address Type -->
            <div class="mb-6">
                <label for="address_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Address Type
                </label>
                <select 
                    id="address_type" 
                    wire:model="address_type"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                >
                    <option value="0">Personal</option>
                    <option value="1">Residential</option>
                    <option value="2">Parking</option>
                </select>
            </div>

            <!-- Address -->
            <div class="mb-6">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                    Address
                </label>
                <textarea 
                    id="address" 
                    wire:model="address"
                    rows="4"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition resize-none @error('address') border-red-500 @enderror"
                    placeholder="Enter Address"
                ></textarea>
                @error('address')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- State, City, ZIP Code -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                        State
                    </label>
                    <input 
                        type="text" 
                        id="state" 
                        wire:model="state"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition @error('state') border-red-500 @enderror"
                        placeholder="Enter State"
                    >
                    @error('state')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        City
                    </label>
                    <input 
                        type="text" 
                        id="city" 
                        wire:model="city"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition @error('city') border-red-500 @enderror"
                        placeholder="Enter City"
                    >
                    @error('city')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- ZIP Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                        ZIP Code
                    </label>
                    <input 
                        type="text" 
                        id="postal_code" 
                        wire:model="postal_code"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition @error('postal_code') border-red-500 @enderror"
                        placeholder="Enter ZIP Code"
                    >
                    @error('postal_code')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button 
                type="submit"
                wire:loading.attr="disabled"
                class="px-8 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-medium rounded-lg transition duration-200 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
            >
                <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                <span wire:loading wire:target="updateProfile">Saving...</span>
                
                <!-- Loading Spinner -->
                <svg wire:loading wire:target="updateProfile" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>