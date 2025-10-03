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
                <h2 class="text-xl font-bold text-accent">{{ __('Admin List') }}</h2>
                <div class="flex items-center gap-2">
                    <x-button href="#" icon="trash-2" type='secondary' permission="admin-trash" class="text-white">
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
        <div class="bg-white rounded-lg shadow-sm border border-zinc-200 text-right w-[20%] mb-6 relative">
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
        </div>

        {{-- Table Section --}}
        <div class="glass-card rounded-2xl">
            <div>
                <table class="w-full">
                    <thead class="bg-zinc-600/50 border-b border-zinc-700">
                        <tr>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Name</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Email Status</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Created At</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Created By</th>
                            <th class="px-6 text-white py-4 text-right text-xs font-semibold uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-700/50">
                        @forelse ($admins as $admin)
                            <tr class="bg-zinc-50 transition-colors duration-150 ">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($admin->avatar)
                                            <img src="{{ Storage::url($admin->avatar) }}" alt="{{ $admin->name }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-zinc-300">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-100 font-semibold">
                                                {{ $admin->initials() }}
                                            </div>
                                        @endif
                                        <span class="text-accent font-medium">{{ $admin->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">{{ $admin->email }}</td>
                                <td class="px-6 py-4">
                                    @if ($admin->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-emerald-500/20 text-emerald-400 border-emerald-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Verified
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-amber-500/20 text-amber-400 border-amber-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                            Unverified
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
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
                                            $statusColors[$admin->status] ??
                                            'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                        {{ $admin->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-accent text-sm">{{ $admin->created_at_formatted }}</span>
                                        <span class="text-zinc-500 text-xs">{{ $admin->created_at_human }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">
                                    {{ $admin->createdBy?->name ?? 'System' }}
                                </td>
                                <td class="px-6 py-4 ">
                                    <div class="flex items-center justify-end">
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
                                                    <button wire:click="openDetailsModal({{ $admin->id }})"
                                                        @click="open = false"
                                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-accent text-sm hover:bg-zinc-400 hover:text-white transition-colors">
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
                                                    <button wire:click="openEditModal({{ $admin->id }})"
                                                        @click="open = false"
                                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-accent hover:bg-zinc-400 hover:text-white transition-colors">
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
                                                    <button wire:click="openDeleteModal({{ $admin->id }})"
                                                        @click="open = false"
                                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-400 hover:bg-zinc-400 hover:text-red-300 transition-colors">
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
                                        <p class="text-zinc-500 text-lg">No admins found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($admins->hasPages())
                <div class="px-6 py-4 border-t border-zinc-700/50">
                    {{ $admins->links() }}
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
                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/20 text-emerald-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Email Verified
                                    </span>
                                @else
                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-amber-500/20 text-amber-400">
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
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity" wire:click="closeModal">
                </div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-zinc-800">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b border-zinc-800">
                            <h3 class="text-lg font-semibold text-zinc-100">
                                {{ $editMode ? __('Edit Admin') : __('Create New Admin') }}
                            </h3>
                        </div>

                        <div class="px-6 py-4 space-y-4">
                            {{-- Avatar Upload --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Profile Picture</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0">
                                        @if ($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" alt="Preview"
                                                class="w-20 h-20 rounded-full object-cover border-4 border-zinc-700">
                                        @elseif ($existingAvatar)
                                            <img src="{{ Storage::url($existingAvatar) }}" alt="Current avatar"
                                                class="w-20 h-20 rounded-full object-cover border-4 border-zinc-700">
                                        @else
                                            <div
                                                class="w-20 h-20 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-100 font-bold text-2xl border-4 border-zinc-600">
                                                {{ $name ? Str::of($name)->explode(' ')->take(2)->map(fn($word) => Str::substr($word, 0, 1))->implode('') : '?' }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <div class="flex items-center gap-2">
                                            <label
                                                class="cursor-pointer px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200 inline-flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="17 8 12 3 7 8"></polyline>
                                                    <line x1="12" y1="3" x2="12"
                                                        y2="15"></line>
                                                </svg>
                                                Choose Image
                                                <input type="file" wire:model="avatar" accept="image/*"
                                                    class="hidden">
                                            </label>
                                            @if ($avatar || $existingAvatar)
                                                <button type="button" wire:click="removeAvatar"
                                                    class="px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-colors duration-200">
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                        <p class="text-xs text-zinc-500 mt-2">PNG, JPG up to 2MB</p>
                                        @error('avatar')
                                            <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror

                                        <div wire:loading wire:target="avatar" class="mt-2">
                                            <div class="flex items-center gap-2 text-zinc-400 text-sm">
                                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Uploading...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Name *</label>
                                <input wire:model="name" type="text"
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter admin name">
                                @error('name')
                                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Email *</label>
                                <input wire:model="email" type="email"
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter email address">
                                @error('email')
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

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">
                                    Password {{ $editMode ? '(Leave blank to keep current)' : '*' }}
                                </label>
                                <input wire:model="password" type="password"
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter password">
                                @error('password')
                                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Confirm Password</label>
                                <input wire:model="password_confirmation" type="password"
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Confirm password">
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                                Cancel
                            </button>
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