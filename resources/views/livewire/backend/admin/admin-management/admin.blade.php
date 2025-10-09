<div class="mx-auto">
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

        {{-- Data Table --}}

        <x-backend.table :columns="$columns" :data="$admins" :actions="$actions" search-property="search"
            per-page-property="perPage" empty-message="No admins found." />

    </section>

   
    {{-- Force Delete Confirmation Modal --}}
    @if ($showForceDeleteModal)
        <div class="fixed inset-0 z-[60] overflow-y-auto" wire:keydown.escape="closeForceDeleteModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/80 backdrop-blur-sm transition-opacity"
                    wire:click="closeForceDeleteModal"></div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-md w-full border border-red-800">
                    <div class="px-6 py-4 border-b border-red-800 bg-red-900/20">
                        <h3 class="text-lg font-semibold text-red-400">{{ __('Permanent Delete Warning') }}</h3>
                    </div>

                    <div class="px-6 py-4">
                        <div class="flex items-start gap-3 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400 flex-shrink-0 mt-0.5"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path
                                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                                </path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            <div>
                                <p class="text-zinc-200 font-medium mb-2">This action cannot be undone!</p>
                                <p class="text-zinc-400 text-sm">
                                    Are you sure you want to permanently delete this admin? All data will be removed
                                    from the database forever.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-zinc-800/30 border-t border-zinc-800 flex justify-end gap-3">
                        <button wire:click="closeForceDeleteModal"
                            class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-zinc-100 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                        <button wire:click="forceDelete"
                            class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-lg transition-colors duration-200 font-semibold">
                            Delete Permanently
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

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
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Number</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->number }}</p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border  {{ $detailsAdmin->status_color  }}">
                                    {{ $detailsAdmin->status_label }}
                                </span>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Date Of Birth</p>
                                <p class="text-zinc-200 font-medium">{{ $detailsAdmin->date_of_birth }}</p>
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
        <div class="fixed  inset-0 z-50 overflow-y-auto " wire:keydown.escape="closeModal ">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity" wire:click="closeModal">
                </div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-3xl w-full border border-zinc-800 ">
                    <form wire:submit="save">
                        <div class="px-6 py-4 border-b border-zinc-800">
                            <h3 class="text-lg font-semibold text-zinc-100">
                                {{ $editMode ? __('Edit Admin') : __('Create New Admin') }}
                            </h3>
                        </div>

                        <div class="px-6 py-4 space-y-4">
                            {{-- Avatar Upload --}}
                            <label class="block text-sm font-medium text-zinc-300 text-center mb-2">Profile
                                Picture</label>
                            <div class="flex items-center justify-center">
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
                                <label class="block  text-sm font-medium text-zinc-300 mb-2">Name *</label>
                                <input wire:model="name" type="text"
                                    class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    placeholder="Enter admin name">
                                @error('name')
                                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email & Number --}}
                            <div class=" grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Email *</label>
                                    <input wire:model="email" type="email"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter email address">
                                    @error('email')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Number</label>
                                    <input wire:model="number" type="number"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter phone number">
                                    @error('number')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date of Birth & Status --}}
                            <div class=" grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Date of Birth</label>
                                    <input wire:model="date_of_birth" type="date"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
                                    @error('date_of_birth')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-zinc-300  mb-2">Status </label>
                                    <select wire:model="status"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent">
                                        @foreach ($statuses as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ $key == $status ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password & Confirm Password --}}
                            <div class=" grid grid-cols-1 md:grid-cols-2 gap-4">
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

                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-zinc-300 mb-2">
                                        Confirm Password
                                    </label>
                                    <input id="password_confirmation" wire:model="password_confirmation"
                                        type="password"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Confirm Password">
                                </div>
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

    
</div>
