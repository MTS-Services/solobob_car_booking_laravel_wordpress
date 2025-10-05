<div>
    <section>
        {{-- Header Section --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-accent">{{ __('User Trash ') }}</h2>
                <div class="flex items-center gap-2">
                    <x-button href="{{ route('admin.users') }}" icon="user" type='secondary' permission="user-trash"
                        class="text-white">
                        {{ __('Users') }}
                    </x-button>
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
                        @forelse ($users as $user)
                            <tr class="bg-zinc-50 transition-colors duration-150 ">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-zinc-300">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-100 font-semibold">
                                                {{ $user->initials() }}
                                            </div>
                                        @endif
                                        <span class="text-accent font-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-emerald-500/20 text-emerald-400 border-emerald-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Verified
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border bg-amber-500/20 text-amber-400 border-amber-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12">
                                                </line>
                                                <line x1="12" y1="16" x2="12.01" y2="16">
                                                </line>
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
                                            $statusColors[$user->status] ??
                                            'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                        {{ $user->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-accent text-sm">{{ $user->created_at_formatted }}</span>
                                        <span class="text-zinc-500 text-xs">{{ $user->created_at_human }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">
                                    {{ $user->createdBy?->name ?? 'System' }}
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

                                                    <button wire:click="restore({{ $user->id }})"
                                                        @click="open = false"
                                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-accent hover:bg-zinc-400 hover:text-white transition-colors">
                                                        <?xml version="1.0"?><svg class="w-4 h-4"
                                                            viewBox="0 0 48 48" width="48"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0 0h48v48h-48z" fill="none" />
                                                            <path
                                                                d="M25.99 6c-9.95 0-17.99 8.06-17.99 18h-6l7.79 7.79.14.29 8.07-8.08h-6c0-7.73 6.27-14 14-14s14 6.27 14 14-6.27 14-14 14c-3.87 0-7.36-1.58-9.89-4.11l-2.83 2.83c3.25 3.26 7.74 5.28 12.71 5.28 9.95 0 18.01-8.06 18.01-18s-8.06-18-18.01-18zm-1.99 10v10l8.56 5.08 1.44-2.43-7-4.15v-8.5h-3z" />
                                                        </svg>
                                                        Restore
                                                    </button>

                                                    {{-- <button wire:click="permanentDelete({{ $user->id }})"
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
                                                        Permanent Delete
                                                    </button> --}}
                                                    <button wire:click.prevent="openDeleteModal({{ $user->id }})"
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
                                                        Permanent Delete
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
                                        <p class="text-zinc-500 text-lg">No users found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- @if ($users->hasPages())
                <div class="px-6 py-4 border-t border-zinc-700/50">
                    {{ $users->links() }}
                </div>
            @endif --}}

        </div>
    </section>
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
                        <p class="text-zinc-300">Are you sure you want to delete this user? This action will soft
                            delete the record.</p>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closeDeleteModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button wire:click="permanentDelete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200">
                            Permanent Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
