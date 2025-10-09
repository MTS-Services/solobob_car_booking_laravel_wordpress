<div>
    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <section>
        {{-- Header Section --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-accent">
                    {{ $viewingTrash ? __('Trashed Vehicles') : __('Vehicle List') }}
                </h2>
                <div class="flex items-center gap-2">
                    @if (!$viewingTrash)
                        <button wire:click="openTrashModal"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-600 hover:bg-zinc-700 text-zinc-100 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                </path>
                            </svg>
                            {{ __('Trash') }}
                        </button>
                        <button wire:click="openCreateModal"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-500 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            {{ __('Add') }}
                        </button>
                    @else
                        <button wire:click="closeTrashModal"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-600 hover:bg-zinc-700 text-zinc-100 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            {{ __('Close Trash') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="glass-card rounded-2xl">
            <div>
                <table class="w-full">
                    <thead class="bg-zinc-600/50 border-b border-zinc-700">
                        <tr>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                License Plate
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Created At
                            </th>
                            @if ($viewingTrash)
                                <th
                                    class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                    Deleted At
                                </th>
                            @endif
                            <th class="px-6 text-white py-4 text-right text-xs font-semibold uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-700/50">
                        @forelse ($vehicles as $vehicle)
                            <tr class="bg-zinc-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-accent">
                                    {{ $vehicle->category->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-accent">
                                    {{ $vehicle->title }}
                                </td>
                                <td class="px-6 py-4 text-accent">
                                    {{ $vehicle->license_plate }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'Available' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                            'Rented' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                            'Under Maintenance' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                            'Inactive' => 'bg-zinc-500/20 text-zinc-400 border-zinc-500/30',
                                        ];
                                        $colorClass =
                                            $statusColors[$vehicle->status_label] ??
                                            'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                        {{ $vehicle->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-accent text-sm">
                                    {{ $vehicle->created_at->format('M d, Y') }}
                                </td>
                                @if ($viewingTrash)
                                    <td class="px-6 py-4 text-red-400 text-sm">
                                        {{ $vehicle->deleted_at->format('M d, Y') }}
                                    </td>
                                @endif
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end">
                                        @if ($viewingTrash)
                                            {{-- Trash Actions --}}
                                            <div class="flex items-center gap-2">
                                                <button wire:click="openRestoreModal({{ $vehicle->id }})"
                                                    class="p-2 text-emerald-400 hover:text-emerald-300 rounded-lg transition-all duration-200"
                                                    title="Restore">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <polyline points="23 4 23 10 17 10"></polyline>
                                                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="openPermanentDeleteModal({{ $vehicle->id }})"
                                                    class="p-2 text-red-400 hover:text-red-300 rounded-lg transition-all duration-200"
                                                    title="Delete Permanently">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            {{-- Regular Actions --}}
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" @click.away="open = false"
                                                    class="p-2 text-zinc-400 hover:text-zinc-300 rounded-lg transition-all duration-200"
                                                    title="Actions">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-5 h-5 transition-transform duration-300 **hover:rotate-45**"
                                                        :class="{ 'rotate-45': open }" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" />

                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33h.09a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51h.09a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.09a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                                                    </svg>
                                                </button>

                                                <div x-show="open"
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="transform opacity-0 scale-95"
                                                    x-transition:enter-end="transform opacity-100 scale-100"
                                                    x-transition:leave="transition ease-in duration-75"
                                                    x-transition:leave-start="transform opacity-100 scale-100"
                                                    x-transition:leave-end="transform opacity-0 scale-95"
                                                    class="absolute right-0 mt-2 w-48 bg-zinc-100 border border-zinc-300 rounded-lg shadow-xl z-50"
                                                    style="display: none;">
                                                    <div class="py-1">
                                                        <button wire:click="openDetailsModal({{ $vehicle->id }})"
                                                            @click="open = false"
                                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-accent text-sm hover:bg-zinc-400 hover:text-white transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                                viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"></circle>
                                                                <line x1="12" y1="16" x2="12"
                                                                    y2="12"></line>
                                                                <line x1="12" y1="8" x2="12.01"
                                                                    y2="8"></line>
                                                            </svg>
                                                            Details
                                                        </button>
                                                        <button wire:click="openEditModal({{ $vehicle->id }})"
                                                            @click="open = false"
                                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-accent hover:bg-zinc-400 hover:text-white transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                                viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                </path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                </path>
                                                            </svg>
                                                            Edit
                                                        </button>
                                                        <button wire:click="openDeleteModal({{ $vehicle->id }})"
                                                            @click="open = false"
                                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-zinc-400 hover:text-red-300 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                                viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $viewingTrash ? 7 : 6 }}" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-zinc-600"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12">
                                            </line>
                                            <line x1="12" y1="16" x2="12.01" y2="16">
                                            </line>
                                        </svg>
                                        <p class="text-zinc-500 text-lg">
                                            {{ $viewingTrash ? 'No trashed vehicles found' : 'No vehicles found' }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($vehicles->hasPages())
                <div class="px-6 py-4 border-t border-zinc-700/50">
                    {{ $vehicles->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- Details Modal --}}
    @if ($showDetailsModal && $detailsAdmin)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeDetailsModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                    wire:click="closeDetailsModal"></div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-4xl w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Vehicle Details') }}</h3>
                        <button wire:click="closeDetailsModal"
                            class="text-zinc-400 hover:text-zinc-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Title</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->title }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Category</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->category->name ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Owner</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->owner->name ?? 'N/A' }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Year</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->year }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Color</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->color }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">License Plate</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->license_plate }}</p>
                            </div>

                          

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Seating Capacity</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->seating_capacity }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Mileage</p>
                                <p class="text-zinc-200 font-medium">{{ number_format($detailsAdmin->mileage) }} km
                                </p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Daily Rate</p>
                                <p class="text-zinc-200 font-medium">
                                    ${{ number_format($detailsAdmin->daily_rate, 2) }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                                {{-- @php
                                    $statusColors = [
                                        \App\Models\Vehicle::STATUS_AVAILABLE =>
                                            'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                        \App\Models\Vehicle::STATUS_RENTED =>
                                            'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                        \App\Models\Vehicle::STATUS_MAINTENANCE =>
                                            'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                        \App\Models\Vehicle::STATUS_INACTIVE =>
                                            'bg-zinc-500/20 text-zinc-400 border-zinc-500/30',
                                    ];
                                    $colorClass =
                                        $statusColors[$detailsAdmin->status] ??
                                        'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                @endphp --}}
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                    {{ $detailsAdmin->status_label }}
                                </span>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created At</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsAdmin->created_at->format('M d, Y H:i') }}</p>
                            </div>

                            @if ($detailsAdmin->deleted_at)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted At</p>
                                    <p class="text-zinc-200 font-medium">
                                        {{ $detailsAdmin->deleted_at->format('M d, Y H:i') }}</p>
                                </div>
                            @endif

                            <div class="md:col-span-2 bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Description</p>
                                <p class="text-zinc-200">{{ $detailsAdmin->description }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closeDetailsModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity" wire:click="closeModal">
                </div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-6xl w-full border border-zinc-800 max-h-[90vh] overflow-y-auto">
                    <form wire:submit="save">
                        <div
                            class="px-6 py-4 border-b border-zinc-800 justify-between flex items-center sticky top-0 bg-zinc-900 z-10">
                            <h3 class="text-lg font-semibold text-zinc-100">
                                {{ $editMode ? __('Edit Vehicle') : __('Create New Vehicle') }}
                            </h3>
                            <button type="button" wire:click="closeModal"
                                class="text-zinc-400 hover:text-zinc-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="px-6 py-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Owner --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Owner *</label>
                                    <select wire:model="owner_id"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
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
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Title --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Title *</label>
                                    <input wire:model="title" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter vehicle title">
                                    @error('title')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Slug --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Slug *</label>
                                    <input wire:model="slug" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="vehicle-slug">
                                    @error('slug')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Year --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Year *</label>
                                    <input wire:model="year" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="2024">
                                    @error('year')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Color --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Color *</label>
                                    <input wire:model="color" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Black">
                                    @error('color')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- License Plate --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">License Plate *</label>
                                    <input wire:model="license_plate" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="ABC-1234">
                                    @error('license_plate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                

                                {{-- Seating Capacity --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Seating Capacity
                                        *</label>
                                    <input wire:model="seating_capacity" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="5">
                                    @error('seating_capacity')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Mileage --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Mileage *</label>
                                    <input wire:model="mileage" type="number" step="0.01"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="50000">
                                    @error('mileage')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Daily Rate --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Daily Rate *</label>
                                    <input wire:model="daily_rate" type="number" step="0.01"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="50.00">
                                    @error('daily_rate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Weekly Rate --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Weekly Rate</label>
                                    <input wire:model="weekly_rate" type="number" step="0.01"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="300.00">
                                    @error('weekly_rate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Monthly Rate --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Monthly Rate</label>
                                    <input wire:model="monthly_rate" type="number" step="0.01"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="1000.00">
                                    @error('monthly_rate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Security Deposit --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Security Deposit
                                        *</label>
                                    <input wire:model="security_deposit" type="number" step="0.01"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="500.00">
                                    @error('security_deposit')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Minimum Rental Days --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Min Rental Days
                                        *</label>
                                    <input wire:model="minimum_rental_days" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="1">
                                    @error('minimum_rental_days')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                               

                                {{-- Delivery Fee --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Delivery Fee</label>
                                    <input wire:model="delivery_fee" type="number" step="0.01"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="25.00">
                                    @error('delivery_fee')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Status *</label>
                                    <select wire:model="status"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
                                        @foreach ($statuses as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Instant Booking --}}
                                <div class="flex items-center">
                                    <label class="flex items-center cursor-pointer">
                                        <input wire:model="instant_booking" type="checkbox"
                                            class="w-4 h-4 text-zinc-600 bg-zinc-800 border-zinc-700 rounded focus:ring-zinc-600">
                                        <span class="ml-2 text-sm font-medium text-zinc-300">Instant Booking</span>
                                    </label>
                                </div>

                                {{-- Delivery Available --}}
                                <div class="flex items-center">
                                    <label class="flex items-center cursor-pointer">
                                        <input wire:model="delivery_available" type="checkbox"
                                            class="w-4 h-4 text-zinc-600 bg-zinc-800 border-zinc-700 rounded focus:ring-zinc-600">
                                        <span class="ml-2 text-sm font-medium text-zinc-300">Delivery Available</span>
                                    </label>
                                </div>

                                {{-- Description --}}
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Description *</label>
                                    <textarea wire:model="description" rows="4"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter vehicle description"></textarea>
                                    @error('description')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Avatar Upload --}}
                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Vehicle Image</label>
                                    <div class="flex items-start gap-4">
                                        @if ($avatar)
                                            <div class="relative">
                                                <img src="{{ $avatar->temporaryUrl() }}"
                                                    class="w-32 h-32 object-cover rounded-lg border border-zinc-700">
                                                <button type="button" wire:click="removeAvatar"
                                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                        @elseif ($existingAvatar)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $existingAvatar) }}"
                                                    class="w-32 h-32 object-cover rounded-lg border border-zinc-700">
                                                <button type="button" wire:click="removeAvatar"
                                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2">
                                                        <line x1="18" y1="6" x2="6"
                                                            y2="18"></line>
                                                        <line x1="6" y1="6" x2="18"
                                                            y2="18"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input wire:model="avatar" type="file" accept="image/*"
                                                class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-700 file:text-zinc-100 hover:file:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
                                            <p class="mt-2 text-xs text-zinc-500">Maximum file size: 2MB. Supported
                                                formats: JPG, PNG, GIF</p>
                                            @error('avatar')
                                                <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3 sticky bottom-0 bg-zinc-900">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200">
                                {{ $editMode ? 'Update Vehicle' : 'Create Vehicle' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeDeleteModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                    wire:click="closeDeleteModal"></div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Delete Vehicle') }}</h3>
                    </div>

                    <div class="px-6 py-6">
                        <p class="text-zinc-300">Are you sure you want to delete this vehicle? This action cann't be
                            undone.</p>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closeDeleteModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Restore Confirmation Modal --}}
    @if ($showRestoreModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeRestoreModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                    wire:click="closeRestoreModal"></div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Restore Vehicle') }}</h3>
                    </div>

                    <div class="px-6 py-6">
                        <p class="text-zinc-300">Are you sure you want to restore this vehicle?</p>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closeRestoreModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button wire:click="restore"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors duration-200">
                            Restore
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Permanent Delete Confirmation Modal --}}
    @if ($showPermanentDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closePermanentDeleteModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                    wire:click="closePermanentDeleteModal"></div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800">
                        <h3 class="text-lg font-semibold text-red-400">{{ __('Permanent Delete') }}</h3>
                    </div>

                    <div class="px-6 py-6">
                        <p class="text-zinc-300 mb-2">Are you sure you want to permanently delete this vehicle?</p>
                        <p class="text-red-400 text-sm font-medium">This action cannot be undone!</p>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closePermanentDeleteModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button wire:click="permanentDelete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                            Delete Permanently
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
