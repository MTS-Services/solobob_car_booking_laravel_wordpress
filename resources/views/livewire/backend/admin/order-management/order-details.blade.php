<div x-data="{ activeTab: 'overview' }">
    <section>
        {{-- Header --}}
        <div class="flex items-center justify-between glass-card rounded-2xl p-6 mb-6">
            <div>
                <h2 class="text-xl font-bold text-text-primary">{{ __('Order Details') }}</h2>
                <p class="text-sm text-zinc-500 mt-1">Reference: {{ $detailsOrder->booking_reference }}</p>
            </div>
           <div class="flex gap-2">
    @if ($detailsOrder->booking_status == 0)
        {{-- Accept Order Button --}}
        <button wire:click="acceptOrder" 
                wire:loading.attr="disabled" 
                wire:target="acceptOrder"
                class="relative px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
            
            {{-- Loader --}}
            <svg wire:loading wire:target="acceptOrder" class="animate-spin h-5 w-5 text-white" 
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>

            <span wire:loading.remove wire:target="acceptOrder">Accept Order</span>
        </button>

        {{-- Reject Order Button --}}
        <button wire:click="openRejectModal" 
                wire:loading.attr="disabled" 
                wire:target="openRejectModal"
                class="relative px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors flex items-center justify-center gap-2">
            
            {{-- Loader --}}
            <svg wire:loading wire:target="openRejectModal" class="animate-spin h-5 w-5 text-white" 
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>

            <span wire:loading.remove wire:target="openRejectModal">Reject Order</span>
        </button>
    @endif
