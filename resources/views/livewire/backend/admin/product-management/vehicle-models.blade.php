<div>
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
                    <h2 class="text-xl font-bold text-accent">{{ __('Vehicle Models List') }}</h2>
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

            {{-- Table Section --}}
            <x-backend.table :columns="$columns" :data="$vehicleModels" :actions="$actions" search-property="search"
                per-page-property="perPage" empty-message="No admins found." />
        </section>

        {{-- Details Modal --}}
        @if ($showDetailsModal && $detailsVehicleModel)
            <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeDetailsModal">
                <div class="flex items-center justify-center min-h-screen px-4 py-6">
                    {{-- Backdrop --}}
                    <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                        wire:click="closeDetailsModal"></div>

                    {{-- Modal --}}
                    <div
                        class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-2xl w-full border border-zinc-800">
                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-zinc-800 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-zinc-100">{{ __('Vehicle Model Details') }}</h3>
                            <button wire:click="closeDetailsModal"
                                class="text-zinc-400 hover:text-zinc-300 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-6 space-y-6">
                            {{-- Profile Section --}}
                            <div class="flex items-center gap-4">

                                <div>
                                    <h4 class="text-xl font-semibold text-zinc-100">{{ $detailsVehicleModel->name }}
                                    </h4>

                                </div>
                            </div>

                            {{-- Information Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                               

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created At</p>
                                    <p class="text-zinc-200 font-medium">
                                        {{ $detailsVehicleModel->created_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsVehicleModel->created_at_human }}
                                    </p>
                                </div>

                                <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created By</p>
                                    <p class="text-zinc-200 font-medium">
                                        {{ $detailsVehicleModel->createdBy?->name ?? 'System' }}
                                    </p>
                                    @if ($detailsVehicleModel->createdBy)
                                        <p class="text-xs text-zinc-400 mt-1">
                                            {{ $detailsVehicleModel->createdBy->slug }}</p>
                                    @endif
                                </div>

                                @if ($detailsVehicleModel->updated_at && $detailsVehicleModel->updated_at != $detailsVehicleModel->created_at)
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated At</p>
                                        <p class="text-zinc-200 font-medium">
                                            {{ $detailsVehicleModel->updated_at_formatted }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">
                                            {{ $detailsVehicleModel->updated_at_human }}</p>
                                    </div>

                                    @if ($detailsVehicleModel->updatedBy)
                                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated By
                                            </p>
                                            <p class="text-zinc-200 font-medium">
                                                {{ $detailsVehicleModel->updatedBy->name }}</p>
                                            <p class="text-xs text-zinc-400 mt-1">
                                                {{ $detailsVehicleModel->updatedBy->email }}
                                            </p>
                                        </div>
                                    @endif
                                @endif

                                @if ($detailsVehicleModel->deleted_at)
                                    <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted At</p>
                                        <p class="text-zinc-200 font-medium">
                                            {{ $detailsVehicleModel->deleted_at_formatted }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">
                                            {{ $detailsVehicleModel->deleted_at_human }}</p>
                                    </div>

                                    @if ($detailsVehicleModel->deletedBy)
                                        <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                            <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted By
                                            </p>
                                            <p class="text-zinc-200 font-medium">
                                                {{ $detailsVehicleModel->deletedBy->name }}</p>
                                            <p class="text-xs text-zinc-400 mt-1">
                                                {{ $detailsVehicleModel->deletedBy->email }}
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
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
                    <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                        wire:click="closeModal">
                    </div>

                    {{-- Modal --}}
                    <div
                        class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-lg w-full border border-zinc-800">
                        <form wire:submit="save">
                            {{-- Header --}}
                            <div class="px-6 py-4 border-b border-zinc-800">
                                <h3 class="text-lg font-semibold text-zinc-100">
                                    {{ $editMode ? __('Edit Vehicle Model') : __('Create New Vehicle Model') }}
                                </h3>
                            </div>

                            {{-- Body --}}
                            <div class="px-6 py-4 space-y-4">

                                {{-- Name --}}
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Name *</label>
                                    <input wire:model="name" type="text"
                                        class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                        placeholder="Enter vehicle model name">
                                    @error('name')
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



                            </div>

                            {{-- Footer --}}
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
                    {{-- Backdrop --}}
                    <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                        wire:click="closeDeleteModal"></div>

                    {{-- Modal --}}
                    <div
                        class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-md w-full border border-zinc-800">
                        {{-- Header --}}
                        <div class="px-6 py-4 border-b border-zinc-800">
                            <h3 class="text-lg font-semibold text-zinc-100">{{ __('Confirm Delete') }}</h3>
                        </div>

                        {{-- Body --}}
                        <div class="px-6 py-4">
                            <p class="text-zinc-300">Are you sure you want to delete this vehicle model? This action
                                will 
                                delete the record forever won't recover again.</p>
                        </div>

                        {{-- Footer --}}
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

</div>
