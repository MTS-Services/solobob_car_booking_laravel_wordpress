<div>
    <section>         
        <div class="flex items-center justify-between glass-card rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-text-primary">{{ __('Payment List') }}</h2>
        </div>
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
                                ID</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Booking ID</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                User</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Amount</th>
                            <th class="px-6 text-white py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                Method</th>
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
                        @forelse ($payments as $payment)
                            <tr class="bg-zinc-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-accent">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                                        #{{ $payment->booking_id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-zinc-700 flex items-center justify-center text-zinc-100 text-xs font-semibold">
                                            {{ Str::upper(Str::substr($payment->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-accent font-medium">{{ $payment->user->name }}</div>
                                            <div class="text-zinc-500 text-xs">{{ $payment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-accent font-bold text-lg">${{ $payment->amount_formatted }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge text-white {{ $payment->payment_method_color }}">
                                        {{ $payment->payment_method_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border badge {{ $payment->status_color}}">{{ $payment->status_label }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-accent text-sm">{{ $payment->created_at->format('M d, Y') }}</span>
                                        <span
                                            class="text-zinc-500 text-xs">{{ $payment->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-accent">
                                    {{ $payment->createdBy?->name ?? 'System' }}
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
                                                    <button wire:click="openDetailsModal({{ $payment->id }})"
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
                                                    {{-- <button wire:click="openDeleteModal({{ $payment->id }})"
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
                                                    </button> --}}
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
                                        <p class="text-zinc-500 text-lg">No Payments found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($payments->hasPages())
                <div class="px-6 py-4 border-t border-zinc-700/50">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