</div>

        </div>

        {{-- Flash Messages --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-lg">
                <p class="text-emerald-400">{{ session('success') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                <p class="text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        @if ($detailsOrder->reason)
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-lg">
                <p class="text-red-400">
                    <span class="font-bold">Order Rejected:</span> {{ $detailsOrder->reason }}
                </p>
            </div>
        @endif

        {{-- Tabs Navigation --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="border-b border-zinc-700">
                <nav class="flex space-x-4 px-6" aria-label="Tabs">
                    <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Overview
                    </button>
                    <button @click="activeTab = 'billing'" 
                        :class="activeTab === 'billing' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Billing Information
                    </button>
                    <button @click="activeTab = 'addresses'" 
                        :class="activeTab === 'addresses' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Addresses
                    </button>
                    <button @click="activeTab = 'documents'" 
                        :class="activeTab === 'documents' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Documents
                    </button>
                    <button @click="activeTab = 'vehicle'" 
                        :class="activeTab === 'vehicle' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Vehicle Details
                    </button>
                    <button @click="activeTab = 'timeline'" 
                        :class="activeTab === 'timeline' ? 'border-emerald-500 text-emerald-400' : 'border-transparent text-zinc-400 hover:text-zinc-300'"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Timeline
                    </button>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div class="p-6">
                {{-- Overview Tab --}}
                <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Customer</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->user->name }}</p>
                            <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->user->email }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium badge badge-soft {{ $detailsOrder->booking_status_color }}">
                                {{ $detailsOrder->booking_status_label }}
                            </span>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Vehicle</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->vehicle?->title ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Rental Period</p>
                            <p class="text-zinc-100 font-medium capitalize">{{ $detailsOrder->relation?->rental_range ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Rental Duration</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->rental_duration_days ?? 0 }} Days</p>
                        </div>
                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Booking Reference</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->booking_reference ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Booking Date</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->humanReadableDateTime($detailsOrder->booking_date) }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Pickup Date</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->humanReadableDateTime($detailsOrder->pickup_date) }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Return Date</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->humanReadableDateTime($detailsOrder->return_date) }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Pickup Location</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->pickupLocation?->name ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Return Location</p>
                            <p class="text-zinc-100 font-medium">{{ $detailsOrder->return_location ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Financial Summary --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-zinc-100 mb-4">Financial Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Subtotal</p>
                                <p class="text-zinc-100 font-semibold text-xl">${{ number_format($detailsOrder->subtotal ?? 0, 2) }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Delivery Fee</p>
                                <p class="text-zinc-100 font-semibold text-xl">${{ number_format($detailsOrder->delivery_fee ?? 0, 2) }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Service Fee</p>
                                <p class="text-zinc-100 font-semibold text-xl">${{ number_format($detailsOrder->service_fee ?? 0, 2) }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Tax Amount</p>
                                <p class="text-zinc-100 font-semibold text-xl">${{ number_format($detailsOrder->tax_amount ?? 0, 2) }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Security Deposit</p>
                                <p class="text-zinc-100 font-semibold text-xl">${{ number_format($detailsOrder->security_deposit ?? 0, 2) }}</p>
                            </div>

                            <div class="bg-emerald-800/30 rounded-lg p-4 border border-emerald-700">
                                <p class="text-xs text-emerald-400 uppercase tracking-wider mb-1">Total Amount</p>
                                <p class="text-emerald-400 font-bold text-2xl">${{ number_format($detailsOrder->total_amount ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Information --}}
                    @if($detailsOrder->special_requests)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-zinc-100 mb-4">Special Requests</h3>
                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                            <p class="text-zinc-100">{{ $detailsOrder->special_requests }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Audit Information --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-zinc-100 mb-4">Audit Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($detailsOrder->auditor)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Audited By</p>
                                <p class="text-zinc-100 font-medium">{{ $detailsOrder->auditor->name }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->auditor->email }}</p>
                            </div>
                            @endif

                            @if($detailsOrder->createdBy)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Created By</p>
                                <p class="text-zinc-100 font-medium">{{ $detailsOrder->createdBy->name }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->createdBy->email }}</p>
                            </div>
                            @endif

                            @if($detailsOrder->updatedBy)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Last Updated By</p>
                                <p class="text-zinc-100 font-medium">{{ $detailsOrder->updatedBy->name }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->updated_at->format('M d, Y H:i A') }}</p>
                            </div>
                            @endif

                            @if($detailsOrder->deletedBy)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Deleted By</p>
                                <p class="text-zinc-100 font-medium">{{ $detailsOrder->deletedBy->name }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->deletedBy->email }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Billing Information Tab --}}
                <div x-show="activeTab === 'billing'" x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @if($detailsOrder->billingInformation)
                        @php $billing = $detailsOrder->billingInformation; @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">First Name</p>
                                <p class="text-zinc-100 font-medium">{{ $billing->first_name }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Last Name</p>
                                <p class="text-zinc-100 font-medium">{{ $billing->last_name }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Email</p>
                                <p class="text-zinc-100 font-medium">{{ $billing->email }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Date of Birth</p>
                                <p class="text-zinc-100 font-medium">{{ \Carbon\Carbon::parse($billing->date_of_birth)->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-zinc-400 text-center py-8">No billing information available</p>
                    @endif
                </div>

                {{-- Addresses Tab --}}
                <div x-show="activeTab === 'addresses'" x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Residential Address --}}
                        @if($detailsOrder->residentialAddress)
                            @php $residential = $detailsOrder->residentialAddress; @endphp
                            <div class="bg-zinc-800/50 rounded-lg p-6 border border-zinc-700">
                                <h4 class="text-lg font-semibold text-zinc-100 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    Residential Address
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Street Address</p>
                                        <p class="text-zinc-100">{{ $residential->address }}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">City</p>
                                            <p class="text-zinc-100">{{ $residential->city }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">State</p>
                                            <p class="text-zinc-100">{{ $residential->state }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Postal Code</p>
                                        <p class="text-zinc-100">{{ $residential->postal_code }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Parking Address --}}
                        @if($detailsOrder->parkingAddress)
                            @php $parking = $detailsOrder->parkingAddress; @endphp
                            <div class="bg-zinc-800/50 rounded-lg p-6 border border-zinc-700">
                                <h4 class="text-lg font-semibold text-zinc-100 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                    Parking Address
                                    @if($detailsOrder->relation?->same_as_residential)
                                        <span class="ml-2 text-xs bg-emerald-500/20 text-emerald-400 px-2 py-1 rounded">Same as Residential</span>
                                    @endif
                                </h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Street Address</p>
                                        <p class="text-zinc-100">{{ $parking->address }}</p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">City</p>
                                            <p class="text-zinc-100">{{ $parking->city }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">State</p>
                                            <p class="text-zinc-100">{{ $parking->state }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Postal Code</p>
                                        <p class="text-zinc-100">{{ $parking->postal_code }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if(!$detailsOrder->residentialAddress && !$detailsOrder->parkingAddress)
                        <p class="text-zinc-400 text-center py-8">No address information available</p>
                    @endif
                </div>

                {{-- Documents Tab --}}
                <div x-show="activeTab === 'documents'" x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @if($detailsOrder->userDocument)
                        @php $doc = $detailsOrder->userDocument; @endphp
                        <div class="space-y-6">
                            {{-- Document Status --}}
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Verification Status</p>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $doc->verification_status === \App\Models\UserDocuments::VERIFICATION_VERIFIED ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : '' }}
                                            {{ $doc->verification_status === \App\Models\UserDocuments::VERIFICATION_PENDING ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                            {{ $doc->verification_status === \App\Models\UserDocuments::VERIFICATION_REJECTED ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}">
                                            {{ ucfirst($doc->verification_status) }}
                                        </span>
                                    </div>
                                    @if($doc->verified_at)
                                    <div class="text-right">
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Verified At</p>
                                        <p class="text-zinc-100 text-sm">{{ \Carbon\Carbon::parse($doc->verified_at)->format('M d, Y H:i A') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- License Dates --}}
                            @if($doc->issue_date || $doc->expiry_date)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($doc->issue_date)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">License Issue Date</p>
                                    <p class="text-zinc-100 font-medium">{{ \Carbon\Carbon::parse($doc->issue_date)->format('M d, Y') }}</p>
                                </div>
                                @endif

                                @if($doc->expiry_date)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">License Expiry Date</p>
                                    <p class="text-zinc-100 font-medium">{{ \Carbon\Carbon::parse($doc->expiry_date)->format('M d, Y') }}</p>
                                </div>
                                @endif
                            </div>
                            @endif

                            {{-- Document Images --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- License --}}
                                @if($doc->licence)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-3">Driver's License</p>
                                    <div class="aspect-video bg-zinc-900 rounded-lg overflow-hidden mb-3">
                                        <img src="{{ Storage::url($doc->licence) }}" alt="License" class="w-full h-full object-contain">
                                    </div>
                                    <a href="{{ Storage::url($doc->licence) }}" target="_blank" 
                                        class="text-emerald-400 hover:text-emerald-300 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Full Size
                                    </a>
                                </div>
                                @endif

                                {{-- Selfie with License --}}
                                @if($doc->selfe_licence)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-3">Selfie with License</p>
                                    <div class="aspect-video bg-zinc-900 rounded-lg overflow-hidden mb-3">
                                        <img src="{{ Storage::url($doc->selfe_licence) }}" alt="Selfie" class="w-full h-full object-contain">
                                    </div>
                                    <a href="{{ Storage::url($doc->selfe_licence) }}" target="_blank" 
                                        class="text-emerald-400 hover:text-emerald-300 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Full Size
                                    </a>
                                </div>
                                @endif

                                {{-- Address Proof --}}
                                @if($doc->address_proof)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-3">Address Proof</p>
                                    <div class="aspect-video bg-zinc-900 rounded-lg overflow-hidden mb-3">
                                        @if(Str::endsWith($doc->address_proof, '.pdf'))
                                            <div class="flex items-center justify-center h-full">
                                                <svg class="w-16 h-16 text-zinc-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($doc->address_proof) }}" alt="Address Proof" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <a href="{{ Storage::url($doc->address_proof) }}" target="_blank" 
                                        class="text-emerald-400 hover:text-emerald-300 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                                @endif
                            </div>

                            {{-- Signature --}}
                            @if($detailsOrder->relation?->signature_path)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-3">Customer Signature</p>
                                <div class="bg-white rounded-lg p-4 max-w-md">
                                    <img src="{{ Storage::url($detailsOrder->relation->signature_path) }}" alt="Signature" class="w-full h-auto">
                                </div>
                                <div class="mt-3 flex items-center text-sm text-zinc-400">
                                    <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Terms accepted on {{ \Carbon\Carbon::parse($detailsOrder->relation->terms_accepted_at)->format('M d, Y H:i A') }}
                                </div>
                            </div>
                            @endif

                            {{-- SMS Alerts Preference --}}
                            @if($detailsOrder->relation)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 {{ $detailsOrder->relation->sms_alerts ? 'text-emerald-400' : 'text-zinc-500' }}" 
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-zinc-100 font-medium">SMS Alerts</p>
                                        <p class="text-xs text-zinc-400">{{ $detailsOrder->relation->sms_alerts ? 'Enabled' : 'Disabled' }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <p class="text-zinc-400 text-center py-8">No documents available</p>
                    @endif
                </div>

                {{-- Vehicle Details Tab --}}
                <div x-show="activeTab === 'vehicle'" x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @if($detailsOrder->vehicle)
                        @php $vehicle = $detailsOrder->vehicle; @endphp
                        <div class="space-y-6">
                            {{-- Vehicle Images --}}
                            @if($vehicle->images && $vehicle->images->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($vehicle->images->take(4) as $image)
                                <div class="aspect-video bg-zinc-900 rounded-lg overflow-hidden">
                                    <img src="{{ storage_url($image->image_path) }}" alt="Vehicle" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                            @endif

                            {{-- Vehicle Basic Info --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Vehicle Title</p>
                                    <p class="text-zinc-100 font-semibold text-lg">{{ $vehicle->title }}</p>
                                </div>

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Category</p>
                                    <p class="text-zinc-100 font-medium">{{ $vehicle->category?->name ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Year</p>
                                    <p class="text-zinc-100 font-medium">{{ $vehicle->year ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">VIN</p>
                                    <p class="text-zinc-100 font-medium font-mono">{{ $vehicle->vin ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">License Plate</p>
                                    <p class="text-zinc-100 font-medium font-mono">{{ $vehicle->license_plate ?? 'N/A' }}</p>
                                </div>

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Color</p>
                                    <p class="text-zinc-100 font-medium">{{ $vehicle->color ?? 'N/A' }}</p>
                                </div>
                            </div>

                            {{-- Pricing Info --}}
                            <div>
                                <h4 class="text-lg font-semibold text-zinc-100 mb-4">Pricing Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Weekly Rate</p>
                                        <p class="text-zinc-100 font-semibold text-xl">${{ number_format($vehicle->weekly_rate ?? 0, 2) }}</p>
                                    </div>

                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Monthly Rate</p>
                                        <p class="text-zinc-100 font-semibold text-xl">${{ number_format($vehicle->monthly_rate ?? 0, 2) }}</p>
                                    </div>

                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Weekly Security Deposit</p>
                                        <p class="text-zinc-100 font-semibold text-xl">${{ number_format($vehicle->security_deposit_weekly ?? 0, 2) }}</p>
                                    </div>

                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-400 uppercase tracking-wider mb-1">Monthly Security Deposit</p>
                                        <p class="text-zinc-100 font-semibold text-xl">${{ number_format($vehicle->security_deposit_monthly ?? 0, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Vehicle Description --}}
                            @if($vehicle->description)
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-400 uppercase tracking-wider mb-2">Description</p>
                                <p class="text-zinc-100 leading-relaxed">{{ $vehicle->description }}</p>
                            </div>
                            @endif
                        </div>
                    @else
                        <p class="text-zinc-400 text-center py-8">No vehicle information available</p>
                    @endif
                </div>

                {{-- Timeline Tab --}}
                <div x-show="activeTab === 'timeline'" x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    @if($detailsOrder->timeline && $detailsOrder->timeline->count() > 0)
                        <div class="relative">
                            {{-- Timeline Line --}}
                            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-zinc-700"></div>

                            {{-- Timeline Items --}}
                            <div class="space-y-6">
                                @foreach($detailsOrder->timeline->sortByDesc('created_at') as $timeline)
                                <div class="relative flex items-start">
                                    {{-- Timeline Dot --}}
                                    <div class="absolute left-8 -translate-x-1/2 mt-1.5">
                                        <div class="w-4 h-4 rounded-full border-4 border-zinc-900 
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_ACCEPTED ? 'bg-emerald-500' : '' }}
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_PENDING ? 'bg-amber-500' : '' }}
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_REJECTED ? 'bg-red-500' : '' }}
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_CANCELLED ? 'bg-red-500' : '' }}
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_DEPOSITED ? 'bg-blue-500' : '' }}
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_DELIVERED ? 'bg-purple-500' : '' }}
                                            {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_RETURNED ? 'bg-green-500' : '' }}">
                                        </div>
                                    </div>

                                    {{-- Timeline Content --}}
                                    <div class="ml-16 flex-1">
                                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                            <div class="flex items-start justify-between mb-2">
                                                <div>
                                                    <h5 class="text-zinc-100 font-semibold">
                                                        Status Changed to: 
                                                        <span class="capitalize">{{ $timeline->booking_status_label }}</span>
                                                    </h5>
                                                    <p class="text-xs text-zinc-400 mt-1">
                                                        {{ \Carbon\Carbon::parse($timeline->created_at)->format('M d, Y H:i A') }}
                                                        <span class="mx-1">•</span>
                                                        {{ \Carbon\Carbon::parse($timeline->created_at)->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_ACCEPTED ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : '' }}
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_PENDING ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : '' }}
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_REJECTED ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_CANCELLED ? 'bg-red-500/20 text-red-400 border border-red-500/30' : '' }}
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_DEPOSITED ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : '' }}
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_DELIVERED ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : '' }}
                                                    {{ $timeline->booking_status === \App\Models\Booking::BOOKING_STATUS_RETURNED ? 'bg-green-500/20 text-green-400 border border-green-500/30' : '' }}">
                                                    {{ $timeline->booking_status_label }}
                                                </span>
                                            </div>

                                            @if($timeline->createdBy)
                                            <div class="flex items-center mt-3 pt-3 border-t border-zinc-700">
                                                <svg class="w-4 h-4 text-zinc-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span class="text-sm text-zinc-300">{{ $timeline->createdBy->name }}</span>
                                                <span class="mx-2 text-zinc-600">•</span>
                                                <span class="text-xs text-zinc-400">{{ $timeline->createdBy->email }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-zinc-400 text-center py-8">No timeline information available</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Reject Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

                {{-- Modal --}}
                <div class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-zinc-800">
                    <form wire:submit="saveRejection">
                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-zinc-800">
                            <h3 class="text-lg font-semibold text-zinc-100">
                                Reject Order
                            </h3>
                            <p class="text-sm text-zinc-400 mt-1">Please provide a reason for rejecting this order</p>
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">
                                    Rejection Reason <span class="text-red-400">*</span>
                                </label>
                                <textarea 
                                    wire:model="reason"
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent resize-none"
                                    rows="5"
                                    placeholder="Enter the reason for rejection (minimum 10 characters)"
                                    required></textarea>
                                @error('reason')
                                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                            <button 
                                type="button" 
                                wire:click="closeModal"
                                class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>