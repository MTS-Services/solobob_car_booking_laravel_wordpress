<div>
    <section>
        {{-- Header --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-accent">{{ __('Vehicle Details') }}</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.pm.vehicle-list') }}" wire:navigate
                        class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-600 hover:bg-zinc-700 text-zinc-100 rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        {{ __('Back to List') }}
                    </a>
                    @if (!$vehicle->trashed())
                        <a href="{{ route('admin.pm.vehicle-edit', $vehicle->id) }}" wire:navigate
                            class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
            {{-- Avatar --}}
            @if ($vehicle->avatar)
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('storage/' . $vehicle->avatar) }}" alt="{{ $vehicle->title }}" class="w-96 h-64 object-cover rounded-lg border-2 border-zinc-700 shadow-lg">
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Title</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->title }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Category</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->category->name ?? 'N/A' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Owner</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->owner->name ?? 'N/A' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Slug</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->slug }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Year</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->year }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Color</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->color }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">License Plate</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->license_plate }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Seating Capacity</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->seating_capacity }} {{ $vehicle->seating_capacity == 1 ? 'Person' : 'People' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Mileage</p>
                    <p class="text-zinc-500 font-medium">{{ number_format($vehicle->mileage) }} km</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Daily Rate</p>
                    <p class="text-zinc-500 font-medium">${{ number_format($vehicle->daily_rate, 2) }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Weekly Rate</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->weekly_rate ? '$' . number_format($vehicle->weekly_rate, 2) : 'N/A' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Monthly Rate</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->monthly_rate ? '$' . number_format($vehicle->monthly_rate, 2) : 'N/A' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Security Deposit</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->security_deposit ? '$' . number_format($vehicle->security_deposit, 2) : 'N/A' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Delivery Fee</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->delivery_fee ? '$' . number_format($vehicle->delivery_fee, 2) : 'N/A' }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p c6ass="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $vehicle->status_color }}">
                        {{ $vehicle->status_label }}
                    </span>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Instant Booking</p>
                    <p class="text-zinc-500 font-medium">
                        @if ($vehicle->instant_booking)
                            <span class="text-emerald-400">✓ Yes</span>
                        @else
                            <span class="text-red-400">✗ No</span>
                        @endif
                    </p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Delivery Available</p>
                    <p class="text-zinc-500 font-medium">
                        @if ($vehicle->delivery_available)
                            <span class="text-emerald-400">✓ Yes</span>
                        @else
                            <span class="text-red-400">✗ No</span>
                        @endif
                    </p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Created At</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->created_at->format('M d, Y H:i A') }}</p>
                </div>

                <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Created By</p>
                    <p class="text-zinc-500 font-medium">{{ $vehicle->createdBy->name ?? 'N/A' }}</p>
                </div>

                @if ($vehicle->updated_at && $vehicle->updated_at != $vehicle->created_at)
                    <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                        <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Updated At</p>
                        <p class="text-zinc-500 font-medium">{{ $vehicle->updated_at->format('M d, Y H:i A') }}</p>
                    </div>

                    <div class="bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                        <p class="text-xs text-zinc-600 uppercase tracking-wider mb-1">Updated By</p>
                        <p class="text-zinc-500 font-medium">{{ $vehicle->updatedBy->name ?? 'N/A' }}</p>
                    </div>
                @endif

                @if ($vehicle->deleted_at)
                    <div class="bg-red-900/20 rounded-lg p-4 border border-red-700">
                        <p class="text-xs text-red-500 uppercase tracking-wider mb-1">Deleted At</p>
                        <p class="text-red-200 font-medium">{{ $vehicle->deleted_at->format('M d, Y H:i A') }}</p>
                    </div>

                    <div class="bg-red-900/20 rounded-lg p-4 border border-red-700">
                        <p class="text-xs text-red-500 uppercase tracking-wider mb-1">Deleted By</p>
                        <p class="text-red-200 font-medium">{{ $vehicle->deletedBy->name ?? 'N/A' }}</p>
                    </div>
                @endif

                <div class="md:col-span-2 bg-zinc-300/50 rounded-lg p-4 border border-zinc-200">
                    <p class="text-xs text-zinc-500 uppercase 6racking-wider mb-2">Description</p>
                    <p class="text-zinc-200 leading-re5axed">{{ $vehicle->description }}</p>
                </div>
            </div>
        </div>
    </section>
</div>
