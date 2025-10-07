<div class="bg-gray-100 max-w[1950px] mx-auto oiverflow-hidden">
    <section class="relative w-full h-auto sm:min-h-[400px] md:min-h-[500px] lg:min-h-[680px]  flex items-center justify-center bg-gray-100 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/car contenct.jpg') }}" alt="City Skyline Illustration"
                class="w-full h-full object-cover  brightness-60" />
        </div>

        <div class="container relative mx-auto">

            <div class=" grid grid-cols-1 md:grid-cols-2 ">
            <div class="w-full flex  justify-between items-end gap-5 bg-transparent py-4 px-4 z-10">
                <div class=" max-w-xl p-6 mx-auto">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 uppercase">Get In Touch</h2>

                    <p class=" mb-10 text-white leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus,
                        luctus nec ullamcorper mattis, pulvinar dapibus leo.
                    </p>
 
                    <div class="space-y-6 sm: items-center ">

                        <div class="flex items-center  space-x-4">
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <flux:icon name="phone" />
                            </div>
                            <div>
                                <h4 class="font-semibold text-white text-lg">Phone Number</h4>
                                <p class="text-white">0123456789</p>
                            </div>
                        </div>


                        <div class="flex items-center space-x-4">
                            <div class="bg-yellow-100 p-3 rounded-lg">
                                <flux:icon name="envelope" />
                            </div>
                            <div>
                                <h4 class="font-semibold text-white text-lg">Support Email</h4>
                                <p class="text-white">sample@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="w-full flex items-center justify-center bg-black/40 rounded-xl shadow-2xl p-6">
                <form class="space-y-4 w-[100%]" wire:submit="contactSubmit">
                    @if (session()->has('submit_message'))
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <p class="text-primary"> {{ session('submit_message') }} </p>
                        </div>
                    @endif
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6 sm:mb-8 text-center">GET IN TOUCH</h2>
                    <div class="grid grid-cols-2 gap-4">

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

                    <div class="grid grid-cols-2  gap-4">
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

        </div>
    </section>
    <section class="w-full h-[370px]  md:h-[380px] lg:h-[400px]">
        <iframe class="w-full h-full rounded-xl shadow-lg"
            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d98224.60260557868!2d90.32757344185434!3d23.808155357088612!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1759819773911!5m2!1sen!2sbd"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </section>


</div>
