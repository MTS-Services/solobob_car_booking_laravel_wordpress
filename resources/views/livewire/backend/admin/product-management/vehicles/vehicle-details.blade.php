<div>
    <section>
        {{-- Header --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-accent">{{ __('Vehicle Details') }}</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.pm.vehicle-list') }}" wire:navigate
                        class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-200 hover:bg-zinc-300 text-zinc-500 rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        {{ __('Back to List') }}
                    </a>
                    @if (!$vehicle->trashed())
                        <a href="{{ route('admin.pm.vehicle-edit', $vehicle->id) }}" wire:navigate
                            class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            {{ __('Edit') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Details Card --}}
        <div class="glass-card rounded-2xl p-6">
            {{-- Vehicle Images Section --}}
            @if ($vehicle->images->isNotEmpty())
                <div class="mb-8">
                    {{-- Main Selected Image --}}
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('storage/' . $selectedImage) }}" alt="{{ $vehicle->title }}"
                            class="w-full max-w-4xl h-96 object-cover rounded-2xl border-2 border-zinc-100 shadow-lg">
                    </div>

                    {{-- Thumbnail Gallery --}}
                    <div class="flex flex-wrap justify-center gap-3">
                        @foreach ($vehicle->images as $index => $image)
                            <div wire:click="selectImage('{{ $image->image }}')"
                                class="relative group cursor-pointer transition-all duration-200 {{ $selectedImage === $image->image ? 'ring-2 ring-amber-500' : '' }}">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $vehicle->title }}"
                                    class="w-24 h-24 object-cover rounded-lg border-2 {{ $selectedImage === $image->image ? 'border-amber-500' : 'border-zinc-100' }} hover:border-amber-400">

                                {{-- Primary Badge --}}
                                @if ($image->is_primary)
                                    <div
                                        class="absolute top-1 left-1 bg-emerald-600 text-white text-xs px-1.5 py-0.5 rounded">
                                        Primary
                                    </div>
                                @endif

                                {{-- Image Number --}}
                                <div
                                    class="absolute bottom-1 right-1 bg-black/60 text-white text-xs px-1.5 py-0.5 rounded">
                                    {{ $index + 1 }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Vehicle Information Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Title</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->title }}
                    </div>
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Slug</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->slug }}
                    </div>
                </div>

                {{-- Owner --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Owner</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->owner->name ?? 'N/A' }}
                    </div>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Category</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->category->name ?? 'N/A' }}
                    </div>
                </div>

                {{-- Year --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Year</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->year }}
                    </div>
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Color</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->color }}
                    </div>
                </div>

                {{-- License Plate --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">License Plate</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->license_plate }}
                    </div>
                </div>

                {{-- Seating Capacity --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Seating Capacity</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->seating_capacity }}
                        {{ $vehicle->seating_capacity == 1 ? 'Person' : 'People' }}
                    </div>
                </div>

                {{-- Mileage --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Mileage</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ number_format($vehicle->mileage) }} km
                    </div>
                </div>

                {{-- Weekly Rate --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Weekly Rate</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->weekly_rate ? '$' . number_format($vehicle->weekly_rate, 2) : 'N/A' }}
                    </div>
                </div>

                {{-- Monthly Rate --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Monthly Rate</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->monthly_rate ? '$' . number_format($vehicle->monthly_rate, 2) : 'N/A' }}
                    </div>
                </div>

                {{-- Security Deposit --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Security Deposit</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->security_deposit ? '$' . number_format($vehicle->security_deposit, 2) : 'N/A' }}
                    </div>
                </div>

                {{-- Delivery Fee --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Delivery Fee</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->delivery_fee ? '$' . number_format($vehicle->delivery_fee, 2) : 'N/A' }}
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Status</label>
                    <div class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 bg-zinc-50">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border badge badge-soft {{ $vehicle->status_color }}">
                            {{ $vehicle->status_label }}
                        </span>
                    </div>
                </div>

                {{-- Transmission Type --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Transmission Type</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                        {{ $vehicle->transmission_type }}
                    </div>
                </div>

                {{-- Instant Booking --}}
                <div class="flex items-center pt-8">
                    <label class="flex items-center cursor-not-allowed">
                        <input type="checkbox" disabled {{ $vehicle->instant_booking ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 bg-zinc-800 border-zinc-100 rounded focus:ring-zinc-600">
                        <span class="ml-2 text-sm font-medium text-zinc-500">Instant Booking</span>
                    </label>
                </div>

                {{-- Delivery Available --}}
                <div class="flex items-center pt-8">
                    <label class="flex items-center cursor-not-allowed">
                        <input type="checkbox" disabled {{ $vehicle->delivery_available ? 'checked' : '' }}
                            class="w-4 h-4 text-emerald-600 bg-zinc-800 border-zinc-100 rounded focus:ring-zinc-600">
                        <span class="ml-2 text-sm font-medium text-zinc-500">Delivery Available</span>
                    </label>
                </div>

                {{-- Description --}}
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Description</label>
                    <div
                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50 min-h-[100px]">
                        {{ $vehicle->description }}
                    </div>
                </div>

                {{-- Audit Information --}}
                <div class="md:col-span-3">
                    <div class="border-t border-zinc-100 pt-6 mt-6">
                        <h3 class="text-lg font-semibold text-zinc-600 mb-4">Audit Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Created At --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-600 mb-2">Created At</label>
                                <div
                                    class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                                    {{ $vehicle->created_at->format('M d, Y H:i A') }}
                                </div>
                            </div>

                            {{-- Created By --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-600 mb-2">Created By</label>
                                <div
                                    class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                                    {{ $vehicle->createdBy->name ?? 'N/A' }}
                                </div>
                            </div>

                            @if ($vehicle->updated_at && $vehicle->updated_at != $vehicle->created_at)
                                {{-- Updated At --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-600 mb-2">Updated At</label>
                                    <div
                                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                                        {{ $vehicle->updated_at->format('M d, Y H:i A') }}
                                    </div>
                                </div>

                                {{-- Updated By --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-600 mb-2">Updated By</label>
                                    <div
                                        class="w-full border border-zinc-100 rounded-lg px-4 py-2.5 text-zinc-500 bg-zinc-50">
                                        {{ $vehicle->updatedBy->name ?? 'N/A' }}
                                    </div>
                                </div>
                            @endif

                            @if ($vehicle->deleted_at)
                                {{-- Deleted At --}}
                                <div>
                                    <label class="block text-sm font-medium text-red-600 mb-2">Deleted At</label>
                                    <div
                                        class="w-full border border-red-200 rounded-lg px-4 py-2.5 text-red-500 bg-red-50">
                                        {{ $vehicle->deleted_at->format('M d, Y H:i A') }}
                                    </div>
                                </div>

                                {{-- Deleted By --}}
                                <div>
                                    <label class="block text-sm font-medium text-red-600 mb-2">Deleted By</label>
                                    <div
                                        class="w-full border border-red-200 rounded-lg px-4 py-2.5 text-red-500 bg-red-50">
                                        {{ $vehicle->deletedBy->name ?? 'N/A' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>