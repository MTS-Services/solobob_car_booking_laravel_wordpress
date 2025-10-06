<section class="container mx-auto ">
    @if ($detailsOrder)
               <div class="block inset-0 z-50 overflow-y-auto"">
            <div class="block items-center justify-center min-h-screen py-6">


                {{-- Modal --}}
                <div
                    class="relative bg-zinc-50  rounded-2xl text-left overflow-hidden  transform transition-all w-full border border-zinc-50">
                   

                    {{-- Body --}}
                    <div class="px-6 py-6 space-y-6">
                        {{-- Profile Section --}}
                       
                        @if($detailsOrder->reason != null)
                            <div class="py-2 px-2 bg-zinc-200 rounded-[10px]">
                                <p class="text-red-500 px-5 py-2"><span class="font-bold text-red-500">{{"Order has been rejected. Cause: "}}</span> {{ $detailsOrder->reason }}</p>
                            </div>
                        @endif
                        {{-- Information Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-zinc-700 >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Reference</p>
                                <p class="text-zinc-500 font-medium">#{{ $detailsOrder->booking_reference }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700 >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Order By</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->user->name }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Status</p>
                                @php
                                    $statusColors = [
                                        \App\Models\Booking::BOOKING_STATUS_PENDING =>
                                            'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                        \App\Models\Booking::BOOKING_STATUS_ACCEPTED =>
                                            'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                        \App\Models\Booking::BOOKING_STATUS_DEPOSITED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                         \App\Models\Booking::BOOKING_STATUS_DELIVERED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                         \App\Models\Booking::BOOKING_STATUS_RETURNED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                         \App\Models\Booking::BOOKING_STATUS_CANCELLED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                         \App\Models\Booking::BOOKING_STATUS_REJECTED =>
                                            'bg-red-500/20 text-red-400 border-red-500/30',
                                    ];
                                    $colorClass =
                                        $statusColors[$detailsOrder->booking_status] ??
                                        'bg-zinc-500/20 text-zinc-400 border-zinc-500/30';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $colorClass }}">
                                    {{ $detailsOrder->getStatusLabelAttribute() }}
                                </span>
                            </div>
                            

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Email </p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->user->email }}</p>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Vehicle </p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->vehicle->title }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Booking Date </p>
                                 <p class="text-zinc-500 font-medium">{{ $detailsOrder->created_at_formatted }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->created_at_human }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Pickup Date </p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->humanReadableDateTime($detailsOrder->pickup_date) }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Return Date </p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->humanReadableDateTime($detailsOrder->return_date) }}</p>
                            </div>

                            
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Return Location</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->return_location }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Sub total</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->subtotal }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Delivery Fee</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->delivery_fee }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Service Fee</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->service_fee }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">TAx </p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->tax_amount }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Security Deposit</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->security_deposit }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Grand Total</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->total_amount }}</p>
                                
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Special Request</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->special_requests }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Reason</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->reason }}</p>
                            </div>


                          
                           
                        </div>
                    </div>

                

                    
                </div>
            </div>
        </div>
    @else
        <div class="text-center bg-gray-50 h-[50vh]">
            <div class="flex justify-center mb-8 ">

                <svg class="w-32 h-32 text-cyan-500" viewBox="0 0 200 120" fill="none" stroke="currentColor"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Car Body -->
                    <rect x="30" y="60" width="140" height="40" rx="5" />

                    <!-- Car Roof -->
                    <path d="M50 60 L50 40 L90 40 L100 60" />
                    <path d="M100 60 L110 40 L150 40 L150 60" />

                    <!-- Windows -->
                    <line x1="55" y1="45" x2="55" y2="58" />
                    <line x1="85" y1="45" x2="85" y2="58" />
                    <line x1="115" y1="45" x2="115" y2="58" />
                    <line x1="145" y1="45" x2="145" y2="58" />

                    <!-- Wheels -->
                    <circle cx="60" cy="100" r="12" />
                    <circle cx="60" cy="100" r="6" />
                    <circle cx="140" cy="100" r="12" />
                    <circle cx="140" cy="100" r="6" />

                    <!-- Car Details -->
                    <line x1="40" y1="75" x2="50" y2="75" />
                    <line x1="150" y1="75" x2="160" y2="75" />

                    <!-- Roof Light -->
                    <rect x="95" y="30" width="10" height="5" rx="2" />
                </svg>
            </div>

            <!-- Empty State Text -->

            <h2 class="text-2xl font-semibold text-gray-800 mb-2">No Bookings Yet</h2>
            <p class="text-gray-500">Your booking history will appear here</p>

        </div>
    @endif
</section>
