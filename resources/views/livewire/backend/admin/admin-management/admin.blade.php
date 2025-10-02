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
                    <x-button href="#" icon="trash-2" type='secondary' permission="admin-trash">
                        {{ __('Trash') }}
                    </x-button>
                    <button wire:click="openCreateModal" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        {{ __('Add') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Search Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-zinc-200 text-right w-[20%] mb-6">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Search..."
                    class="w-full bg-transparent border-0 pl-10 pr-4 py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none focus:ring-0"
                >
            </div>
        </div>

        {{-- Table Section --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-600/50 border-b border-zinc-700">
                        <tr>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">Created At</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">Created By</th>
                            <th class="px-6 text-white py-4 text-right text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-700/50">
                        @forelse ($admins as $admin)
                            <tr class="bg-zinc-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-100 font-semibold">
                                            {{ $admin->initials() }}
                                        </div>
                                        <span class="text-accent font-medium">{{ $admin->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">{{ $admin->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-accent text-sm">{{ $admin->created_at_formatted }}</span>
                                        <span class="text-zinc-500 text-xs">{{ $admin->created_at_human }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">
                                    {{ $admin->createdBy?->name ?? 'System' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            wire:click="openEditModal({{ $admin->id }})"
                                            class="p-2 text-zinc-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-lg transition-all duration-200"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            wire:click="openDeleteModal({{ $admin->id }})"
                                            class="p-2 text-zinc-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-all duration-200"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-zinc-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
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

    {{-- Create/Edit Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-zinc-500/10  backdrop-blur-sm" wire:keydown.escape="closeModal">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                {{-- Modal --}}
                <div class="inline-block align-bottom bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-zinc-800" wire:click.away="closeModal">
                    <form wire:submit="save">
                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-zinc-800">
                            <h3 class="text-lg font-semibold text-zinc-100">
                                {{ $editMode ? __('Edit Admin') : __('Create New Admin') }}
                            </h3>
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-4 space-y-4">
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Name *</label>
                                <input 
                                    wire:model="name"
                                    type="text" 
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter admin name"
                                >
                                @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Email *</label>
                                <input 
                                    wire:model="email"
                                    type="email" 
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter email address"
                                >
                                @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">
                                    Password {{ $editMode ? '(Leave blank to keep current)' : '*' }}
                                </label>
                                <input 
                                    wire:model="password"
                                    type="password" 
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter password"
                                >
                                @error('password') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-300 mb-2">Confirm Password</label>
                                <input 
                                    wire:model="password_confirmation"
                                    type="password" 
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Confirm password"
                                >
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
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Backdrop --}}
                {{-- <div class="fixed inset-0 transition-opacity bg-zinc-950/80 backdrop-blur-sm" wire:click="closeDeleteModal"></div> --}}

                {{-- Modal --}}
                <div class="inline-block align-bottom bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-zinc-800">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b border-zinc-800">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Confirm Delete') }}</h3>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-4">
                        <p class="text-zinc-300">Are you sure you want to delete this admin? This action cannot be undone.</p>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button 
                            wire:click="closeDeleteModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button 
                            wire:click="delete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>