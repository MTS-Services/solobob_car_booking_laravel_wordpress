<div>
    <section class="">
        <div class="glass-card rounded-2xl p-6 mb-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-text-primary">{{ __('Order List') }}</h2>
            <div class="flex items-center gap-2">
            </div>
        </div>
    </section>
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
</div>
