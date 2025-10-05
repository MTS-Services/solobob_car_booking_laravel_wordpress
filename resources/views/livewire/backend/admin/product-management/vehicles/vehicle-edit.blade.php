<div>
    <section>
        {{-- Header --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                {{-- UPDATED: Title changed from 'Create New Vehicle' to 'Edit Vehicle' --}}
                <h2 class="text-xl font-bold text-accent">{{ __('Edit Vehicle') }}</h2>
                <a href="{{ route('admin.pm.vehicle-list') }}" wire:navigate
                    class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-200 hover:bg-zinc-300 text-zinc-500 rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>

        {{-- Form --}}
        <div class="glass-card rounded-2xl p-6">
            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Title *</label>
                        <input wire:model="title" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="Enter vehicle title">
                        @error('title')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Slug *</label>
                        <input wire:model="slug" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="vehicle-slug">
                        @error('slug')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Owner --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Owner *</label>
                        <select wire:model="owner_id"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                            <option value="">Select Owner</option>
                            @foreach ($owners as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('owner_id')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Category *</label>
                        <select wire:model="category_id"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                            <option value="">Select Category</option>
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>



                    <div>
                        {{-- NOTE: This input should probably be a text/number input for 'year' and not a 'date' type based on the Livewire component's `$year` validation (integer, min 1900, max current year + 1). I will keep the 'date' type as you had it, but be aware of the potential inconsistency. --}}
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Year *</label>
                        <input wire:model="year" type="date"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                        @error('year')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Color --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Color *</label>
                        <input wire:model="color" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="Black">
                        @error('color')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- License Plate --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">License Plate *</label>
                        <input wire:model="license_plate" type="text"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="ABC-1234">
                        @error('license_plate')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Seating Capacity --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Seating Capacity *</label>
                        <input wire:model="seating_capacity" type="number"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="5">
                        @error('seating_capacity')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Mileage --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Mileage *</label>
                        <input wire:model="mileage" type="number" step="0.01"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="50000">
                        @error('mileage')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Daily Rate --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Daily Rate *</label>
                        <input wire:model="daily_rate" type="number" step="0.01"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="50.00">
                        @error('daily_rate')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Weekly Rate --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Weekly Rate</label>
                        <input wire:model="weekly_rate" type="number" step="0.01"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="300.00">
                        @error('weekly_rate')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Monthly Rate --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Monthly Rate</label>
                        <input wire:model="monthly_rate" type="number" step="0.01"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="1000.00">
                        @error('monthly_rate')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Security Deposit --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Security Deposit</label>
                        <input wire:model="security_deposit" type="number" step="0.01"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="500.00">
                        @error('security_deposit')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Delivery Fee --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Delivery Fee</label>
                        <input wire:model="delivery_fee" type="number" step="0.01"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="25.00">
                        @error('delivery_fee')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Status *</label>
                        <select wire:model="status"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                            {{-- This loop iterates over the 'statuses' array passed from the component's render method --}}
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Transmission Type (Missing in original view, adding for completeness) --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Transmission Type *</label>
                        <select wire:model="transmission_type"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                            {{-- Assuming Vehicle model has constants like TRANSMISSION_AUTOMATIC and TRANSMISSION_MANUAL --}}
                            <option value="{{ \App\Models\Vehicle::TRANSMISSION_AUTOMATIC }}">Automatic</option>
                            <option value="{{ \App\Models\Vehicle::TRANSMISSION_MANUAL }}">Manual</option>
                        </select>
                        @error('transmission_type')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Instant Booking --}}
                    <div class="flex items-center pt-8">
                        <label class="flex items-center cursor-pointer">
                            <input wire:model="instant_booking" type="checkbox"
                                class="w-4 h-4 text-emerald-600 bg-zinc-800 border-zinc-200 rounded focus:ring-zinc-600">
                            <span class="ml-2 text-sm font-medium text-zinc-300">Instant Booking</span>
                        </label>
                    </div>

                    {{-- Delivery Available --}}
                    <div class="flex items-center pt-8">
                        <label class="flex items-center cursor-pointer">
                            <input wire:model="delivery_available" type="checkbox"
                                class="w-4 h-4 text-emerald-600 bg-zinc-800 border-zinc-200 rounded focus:ring-zinc-600">
                            <span class="ml-2 text-sm font-medium text-zinc-300">Delivery Available</span>
                        </label>
                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Description *</label>
                        <textarea wire:model="description" rows="4"
                            class="w-full border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600"
                            placeholder="Enter vehicle description"></textarea>
                        @error('description')
                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Avatar Upload & Existing Avatar Display --}}
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-zinc-300 mb-2">Vehicle Image</label>
                        <div class="flex items-start gap-4">
                            {{-- Display Existing Avatar if no new file is uploaded --}}
                            @if ($existingAvatar && !$avatar)
                                <div class="relative">
                                    <img src="{{ $existingAvatar }}"
                                        class="w-32 h-32 object-cover rounded-lg border border-zinc-200">
                                    <button type="button" wire:click="removeAvatar"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="18" y1="6" x2="6" y2="18">
                                            </line>
                                            <line x1="6" y1="6" x2="18" y2="18">
                                            </line>
                                        </svg>
                                    </button>
                                </div>
                                {{-- Display Temporary New Avatar --}}
                            @elseif ($avatar)
                                <div class="relative">
                                    <img src="{{ $avatar->temporaryUrl() }}"
                                        class="w-32 h-32 object-cover rounded-lg border border-zinc-200">
                                    <button type="button" wire:click="removeAvatar"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="18" y1="6" x2="6" y2="18">
                                            </line>
                                            <line x1="6" y1="6" x2="18" y2="18">
                                            </line>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            <div class="flex-1">
                                <input wire:model="avatar" type="file" accept="image/*"
                                    class="w-full bg-zinc-800/50 border border-zinc-200 rounded-lg px-4 py-2.5 text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-700 file:text-zinc-500 hover:file:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                                <p class="mt-2 text-xs text-zinc-500">Maximum file size: 2MB. Supported formats: JPG,
                                    PNG, GIF</p>
                                @error('avatar')
                                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.pm.vehicle-list') }}" wire:navigate
                        class="px-6 py-2.5 bg-zinc-700 hover:bg-zinc-600 text-zinc-500 rounded-lg transition-colors duration-200">
                        Cancel
                    </a>
                    {{-- UPDATED: Button text changed from 'Create Vehicle' to 'Update Vehicle' --}}
                    <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200">
                        Update Vehicle
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
