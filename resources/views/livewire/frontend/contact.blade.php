<div class="bg-gray-100 max-w[1950px] mx-auto oiverflow-hidden">
    <section class="relative">
        <div class="container flex flex-col lg:flex-row min-h-screen">


            <div class="w-full bg-transparent inline items-start justify-center px-4 z-1">
                <div class="w-full max-w-2xl py-8 flex h-[100%] justify-center items-center flex-col">
                    <h2 class="text-3xl sm:text-4xl font-bold text-black mb-6 sm:mb-8 text-center">GET IN TOUCH</h2>

                    <form class="space-y-4 w-[100%]" wire:submit="contactSubmit">
                        @if (session()->has('submit_message'))
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <p class="text-primary"> {{ session('submit_message') }} </p>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input type="text" placeholder="First Name" wire:model="form.first_name"
                                    class="w-full px-3 py-2 border @if (!$errors->has('form.first_name')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif rounded bg-white focus:outline-none focus:border-zinc-600">
                                @if ($errors->has('form.first_name'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                        {{ $errors->first('form.first_name') }}</small>
                                @endif
                            </div>
                            <div>
                                <input type="text" placeholder="Last Name" wire:model="form.last_name"
                                    class="w-full px-3 py-2 border @if (!$errors->has('form.last_name')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  border-gray-300 rounded bg-white text-gray-700 focus:outline-none focus:border-zinc-600">
                                @if ($errors->has('form.last_name'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                        {{ $errors->first('form.last_name') }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input type="email" placeholder="Email" wire:model="form.email"
                                    class="w-full px-3 py-2 border  @if (!$errors->has('form.email')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  rounded bg-white  focus:outline-none focus:border-zinc-600">
                                @if ($errors->has('form.email'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                        {{ $errors->first('form.last_name') }}</small>
                                @endif
                            </div>
                            <div>
                                <input type="tel" placeholder="Phone Number" wire:model="form.phone"
                                    class="w-full px-3 py-2 border @if (!$errors->has('form.phone')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  bg-white focus:outline-none focus:border-zinc-600">
                                @if ($errors->has('form.phone'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                        {{ $errors->first('form.phone') }}</small>
                                @endif
                            </div>
                        </div>

                        <div>
                            <textarea placeholder="Message" rows="4" wire:model="form.message"
                                class="w-full px-3 py-2 border bg-white @if (!$errors->has('form.message')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif rounded bg-whitefocus:outline-none focus:border-zinc-600"></textarea>
                            @if ($errors->has('form.message'))
                                <small class="p-0 m-0 text-red-500 font-[500] text-[12px]">
                                    {{ $errors->first('form.message') }}</small>
                            @endif
                        </div>
                        <button type="submit"
                            class="w-full bg-zinc-500 text-white py-3 rounded font-semibold hover:bg-yellow-800 transition">
                            SUBMIT
                        </button>


                    </form>

                </div>
            </div>

            <div
                class="hidden w-1/3 absolute right-0 top-0 lg:flex items-center justify-center overflow-hidden h-full z-0">
                <img src="{{ asset('assets/images/hero-aside.png') }}" alt="City Skyline Illustration"
                    class="w-full h-full object-cover" />
            </div>
        </div>
    </section>
</div>
