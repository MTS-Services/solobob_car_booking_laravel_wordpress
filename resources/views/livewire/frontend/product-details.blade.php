<section>
    {{-- header section --}}
    <div class="max-w-7xl mx-auto bg-white flex justify-between items-center">
        <div class="flex flex-col space-y-2">
            <div class="flex items-center gap-2">
                <flux:icon name="arrow-left" class="w-5 h-5" wire:click="back" />
                <button>Back</button>
            </div>
            <h2 class="text-2xl font-normal">2025 Nissan Sentra S</h2>
            <div class=" text-white text-base bg-accent w-fit px-3 rounded-md">
                <!-- Dynamic Price -->
                $99.00 <span class="text-xs sm:text-sm font-medium text-white">/Day</span>
            </div>
        </div>
        <div class="font-bold cursor-pointer" onclick="copyCurrentUrl(this)">
            <flux:icon name='link' class='w-6 h-6 text-gray-600 hover:text-blue-500 transition' />
        </div>
    </div>
    @push('scripts')
        <script>
            function copyCurrentUrl(el) {
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    el.innerHTML = `<flux:icon name='check' class='w-6 h-6 text-green-600 transition' />`;
                    setTimeout(() => {
                        el.innerHTML =
                            `<flux:icon name='link' class='w-6 h-6 text-gray-600 hover:text-blue-500 transition' />`;
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }
        </script>
    @endpush

</section>
