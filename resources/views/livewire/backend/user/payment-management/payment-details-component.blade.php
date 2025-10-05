<div>
    <div class="container mb-10">


        <div class="px-6 py-6 space-y-6">
            <div class="flex items-center justify-between glass-card rounded-2xl p-6 mb-6">
                <h2 class="text-xl font-bold text-text-primary">{{ __('Payment List') }}</h2>
            </div>
            <div class="glass-card rounded-2xl p-6 mb-6">
                {{-- Payment ID & Amount --}}
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm text-zinc-500">Payment ID</p>
                        <p class="text-2xl font-bold text-zinc-500">#{{ $detailsPayment->id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-zinc-500">Amount</p>
                        <p class="text-3xl font-bold text-emerald-400">
                            ${{ number_format($detailsPayment->amount, 2) }}</p>
                    </div>
                </div>

                {{-- Grid Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Booking ID</p>
                        <a href="#" class="text-blue-400 hover:text-blue-300 font-medium">
                            #{{ $detailsPayment->booking_id }}
                        </a>
                    </div>

                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Payment Method</p>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $detailsPayment->payment_method == 1 ? 'bg-purple-500/20 text-purple-400 border-purple-500/30' : 'bg-blue-500/20 text-blue-400 border-blue-500/30' }}">
                            {{ $detailsPayment->payment_method == 1 ? 'Stripe' : 'PayPal' }}
                        </span>
                    </div>

                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
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

                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Type</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->type_label ?? 'Type ' . $detailsPayment->type }}</p>
                    </div>
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Provider</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->paymentMethod->first()?->provider ?? 'Unknown' }}
                        </p>
                    </div>
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Last Four</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->paymentMethod->first()?->last_four ?? 'Unknown' }}
                        </p>
                    </div>
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Card Brand</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->paymentMethod->first()?->card_brand ?? 'Unknown' }}
                        </p>
                    </div>
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Expiry Year</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->paymentMethod->first()?->expiry_year ?? 'Unknown' }}
                        </p>
                    </div>
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Expiry Month</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->paymentMethod->first()?->expiry_month ?? 'Unknown' }}
                        </p>
                    </div>
                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Card Holder</p>
                        <p class="text-zinc-200 font-medium">
                            {{ $detailsPayment->paymentMethod->first()?->cardholder_name ?? 'Unknown' }}
                        </p>
                    </div>

                    <div class="glass-card rounded-lg p-4 border border-zinc-700/50">
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
