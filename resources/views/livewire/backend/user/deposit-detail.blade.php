<section class="container mx-auto ">
           <div class="block inset-0 z-50 overflow-y-auto">
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
                        @if($depositDetail->reason != null)
                            <div class="py-2 px-2 bg-zinc-200 rounded-[10px]">
                                <p class="text-red-500 px-5 py-2"><span class="font-bold text-red-500">{{"Order has been rejected. Cause: "}}</span> {{ $depositDetail->reason }}</p>
                            </div>
                        @endif
                        {{-- Information Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-zinc-700" >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Booking</p>
                                {{ $depositDetail->booking_id}}
                                <p class="text-zinc-500 font-regular underline text-xs"><a href="{{ route('user.booking-details', $depositDetail->booking_id) }}" wire:navigate>Booking Details</a></p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Payment Status</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $depositDetail->getStatusColorAttribute() }}">
                                    {{ $depositDetail->getStatusLabelAttribute() }}
                                </span>
                            </div>
                              <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Payment Type</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $depositDetail->getTypeColorAttribute() }}">
                                    {{ $depositDetail->getTypeLabelAttribute() }}
                                </span>
                            </div>

                              <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Payment Method</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $depositDetail->getTypeColorAttribute() }}">
                                    {{ $depositDetail->getPaymentMethodLabelAttribute() }}
                                </span>

                            </div>  <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Amount</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border">
                                    ${{ $depositDetail->amount }}
                                </span>
                            </div>
                            



                            {{-- Common --}}
                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created At</p>
                                <p class="text-zinc-500 font-medium">{{ $depositDetail->created_at_formatted }}</p>
                                <p class="text-xs text-zinc-400 mt-1">{{ $depositDetail->created_at_human }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Created By</p>
                                <p class="text-zinc-500 font-medium">{{ $depositDetail->createdBy?->name ?? 'System' }}
                                </p>
                                @if ($depositDetail->createdBy)
                                    <p class="text-xs text-zinc-400 mt-1">{{ $depositDetail->createdBy->email }}</p>
                                @endif
                            </div>

                            @if ($depositDetail->updated_at && $depositDetail->updated_at != $depositDetail->created_at)
                                <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated At</p>
                                    <p class="text-zinc-500 font-medium">{{ $depositDetail->updated_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $depositDetail->updated_at_human }}</p>
                                </div>

                                @if ($depositDetail->updatedBy)
                                    <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Updated By</p>
                                        <p class="text-zinc-500 font-medium">{{ $depositDetail->updatedBy->name }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $depositDetail->updatedBy->email }}
                                        </p>
                                    </div>
                                @endif
                            @endif

                            @if ($depositDetail->deleted_at)
                                <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                    <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted At</p>
                                    <p class="text-zinc-500 font-medium">{{ $depositDetail->deleted_at_formatted }}</p>
                                    <p class="text-xs text-zinc-400 mt-1">{{ $depositDetail->deleted_at_human }}</p>
                                </div>

                                @if ($depositDetail->deletedBy)
                                    <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                        <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Deleted By</p>
                                        <p class="text-zinc-500 font-medium">{{ $depositDetail->deletedBy->name }}</p>
                                        <p class="text-xs text-zinc-400 mt-1">{{ $depositDetail->deletedBy->email }}
                                        </p>
                                    </div>
                                @endif
                            @endif
                        </div>


                    </div>

                

                    
                </div>
            </div>
        </div>
</section>
