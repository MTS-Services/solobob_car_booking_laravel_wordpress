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
 <div class="glass-card rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-accent">{{ __('User Reviews') }}</h2>
                    <div class="flex items-center gap-2">
                        {{-- <x-button href="#" icon="trash-2" type='secondary' permission="product-category-trash"
                            class="text-white">
                            {{ __('Trash') }}
                        </x-button> --}}
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




  <x-backend.table :columns="$columns" :data="$items" :actions="$actions" search-property="search"
            per-page-property="perPage" empty-message="No Reviews found." />

           
 <!-- View Review Modal -->
    <x-modal name="viewReviewModal" title="Review Details">
        @if($selectedReview)
            <p><strong>User:</strong> {{ $selectedReview->user?->name }}</p>
            <p><strong>Title:</strong> {{ $selectedReview->title }}</p>
            <p><strong>Rating:</strong> {{ $selectedReview->rating }}</p>
            <p><strong>Comment:</strong> {{ $selectedReview->comment }}</p>
            <p><strong>Status:</strong> {{ $selectedReview->status_label }}</p>
            <p><strong>Created By:</strong> {{ $selectedReview->createdBy?->name ?? 'system' }}</p>
            <p><strong>Updated By:</strong> {{ $selectedReview->updatedBy?->name ?? 'system' }}</p>
            <p><strong>Created At:</strong> {{ $selectedReview->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $selectedReview->updated_at }}</p>
        @endif
    </x-modal>






 

</div>

