<div>
    <section class="container mb-10">
        <div class="flex items-center justify-between glass-card rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-text-primary">{{ __('Payment List') }}</h2>
            <div class="bg-white rounded-lg shadow-sm border border-zinc-200 text-right w-[20%] relative">
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
                                    <span class="text-accent font-bold text-lg">${{ $payment->amount_formatted }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge text-white {{ $payment->payment_method_color }}">
                                        {{ $payment->payment_method_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border badge {{ $payment->status_color }}">{{ $payment->status_label }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-accent text-sm">{{ $payment->created_at->format('M d, Y') }}</span>
                                        <span
                                            class="text-zinc-500 text-xs">{{ $payment->created_at->diffForHumans() }}</span>
                                    </div>
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
                                                    <a href="{{ route('user.payment-details', $payment->id) }}"
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
                                                    </a>
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

    {{-- Details Modal --}}
    @if ($showDetailsModal && $detailsPayment)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:keydown.escape="closeDetailsModal">
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
                    wire:click="closeDetailsModal">
                </div>

                <div
                    class="relative bg-zinc-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all max-w-6xl w-full border border-zinc-800">
                    <div class="px-6 py-4 border-b border-zinc-800 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-100">{{ __('Payment Details') }}</h3>
                        <button wire:click="closeDetailsModal"
                            class="text-white hover:text-zinc-300 transition-colors">
                            <flux:icon name="x-mark" class="w-6 h-6" stroke="white" />
                        </button>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        {{-- Payment ID & Amount --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-zinc-500">Payment ID</p>
                                <p class="text-2xl font-bold text-zinc-100">#{{ $detailsPayment->id }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-zinc-500">Amount</p>
                                <p class="text-3xl font-bold text-emerald-400">
                                    ${{ number_format($detailsPayment->amount, 2) }}</p>
                            </div>
                        </div>

                        {{-- Grid Info --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Booking ID</p>
                                <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">
                                    #{{ $detailsPayment->booking_id }}
                                </a>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Payment Method</p>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $detailsPayment->payment_method == 1 ? 'bg-purple-500/20 text-purple-400 border-purple-500/30' : 'bg-blue-500/20 text-blue-400 border-blue-500/30' }}">
                                    {{ $detailsPayment->payment_method == 1 ? 'Stripe' : 'PayPal' }}
                                </span>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                                @php
                                    $statusColors = [
                                        0 => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                        1 => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                        2 => 'bg-red-500/20 text-red-400 border-red-500/30',
                                        3 => 'bg-zinc-500/20 text-zinc-400 border-zinc-500/30',
                                    ];
                                    $colorClass =
                                        $statusColors[$detailsPayment->status] ??
                                        'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                    @if ($detailsPayment->status == 0)
                                        Pending
                                    @elseif($detailsPayment->status == 1)
                                        Completed
                                    @elseif($detailsPayment->status == 2)
                                        Failed
                                    @else
                                        Refunded
                                    @endif
                                </span>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Type</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->type_label ?? 'Type ' . $detailsPayment->type }}</p>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Provider</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->paymentMethod->first()?->provider ?? 'Unknown' }}
                                </p>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Last Four</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->paymentMethod->first()?->last_four ?? 'Unknown' }}
                                </p>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Card Brand</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->paymentMethod->first()?->card_brand ?? 'Unknown' }}
                                </p>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Expiry Year</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->paymentMethod->first()?->expiry_year ?? 'Unknown' }}
                                </p>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Expiry Month</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->paymentMethod->first()?->expiry_month ?? 'Unknown' }}
                                </p>
                            </div>
                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Card  Holder</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->paymentMethod->first()?->cardholder_name ?? 'Unknown' }}
                                </p>
                            </div>

                            <div class="bg-zinc-800/50 rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created At</p>
                                <p class="text-zinc-200 font-medium">
                                    {{ $detailsPayment->created_at->format('M d, Y h:i A') }}</p>
                                <p class="text-xs text-zinc-400 mt-1">
                                    {{ $detailsPayment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
