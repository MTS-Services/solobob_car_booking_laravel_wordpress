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
                <h2 class="text-xl font-bold text-accent">{{ __('Vehicle List') }}</h2>
                <div class="flex items-center gap-2">
                    <x-button href="#" icon="trash-2" type='secondary' permission="Vehicle-trash" class="text-white">
                        {{ __('Trash') }}
                    </x-button>
                    <button wire:click="openCreateModal"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-500 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        {{ __('Add') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Search Section --}}
        {{-- <div class="bg-white rounded-lg shadow-sm border border-zinc-200 text-right w-[20%] mb-6 relative">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>

                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..."
                    class="w-full bg-transparent border-0 pl-10 pr-8 py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-0">

                @if ($search)
                    <button type="button" wire:click="$set('search', '')"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                @endif
            </div>
        </div> --}}

        {{-- Table Section --}}
        <div class="glass-card rounded-2xl">
            <div>
                <table class="w-full">
                    <thead class="bg-zinc-600/50 border-b border-zinc-700">
                        <tr>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Category Name
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Title
                            </th>

                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Approval Status
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Created At
                            </th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Created By
                            </th>
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
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                            'draft' => 'bg-zinc-500/20 text-zinc-400 border-zinc-500/30',
                                            'unavailable' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                        ];
                                        $status = strtolower($vehicle->status);
                                        $colorClass =
                                            $statusColors[$status] ?? 'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                        {{ $vehicle->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $approvalColors = [
                                            'approved' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                            'pending' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                            'rejected' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                        ];
                                        $approvalStatus = strtolower($vehicle->approval_status);
                                        $approvalColorClass =
                                            $approvalColors[$approvalStatus] ??
                                            'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $approvalColorClass }}">
                                        {{ $vehicle->approval_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end">
                                        {{-- Action Dropdown (Details, Edit, Delete) --}}
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" @click.away="open = false"
                                                class="p-2 text-zinc-400 hover:text-zinc-300 rounded-lg transition-all duration-200"
                                                title="Actions">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 transition-transform duration-300"
                                                    :class="{ 'rotate-45': open }" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33h.09a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51h.09a1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82v.09a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" />
                                                </svg>
                                            </button>

                                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
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
                                                        {{-- Icon for Details --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2">
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
                                                        {{-- Icon for Edit --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2">
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
                                                        {{-- Icon for Delete --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2">
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
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
                                        <p class="text-zinc-500 text-lg">No vehicles found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- @if ($admins->hasPages())
                <div class="px-6 py-4 border-t border-zinc-700/50">
                    {{ $admins->links() }}
                </div>
            @endif --}}
        </div>
    </section>

    {{-- Details Modal --}}
    @if ($showDetailsModal && $detailsAdmin)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeDetailsModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                    wire:click="closeDetailsModal"></div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-2xl w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Admin Details') }}</h3>
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
                        <div class="flex items-center gap-4">
                            @if ($detailsAdmin->avatar)
                                <img src="{{ Storage::url($detailsAdmin->avatar) }}" alt="{{ $detailsAdmin->name }}"
                                    class="w-20 h-20 rounded-full object-cover border-4 border-zinc-700">
                            @else
                                <div
                                    class="w-20 h-20 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-100 font-bold text-2xl">
                                    {{ $detailsAdmin->initials() }}
                                </div>
                            @endif
                            <div>
                                <h4 class="text-xl font-semibold text-zinc-100">{{ $detailsAdmin->name }}</h4>
                                <p class="text-zinc-400">{{ $detailsAdmin->email }}</p>
                                @if ($detailsAdmin->email_verified_at)
                                    <span
                                        class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/20 text-emerald-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Email Verified
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-amber-500/20 text-amber-400">
                                        Email Unverified
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">User ID</p>
                                <p class="text-zinc-200 font-medium">#{{ $detailsAdmin->id }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                                @php
                                    $statusColors = [
                                        \App\Models\User::STATUS_ACTIVE =>
                                            'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                        \App\Models\User::STATUS_SUSPENDED =>
                                            'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                        \App\Models\User::STATUS_DELETED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                    ];
                                    $colorClass =
                                        $statusColors[$detailsAdmin->status] ??
                                        'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                    {{ $detailsAdmin->status_label }}
                                </span>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Approved Status</p>
                                @php
                                    $statusColors = [
                                        \App\Models\User::STATUS_PENDING =>
                                            'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                        \App\Models\User::STATUS_APPROVED =>
                                            'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                        \App\Models\User::STATUS_REJECTED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                    ];
                                    $colorClass =
                                        $statusColors[$detailsAdmin->approved_status] ??
                                        'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                    {{ $detailsAdmin->status_label }}
                                </span>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created At</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->created_at_formatted }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsAdmin->created_at_human }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created By</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->createdBy?->name ?? 'System' }}
                                </p>
                                @if ($detailsAdmin->createdBy)
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsAdmin->createdBy->email }}</p>
                                @endif
                            </div>

                            @if ($detailsAdmin->updated_at && $detailsAdmin->updated_at != $detailsAdmin->created_at)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated At</p>
                                    <p class="text-zinc-200 font-medium">{{ $detailsAdmin->updated_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsAdmin->updated_at_human }}</p>
                                </div>

                                @if ($detailsAdmin->updatedBy)
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated By</p>
                                        <p class="text-zinc-200 font-medium">{{ $detailsAdmin->updatedBy->name }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $detailsAdmin->updatedBy->email }}
                                        </p>
                                    </div>
                                @endif
                            @endif

                            @if ($detailsAdmin->deleted_at)
                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted At</p>
                                    <p class="text-zinc-200 font-medium">{{ $detailsAdmin->deleted_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsAdmin->deleted_at_human }}</p>
                                </div>

                                @if ($detailsAdmin->deletedBy)
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted By</p>
                                        <p class="text-zinc-200 font-medium">{{ $detailsAdmin->deletedBy->name }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $detailsAdmin->deletedBy->email }}
                                        </p>
                                    </div>
                                @endif
                            @endif
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
                {{-- Backdrop --}}
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity" wire:click="closeModal">
                </div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-6xl w-full border border-zinc-800">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b border-zinc-800 justify-between flex items-center">
                            <h3 class="text-lg font-semibold text-zinc-100">
                                {{ $editMode ? __('Edit Admin') : __('Create New Product') }}
                            </h3>
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                                X
                            </button>
                        </div>

                        <div class="px-6 py-4 space-y-4">
                            {{-- New Grid Container for 2-column layout --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                                {{-- Category (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Category Name *</label>
                                    <select wire:model="category_id"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
                                        {{-- NOTE: You had a duplicate 'Select Category' option inside the foreach. I moved it outside. --}}
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Name (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Name *</label>
                                    <input wire:model="title" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter product name">
                                    @error('title')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Slug (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Slug *</label>
                                    <input wire:model="slug" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter slug address">
                                    @error('slug')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Year (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Year *</label>
                                    <input wire:model="year" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="year">
                                    @error('year')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Color (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Color *</label>
                                    <input wire:model="color" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="color">
                                    @error('color')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- License Plate (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">License Plate *</label>
                                    <input wire:model="license_plate" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="license_plate">
                                    @error('license_plate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- VIN Number (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Vin Number *</label>
                                    <input wire:model="vin" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="vin">
                                    @error('vin')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Seating Capacity (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Seating Capacity
                                        *</label>
                                    <input wire:model="seating_capacity" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="seating_capacity">
                                    @error('seating_capacity')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Mileage (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Mileage *</label>
                                    <input wire:model="mileage" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="mileage">
                                    @error('mileage')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Daily Rate (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Daily Rate *</label>
                                    <input wire:model="daily_rate" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="daily_rate">
                                    @error('daily_rate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Weekly Rate (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Weekly Rate *</label>
                                    <input wire:model="weekly_rate" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="weekly_rate">
                                    @error('weekly_rate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Monthly Rate (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Monthly Rate *</label>
                                    <input wire:model="monthly_rate" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="monthly_rate">
                                    @error('monthly_rate')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Security Deposit (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Security Deposit
                                        *</label>
                                    <input wire:model="security_deposit" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="security_deposit">
                                    @error('security_deposit')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Minimum Rental Days (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Minimum Rental Days
                                        *</label>
                                    <input wire:model="minimum_rental_days" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="minimum_rental_days">
                                    @error('minimum_rental_days')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Maximum Rental Days (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Maximum Rental Days
                                        *</label>
                                    <input wire:model="maximum_rental_days" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="maximum_rental_days">
                                    @error('maximum_rental_days')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Instant Booking (Column 2) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Instant Booking
                                        *</label>
                                    <input wire:model="instant_booking" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="instant_booking">
                                    @error('instant_booking')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Delivery Available (Column 1) --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Delivery Available
                                        *</label>
                                    <input wire:model="delivery_available" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="delivery_available">
                                    @error('delivery_available')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Description (Full Width in 3-column grid) --}}
                                <div class="md:col-span-3"> {{-- <--- CHANGED FROM md:col-span-2 to md:col-span-3 --}}
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Description *</label>
                                    <textarea wire:model="description" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="description"></textarea>
                                    @error('description')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- In your showDetailsModal content: vehicles.blade.php or a partial --}}

                                @if ($detailsAdmin)
                                    {{-- Status (Column 1) --}}
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                                        @php
                                            $statusColors = [
                                                \App\Models\Vehicle::STATUS_AVAILABLE =>
                                                    'bg-green-500/20 text-green-400 border-green-500/30',
                                                \App\Models\Vehicle::STATUS_RENTED =>
                                                    'bg-red-500/20 text-red-400 border-red-500/30',
                                                \App\Models\Vehicle::STATUS_MAINTENANCE =>
                                                    'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                                \App\Models\Vehicle::STATUS_INACTIVE =>
                                                    'bg-zinc-500/20 text-zinc-400 border-zinc-500/30',
                                            ];
                                            // Use null-safe operator or rely on the @if. Using array access after null check is fine.
                                            $colorClass =
                                                $statusColors[$detailsAdmin->status] ??
                                                'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                            {{ $detailsAdmin->status_label }}
                                        </span>
                                    </div>

                                    {{-- approval status (Column 2) --}}
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Approval Status
                                        </p>
                                        @php
                                            $approvalStatusColors = [
                                                // Renamed for clarity, assuming these are your approval status constants
                                                \App\Models\Vehicle::APPROVAL_PENDING =>
                                                    'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                                \App\Models\Vehicle::APPROVAL_APPROVED =>
                                                    'bg-green-500/20 text-green-400 border-green-500/30',
                                                \App\Models\Vehicle::APPROVAL_REJECTED =>
                                                    'bg-red-500/20 text-red-400 border-red-500/30',
                                            ];

                                            // NOTE: You must check $detailsAdmin->approval_status, NOT $detailsAdmin->status again.
                                            // Assuming your Vehicle model has an 'approval_status' column
                                            $colorClass =
                                                $approvalStatusColors[$detailsAdmin->approval_status] ??
                                                'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                            {{-- Assuming you have an approval_status_label accessor on the Vehicle model --}}
                                            {{ $detailsAdmin->approval_status_label ?? 'N/A' }}
                                        </span>
                                    </div>

                                    {{-- ... the rest of your details view content ... --}}
                                @endif

                            </div> {{-- End Grid Container --}}
                        </div>

                        <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                            
                            <button type="submit"
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-lg transition-colors duration-200">
                                {{ $editMode ? __('Update') : __('Create') }}
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
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-md w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Confirm Delete') }}</h3>
                    </div>

                    <div class="px-6 py-4">
                        <p class="text-zinc-300">Are you sure you want to delete this admin? This action will soft
                            delete the record.</p>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closeDeleteModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
