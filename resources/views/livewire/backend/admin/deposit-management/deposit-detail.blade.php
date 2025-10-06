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
                        @if($depositDetail->reason != null)
                            <div class="py-2 px-2 bg-zinc-200 rounded-[10px]">
                                <p class="text-red-500 px-5 py-2"><span class="font-bold text-red-500">{{"Order has been rejected. Cause: "}}</span> {{ $depositDetail->reason }}</p>
                            </div>
                        @endif
                        {{-- Information Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-zinc-700" >
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Booking</p>
                                <p class="text-zinc-500 font-medium">#{{ $depositDetail->booking_id }}</p>
                            </div>

                            <div class="bg-white rounded-lg p-4 border border-zinc-700">
                                <p class="text-xs text-zinc-500 uppercase tracking-wider mb-1">Payment Status</p>
                               
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $depositDetail->getStatusColorAttribute() }}">
                                    {{ $depositDetail->getStatusLabelAttribute() }}
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

                        @if(! $depositDetail->booking_status)
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
