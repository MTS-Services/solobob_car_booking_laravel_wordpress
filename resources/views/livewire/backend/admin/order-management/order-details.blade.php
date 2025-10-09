<div>
    <section>

        <div class="flex items-center justify-between glass-card rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-bold text-text-primary">{{ __('Order Details') }}</h2>
           
        </div>
       


    </section>

  {{-- Details Modal --}}

        <div class="block inset-0 z-50 overflow-y-auto"">
            <div class="block items-center justify-center min-h-screen py-6">


                {{-- Modal --}}
                <div
                    class="relative bg-zinc-50  rounded-2xl text-left overflow-hidden  transform transition-all w-full border border-zinc-50">
                   

                    {{-- Body --}}
                    <div class="px-6 py-6 space-y-6">
                        {{-- Profile Section --}}
                       
                        @if (session()->has('message'))
                            <div class="py-2 px-2 bg-zinc-200 rounded-[10px]">
                                <p class="text-black px-5 py-2">{{ session('message')}}</p>
                            </div>
                        @endif
                        @if($detailsOrder->reason != null)
                            <div class="py-2 px-2 bg-zinc-200 rounded-[10px]">
                                <p class="text-red-500 px-5 py-2"><span class="font-bold text-red-500">{{"Order has been rejected. Cause: "}}</span> {{ $detailsOrder->reason }}</p>
                            </div>
                        @endif
                        {{-- Information Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-zinc-700 >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Order By</p>
                                <p class="text-zinc-500 font-medium">#{{ $detailsOrder->booking_reference }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700 >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Reference</p>
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
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{  $detailsOrder->booking_status_color  }}">
                                    {{ $detailsOrder->booking_status_label }}
                                </span>
                            </div>
                            

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Email </p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->user->email }}</p>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Vehicle </p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->vehicle ?->title }}</p>
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
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Delivery Fee</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->service_fee }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Delivery Fee</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->tax_amount }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Delivery Fee</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->security_deposit }}</p>
                                
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Delivery Fee</p>
                                <p class="text-zinc-500 font-medium"> ${{ $detailsOrder->total_amount }}</p>
                                
                            </div>


                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Audited By</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->auditor->name }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Special Request</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->special_requests }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Reason</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->reason }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created At</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->created_at_formatted }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->created_at_human }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created By</p>
                                <p class="text-zinc-500 font-medium">{{ $detailsOrder->createdBy?->name ?? 'System' }}
                                </p>
                                @if ($detailsOrder->createdBy)
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->createdBy->email }}</p>
                                @endif
                            </div>

                            @if ($detailsOrder->updated_at && $detailsOrder->updated_at != $detailsOrder->created_at)
                                <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated At</p>
                                    <p class="text-zinc-500 font-medium">{{ $detailsOrder->updated_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->updated_at_human }}</p>
                                </div>

                                @if ($detailsOrder->updatedBy)
                                    <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated By</p>
                                        <p class="text-zinc-500 font-medium">{{ $detailsOrder->updatedBy->name }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->updatedBy->email }}
                                        </p>
                                    </div>
                                @endif
                            @endif

                            @if ($detailsOrder->deleted_at)
                                <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted At</p>
                                    <p class="text-zinc-500 font-medium">{{ $detailsOrder->deleted_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->deleted_at_human }}</p>
                                </div>

                                @if ($detailsOrder->deletedBy)
                                    <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted By</p>
                                        <p class="text-zinc-500 font-medium">{{ $detailsOrder->deletedBy->name }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $detailsOrder->deletedBy->email }}
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </div>
                        @if(! $detailsOrder->booking_status)
                        <div class="button_wrapper">
                            <div class="flex gap-1 justify-end">
                                <a href="#" class="flex items-center justify-center btn btn-primary " wire:click.prevent="accpetOrder()">Accept</a>
                                <a href="#" class="flex items-center justify-center btn btn-warning" wire:click.prevent="openRejectModal()">Reject</a>
                            </div>
                        </div>
                        @endif
                    </div>

                

                    
                </div>
            </div>
        </div>

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
                        <form wire:submit="saveRejection">
                            {{-- Header --}}
                            <div class="px-6 py-4 border-b border-zinc-800">
                                <h3 class="text-lg font-semibold text-zinc-100">
                                   Reject Reason
                                </h3>
                            </div>

                            {{-- Body --}}
                            <div class="px-6 py-4 space-y-4">

                                {{-- Name --}}
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-300 mb-2">Reason *</label>
                                   
                                    <textarea wire:model="reason" 
                                     class="w-full bg-zinc-800/50 border border-zinc-700 rounded-lg px-4 py-2.5 text-zinc-100 placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-600 focus:border-transparent"
                                    id="" cols="10" rows="5"></textarea>
                                    @error('reason')
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
                                    Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

</div>
