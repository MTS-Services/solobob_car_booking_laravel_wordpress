<div class="bg-gray-100 w-screen lg:w-full mx-auto oiverflow-hidden">
    <section class="relative ">
        <div class="container flex flex-col lg:flex-row min-h-screen">
            <div class="w-full bg-trasnparent flex items-center justify-center px-4">
                <div class="w-full">
                    <h1 class="text-xl sm:text-5xl font-bold text-black mb-4 sm:mb-4 text-center lg:text-left">
                        FLEXIBLE CAR RENTALS<br>
                        FOR GIG WORKERS &<br>
                        <span class="text-zinc-500">LOCAL BUSINESSES</span>
                    </h1>
                    <p class="text-sm sm:text-lg text-gray-700 mb-6 sm:mb-8 text-center lg:text-left">
                        Whether you're planning a weekend getaway, a business trip, or just need a reliable ride for the
                        day, we offers a wide range of vehicles to suit your needs.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <button
                            class="bg-zinc-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-zinc-600 transition w-full sm:w-auto">
                            APPLY NOW
                        </button>
                        <button
                            class="bg-white text-black px-8 py-3 rounded-full font-semibold border border-zinc-500 hover:bg-gray-50 transition w-full sm:w-auto">
                            SEE PRICING & AVAILABILITY
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full bg-transparent flex items-start justify-center px-4 z-1">
                <div class="w-full max-w-xl py-8 flex h-[100%] justify-center items-center flex-col">
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
                                <small class="p-0 m-0 text-red-500 font-[500] text-[12px]"> {{ $errors->first('form.first_name') }}</small>
                                @endif
                           </div>
                                <div>
                                    <input type="text" placeholder="Last Name" wire:model="form.last_name"
                                class="w-full px-3 py-2 border @if (!$errors->has('form.last_name')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  border-gray-300 rounded bg-white text-gray-700 focus:outline-none focus:border-zinc-600">
                                @if ($errors->has('form.last_name'))
                                <small class="p-0 m-0 text-red-500 font-[500] text-[12px]"> {{ $errors->first('form.last_name') }}</small>
                                @endif
                                </div>
                            </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <input type="email" placeholder="Email" wire:model="form.email"
                                class="w-full px-3 py-2 border  @if (!$errors->has('form.email')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  rounded bg-white  focus:outline-none focus:border-zinc-600">
                                 @if ($errors->has('form.email'))
                                <small class="p-0 m-0 text-red-500 font-[500] text-[12px]"> {{ $errors->first('form.last_name') }}</small>
                                @endif
                            </div>
                            <div>
                                 <input type="tel" placeholder="Phone Number" wire:model="form.phone"
                                class="w-full px-3 py-2 border @if (!$errors->has('form.phone')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif  bg-white focus:outline-none focus:border-zinc-600">
                                @if ($errors->has('form.phone'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]"> {{ $errors->first('form.phone') }}</small>
                                    @endif
                            </div>
                        </div>

                       <div>
                         <textarea placeholder="Message" rows="4" wire:model="form.message"
                            class="w-full px-3 py-2 border bg-white @if (!$errors->has('form.message')) border-gray-300   text-gray-700 @else  border-red-500   text-red-500 @endif rounded bg-whitefocus:outline-none focus:border-zinc-600"></textarea>
                                @if ($errors->has('form.message'))
                                    <small class="p-0 m-0 text-red-500 font-[500] text-[12px]"> {{ $errors->first('form.message') }}</small>
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


    {{-- tab 1                              tab 2                               tab 3                               tab 4 --}}
    {{-- <livewire:frontend.boooking />          Component 2                         component 3                         component 4 --}}

    <section class="py-12 px-4 md:px-8 lg:px-16">
        <div class="w-full mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-black mb-4">WHO WE SERVE</h2>
                <p class="text-gray-600 text-base md:text-lg max-w-3xl mx-auto">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper
                    mattis, pulvinar dapibus leo.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" stroke="white">
                                <path
                                    d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-black mb-4">Gig Drivers</h3>
                        <button
                            class="bg-zinc-500 hover:bg-yellow-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                            GET IN TOUCH
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" stroke="white">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-black mb-4">Local Businesses</h3>
                        <button
                            class="bg-zinc-500 hover:bg-yellow-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                            GET IN TOUCH
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24" stroke="white">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-black mb-4">Short-Term Personal Use</h3>
                        <button
                            class="bg-zinc-500 hover:bg-zinc-600 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                            GET IN TOUCH
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-black text-white py-16 px-4 md:py-24">
        <div class="w-full mx-auto">
            <!-- Header -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start mb-12">
                <div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white">
                        HOW IT <span class="text-yellow-600">WORKS</span>
                    </h2>
                </div>
                <div>
                    <p class="text-gray-300 text-base md:text-lg leading-relaxed">
                        We've made the process simple and hassle-free. First, choose the service or rental option that
                        fits your needs. Next, complete a quick booking form or reach out to us directly. Once
                        confirmed, we'll prepare everything for you so you can get started without delays. From start to
                        finish, our goal is to make your experience smooth, transparent, and convenient.
                    </p>
                </div>
            </div>

            <!-- Steps -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Step 1 -->
                <div
                    class="bg-gradient-to-b from-gray-500 to-gray-500 rounded-2xl p-8 border-b-4 border-yellow-600 flex flex-col items-center text-center min-h-[200px] justify-center">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-6">
                        <span class="text-2xl font-bold text-gray-800">1</span>
                    </div>
                    <h3 class="text-white text-lg md:text-xl font-semibold leading-snug">
                        Apply online (upload license, insurance, Uber/Lyft screenshot)
                    </h3>
                </div>

                <!-- Step 2 -->
                <div
                    class="bg-gradient-to-b from-gray-500 to-gray-500 rounded-2xl p-8 border-b-4 border-yellow-600 flex flex-col items-center text-center min-h-[200px] justify-center">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-6">
                        <span class="text-2xl font-bold text-gray-800">2</span>
                    </div>
                    <h3 class="text-white text-lg md:text-xl font-semibold leading-snug">
                        Get approved (we email you)
                    </h3>
                </div>

                <!-- Step 3 -->
                <div
                    class="bg-gradient-to-b from-gray-500 to-gray-500 rounded-2xl p-8 border-b-4 border-yellow-600 flex flex-col items-center text-center min-h-[200px] justify-center md:col-span-2 lg:col-span-1">
                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-6">
                        <span class="text-2xl font-bold text-gray-800">3</span>
                    </div>
                    <h3 class="text-white text-lg md:text-xl font-semibold leading-snug">
                        Book dates & place refundable deposit hold
                    </h3>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mx-auto px-4 py-16 max-w-7xl">
            <!-- Header Section -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 text-black">WHY CHOOSE B33</h1>
                <p class="text-gray-600 max-w-3xl mx-auto">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper
                    mattis, pulvinar dapibus leo.
                </p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <!-- Left Column - Features -->
                <div class="space-y-12">
                    <!-- Feature 1 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-zinc-500 rounded-lg flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="white" viewBox="0 0 24 24">
                                    <path
                                        d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Rideshare & delivery permitted<br>(with approval)
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Drive with confidence knowing our vehicles can be used for rideshare and delivery
                                platforms, subject to approval.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-zinc-500  rounded-lg flex items-center justify-center">
                                <flux:icon name="shield-check" class="w-7 h-7 text-white" stroke="white" />
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Security deposit is a hold (not a charge)</h3>
                            <p class="text-gray-600 text-sm">
                                Your security deposit is simply a temporary hold placed on your card, not an actual
                                charge.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Center Column - Car Image -->
                <div class="flex justify-center px-4">
                    <img src="https://b33rentals.com/wp-content/uploads/2025/08/imgi_48_6FD42845-3AC2-40CB-AA88-2FAA89C14204-2048x1980-removebg-preview.png"
                        alt="Ford Fusion" class="w-full max-w-lg object-contain drop-shadow-2xl">
                </div>

                <!-- Right Column - Features -->
                <div class="space-y-12">
                    <!-- Feature 3 -->
                    <div class="flex gap-4 flex-row-reverse lg:flex-row">
                        <div class="flex-shrink-0 order-first lg:order-last">
                            <div class="w-12 h-12 bg-zinc-500  rounded-lg flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="white" viewBox="0 0 24 24">
                                    <path
                                        d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <h3 class="text-lg font-semibold mb-2">Fast digital agreement &<br>e-signature</h3>
                            <p class="text-gray-600 text-sm">
                                Skip the paperwork and get on the road faster. Our simple digital agreements with secure
                                e-signature.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="flex gap-4 flex-row-reverse lg:flex-row">
                        <div class="flex-shrink-0 order-first lg:order-last">
                            <div class="w-12 h-12 bg-zinc-500  rounded-lg flex items-center justify-center">
                                <flux:icon name="credit-card" class="w-7 h-7 text-white" stroke="white" />
                            </div>
                        </div>
                        <div class="text-left lg:text-right">
                            <h3 class="text-lg font-semibold mb-2">Card on file for easy tolls/fees processing</h3>
                            <p class="text-gray-600 text-sm">
                                Your card stays on file so tolls and fees are handled quickly and hassle-free.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--slider section-->
    <!-- Start of Testimonials Section -->
    <!-- resources/views/your-view.blade.php -->

    <section class="w-full  relative bg-black/50 text-white py-20">
        <!-- Background image with dark overlay -->
        <div class="absolute inset-0 opacity-20 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        </div>

        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-center mb-16 uppercase tracking-widest text-white">
                TESTIMONIAL
            </h2>

            <!-- Swiper container -->
            <div class="swiper mx-4 testimonial-swiper">
                <div class="swiper-wrapper !pb-8">
                    @foreach ($testimonials as $testimonial)
                        <div class="swiper-slide flex justify-center px-4 sm:px-6 md:px-8">
                            <div class="w-full text-center p-6 bg-black/70 rounded-xl border border-gray-700">
                                <p class="text-sm md:text-base mb-6 text-white">
                                    {{ $testimonial['text'] }}
                                </p>
                                <div class="flex items-center justify-center">
                                    <img src="{{ $testimonial['img'] }}" alt="{{ $testimonial['name'] }}"
                                        class="w-12 h-12 rounded-full border-2 border-white mr-3 object-cover">
                                    <div class="text-left">
                                        <p class="font-semibold text-white">{{ $testimonial['name'] }}</p>
                                        <p class="text-sm text-gray-400">{{ $testimonial['title'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Swiper Navigation & Pagination -->
                <div
                    class="swiper-button-next !w-10 !h-10 xs:w-12! xs:!h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-zinc-400 hover:scale-110 transition-all duration-300">
                    <flux:icon name="arrow-right" class="w-5! !h-5 xs:w-6! xs:!h-6 text-gray-800" />
                </div>
                <div
                    class="swiper-button-prev !w-10 !h-10 xs:w-12! xs:!h-12 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-zinc-400 hover:scale-110 transition-all duration-300">
                    <flux:icon name="arrow-left" class="w-5! !h-5 xs:w-6! xs:!h-6 text-gray-800" />
                </div>
                <div class="swiper-pagination mt-10"></div>
            </div>
        </div>
    </section>
    <!-- End of Testimonials Section -->

    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', function() {
                const swiper = new Swiper('.testimonial-swiper', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        640: {
                            slidesPerView: 1,
                        },
                        768: {
                            slidesPerView: 2,
                        },
                        1024: {
                            slidesPerView: 3,
                        },
                    },
                });

            });
        </script>
    @endpush
</div>
