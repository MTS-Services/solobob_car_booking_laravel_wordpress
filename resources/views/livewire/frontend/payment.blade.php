{{-- <div class="bg-gray-100 absolute w-full mx-auto oiverflow-hidden "> --}}

{{-- <div class="bg-gray-100 min-h-screen flex items-center justify-center p-4 w-full">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-xl overflow-hidden">

            <div class="bg-gradient-to-r from-[#bb8106] to-[#bb8106] px-8 py-8 text-center text-white">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <i class="fas fa-credit-card text-2xl"></i>
                    <h1 class="text-2xl font-bold text-white">Secure Payment</h1>
                </div>
                <p class="text-orange-50">Complete your transaction safely and securely</p>
            </div>

            <div class="px-8 py-6">

                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">Total Payment: $1000.00</h2>
                    <p class="text-gray-600">Credits to receive: 1000.00</p>
                </div>

                <form class="space-y-5">

                    <div>
                        <label class="flex items-center gap-2 text-xl font-medium text-gray-700 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-6">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                    clip-rule="evenodd" />
                            </svg>

                            Full Name
                        </label>
                        <input type="text" placeholder="Enter your full name"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#dcb65a] focus:border-transparent transition">
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="flex items-center gap-2 text-xl font-medium text-gray-700 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path
                                        d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                    <path
                                        d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                </svg>

                                Email Address
                            </label>
                            <input type="email" placeholder="your@email.com"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#dcb65a] focus:border-transparent transition">
                        </div>


                        <div>
                            <label class="flex items-center gap-2  font-medium text-xl text-gray-700 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path fill-rule="evenodd"
                                        d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z"
                                        clip-rule="evenodd" />
                                </svg>

                                Phone (Optional)
                            </label>
                            <input type="tel" placeholder="+1 (555) 123-4567"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#dcb65a] focus:border-transparent transition">
                        </div>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                        <div class="flex items-center gap-2 text-[#dcb65a] font-medium mb-4">
                            Payment Information
                        </div>

                        <div class="relative">
                            <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-6">
                                    <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                                    <path fill-rule="evenodd"
                                        d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <input type="text" placeholder="Card number"
                                    class="flex-1 outline-none text-gray-700">
                                <button type="button"
                                    class="bg-gray-900 text-white px-3 py-1 rounded text-sm font-medium hover:bg-gray-800 transition">
                                    Autofill <span class="text-green-400">link</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#bb8106] to-[#bb8106] text-white font-semibold py-4 rounded-lg hover:from-[#dcb65a] hover:to-[#dcb65a] transition shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2">
                        <i class="fas fa-lock"></i>
                        Complete Secure Payment
                    </button>

                    <div class="flex items-center justify-center gap-4 py-3">
                        <img src="{{ asset('assets/images/Visa_Inc._logo.svg') }}" alt="Visa"
                            class="h-8 opacity-60">
                        <img src="{{ asset('assets/images/Mastercard-logo.svg') }}" alt="Mastercard"
                            class="h-8 opacity-60">
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
                        <i class="fas fa-shield-alt text-green-600 mt-0.5"></i>
                        <p class="text-sm text-green-700 leading-relaxed text-center">
                            Your payment information is encrypted and secure. We never store your card details.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden w-1/3 absolute right-0 top-0 lg:flex items-center justify-center overflow-hidden h-full z-0">
        <img src="http://localhost:8000/assets/images/hero-aside.png" alt="City Skyline Illustration"
            class="w-full h-full object-cover">
    </div> --}}
{{-- 
</div>
</div> --}}


<div>
    <div class="flex flex-1">
        <aside
            wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;Mg4bsXMiiHBmOci9m1jo&quot;,&quot;name&quot;:&quot;partials.frontend.sidebar&quot;,&quot;path&quot;:&quot;login&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;acf978ddb7e33f5046db57db106ce9366186ac8abccd69335baff2f001ee6ea7&quot;}"
            wire:effects="[]" wire:id="Mg4bsXMiiHBmOci9m1jo">
            <!--[if BLOCK]><![endif]--> <ui-sidebar-toggle
                class="z-20 fixed inset-0 bg-black/10 hidden data-flux-sidebar-on-mobile:not-data-flux-sidebar-collapsed-mobile:block"
                data-flux-sidebar-backdrop="" data-flux-sidebar-on-desktop=""></ui-sidebar-toggle>
            <!--[if ENDBLOCK]><![endif]-->

            <ui-sidebar
                class="[grid-area:sidebar] z-1 flex flex-col gap-4 [:where(&amp;)]:w-64 p-4 data-flux-sidebar-collapsed-desktop:w-14 data-flux-sidebar-collapsed-desktop:px-2 data-flux-sidebar-collapsed-desktop:cursor-e-resize rtl:data-flux-sidebar-collapsed-desktop:cursor-w-resize max-lg:data-flux-sidebar-cloak:hidden data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:-translate-x-full data-flux-sidebar-on-mobile:data-flux-sidebar-collapsed-mobile:rtl:translate-x-full z-20! data-flux-sidebar-on-mobile:start-0! data-flux-sidebar-on-mobile:fixed! data-flux-sidebar-on-mobile:top-0! data-flux-sidebar-on-mobile:min-h-dvh! data-flux-sidebar-on-mobile:max-h-dvh! max-h-dvh overflow-y-auto overscroll-contain lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700 transition-transform"
                x-init="$el.classList.add('transition-transform')" collapsible="mobile" stashable="" sticky="" x-data=""
                data-flux-sidebar="" style="position: sticky; top: 0px; max-height: calc(0px + 100dvh);"
                data-flux-sidebar-on-desktop="">
                <button type="button"
                    class="relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none h-10 text-sm rounded-lg w-10 inline-flex  bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white      shrink-0 lg:hidden"
                    data-flux-button="data-flux-button" x-data=""
                    x-on:click="$dispatch('flux-sidebar-toggle')" aria-label="Toggle sidebar"
                    data-flux-sidebar-toggle="data-flux-sidebar-toggle">
                    <svg class="shrink-0 [:where(&amp;)]:size-5" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path
                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z">
                        </path>
                    </svg>
                </button>
                <a href="http://localhost:8000" class="h-10 flex items-center me-4 gap-2 px-2 dark:hidden"
                    data-flux-brand="">
                    <div class="flex items-center justify-center h-6 rounded-sm overflow-hidden shrink-0">
                        <img src="https://fluxui.dev/img/demo/logo.png" alt="" class="h-6">
                    </div>

                    <div
                        class="text-sm font-medium truncate [:where(&amp;)]:text-zinc-800 dark:[:where(&amp;)]:text-zinc-100">
                        Acme Inc.</div>
                </a>
                <a href="http://localhost:8000" class="h-10 flex items-center me-4 gap-2 px-2 hidden dark:flex"
                    data-flux-brand="">
                    <div class="flex items-center justify-center h-6 rounded-sm overflow-hidden shrink-0">
                        <img src="https://fluxui.dev/img/demo/dark-mode-logo.png" alt="" class="h-6">
                    </div>

                    <div
                        class="text-sm font-medium truncate [:where(&amp;)]:text-zinc-800 dark:[:where(&amp;)]:text-zinc-100">
                        Acme Inc.</div>
                </a>

                <nav class="flex flex-col overflow-visible min-h-auto" data-flux-navlist="">
                    <a href="http://localhost:8000"
                        class="h-10 lg:h-8 relative flex items-center gap-3 rounded-lg  py-0 text-start w-full px-3 my-px text-zinc-500 dark:text-white/80 data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content) data-current:bg-white dark:data-current:bg-white/[7%] data-current:border data-current:border-zinc-200 dark:data-current:border-transparent hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5  border border-transparent"
                        data-flux-navlist-item="data-flux-navlist-item" wire:navigate="">
                        <div class="relative">
                            <svg class="shrink-0 [:where(&amp;)]:size-6 size-4!" data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25">
                                </path>
                            </svg>


                        </div>

                        <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap [[data-nav-footer]_&amp;]:hidden [[data-nav-sidebar]_[data-nav-footer]_&amp;]:block"
                            data-content="">Home</div>
                    </a>
                </nav>

                <div class="flex-1" data-flux-spacer=""></div>

                <ui-radio-group class="block flex p-1 rounded-lg bg-zinc-800/5 dark:bg-white/10 h-10 p-1"
                    x-data="" x-model="$flux.appearance" data-flux-radio-group-segmented=""
                    role="radiogroup">
                    <ui-radio
                        class="flex whitespace-nowrap flex-1 justify-center items-center gap-2 rounded-md data-checked:shadow-xs text-sm font-medium text-zinc-600 hover:text-zinc-800 dark:hover:text-white dark:text-white/70 data-checked:text-zinc-800 dark:data-checked:text-white data-checked:bg-white dark:data-checked:bg-white/20 [&amp;[disabled]]:opacity-50 dark:[&amp;[disabled]]:opacity-75 [&amp;[disabled]]:cursor-default [&amp;[disabled]]:pointer-events-none px-4"
                        value="light" data-flux-control="" data-flux-radio-segmented="" tabindex="-1"
                        aria-checked="false" role="radio">
                        <svg class="shrink-0 [:where(&amp;)]:size-5 text-zinc-500 dark:text-zinc-400 [ui-radio[data-checked]_&amp;]:text-zinc-800 dark:[ui-radio[data-checked]_&amp;]:text-white"
                            data-flux-icon="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path
                                d="M10 2a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 2ZM10 15a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0v-1.5A.75.75 0 0 1 10 15ZM10 7a3 3 0 1 0 0 6 3 3 0 0 0 0-6ZM15.657 5.404a.75.75 0 1 0-1.06-1.06l-1.061 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM6.464 14.596a.75.75 0 1 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06ZM18 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 18 10ZM5 10a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5A.75.75 0 0 1 5 10ZM14.596 15.657a.75.75 0 0 0 1.06-1.06l-1.06-1.061a.75.75 0 1 0-1.06 1.06l1.06 1.06ZM5.404 6.464a.75.75 0 0 0 1.06-1.06l-1.06-1.06a.75.75 0 1 0-1.061 1.06l1.06 1.06Z">
                            </path>
                        </svg>




                    </ui-radio>
                    <ui-radio
                        class="flex whitespace-nowrap flex-1 justify-center items-center gap-2 rounded-md data-checked:shadow-xs text-sm font-medium text-zinc-600 hover:text-zinc-800 dark:hover:text-white dark:text-white/70 data-checked:text-zinc-800 dark:data-checked:text-white data-checked:bg-white dark:data-checked:bg-white/20 [&amp;[disabled]]:opacity-50 dark:[&amp;[disabled]]:opacity-75 [&amp;[disabled]]:cursor-default [&amp;[disabled]]:pointer-events-none px-4"
                        value="dark" data-flux-control="" data-flux-radio-segmented="" tabindex="-1"
                        aria-checked="false" role="radio">
                        <svg class="shrink-0 [:where(&amp;)]:size-5 text-zinc-500 dark:text-zinc-400 [ui-radio[data-checked]_&amp;]:text-zinc-800 dark:[ui-radio[data-checked]_&amp;]:text-white"
                            data-flux-icon="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M7.455 2.004a.75.75 0 0 1 .26.77 7 7 0 0 0 9.958 7.967.75.75 0 0 1 1.067.853A8.5 8.5 0 1 1 6.647 1.921a.75.75 0 0 1 .808.083Z"
                                clip-rule="evenodd"></path>
                        </svg>




                    </ui-radio>
                    <ui-radio
                        class="flex whitespace-nowrap flex-1 justify-center items-center gap-2 rounded-md data-checked:shadow-xs text-sm font-medium text-zinc-600 hover:text-zinc-800 dark:hover:text-white dark:text-white/70 data-checked:text-zinc-800 dark:data-checked:text-white data-checked:bg-white dark:data-checked:bg-white/20 [&amp;[disabled]]:opacity-50 dark:[&amp;[disabled]]:opacity-75 [&amp;[disabled]]:cursor-default [&amp;[disabled]]:pointer-events-none px-4"
                        value="system" data-flux-control="" data-flux-radio-segmented="" tabindex="0"
                        aria-checked="true" role="radio" data-checked="" data-active="">
                        <svg class="shrink-0 [:where(&amp;)]:size-5 text-zinc-500 dark:text-zinc-400 [ui-radio[data-checked]_&amp;]:text-zinc-800 dark:[ui-radio[data-checked]_&amp;]:text-white"
                            data-flux-icon="" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M2 4.25A2.25 2.25 0 0 1 4.25 2h11.5A2.25 2.25 0 0 1 18 4.25v8.5A2.25 2.25 0 0 1 15.75 15h-3.105a3.501 3.501 0 0 0 1.1 1.677A.75.75 0 0 1 13.26 18H6.74a.75.75 0 0 1-.484-1.323A3.501 3.501 0 0 0 7.355 15H4.25A2.25 2.25 0 0 1 2 12.75v-8.5Zm1.5 0a.75.75 0 0 1 .75-.75h11.5a.75.75 0 0 1 .75.75v7.5a.75.75 0 0 1-.75.75H4.25a.75.75 0 0 1-.75-.75v-7.5Z"
                                clip-rule="evenodd"></path>
                        </svg>




                    </ui-radio>
                </ui-radio-group>

                <!--[if BLOCK]><![endif]-->
                <nav class="flex flex-col overflow-visible min-h-auto" data-flux-navlist="">
                    <a href="http://localhost:8000/login"
                        class="h-10 lg:h-8 relative flex items-center gap-3 rounded-lg  py-0 text-start w-full px-3 my-px text-zinc-500 dark:text-white/80 data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content) data-current:bg-white dark:data-current:bg-white/[7%] data-current:border data-current:border-zinc-200 dark:data-current:border-transparent hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5  border border-transparent"
                        data-flux-navlist-item="data-flux-navlist-item" wire:navigate="">
                        <div class="relative">
                            <svg class="shrink-0 [:where(&amp;)]:size-6 size-4!" data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true" data-slot="icon">
                                <path d="m10 17 5-5-5-5"></path>
                                <path d="M15 12H3"></path>
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            </svg>

                        </div>

                        <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap [[data-nav-footer]_&amp;]:hidden [[data-nav-sidebar]_[data-nav-footer]_&amp;]:block"
                            data-content="">Login</div>
                    </a>
                    <a href="http://localhost:8000/register"
                        class="h-10 lg:h-8 relative flex items-center gap-3 rounded-lg  py-0 text-start w-full px-3 my-px text-zinc-500 dark:text-white/80 data-current:text-(--color-accent-content) hover:data-current:text-(--color-accent-content) data-current:bg-white dark:data-current:bg-white/[7%] data-current:border data-current:border-zinc-200 dark:data-current:border-transparent hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5  border border-transparent"
                        data-flux-navlist-item="data-flux-navlist-item" wire:navigate="">
                        <div class="relative">
                            <svg class="shrink-0 [:where(&amp;)]:size-6 size-4!" data-flux-icon=""
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true" data-slot="icon">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="19" x2="19" y1="8" y2="14"></line>
                                <line x1="22" x2="16" y1="11" y2="11"></line>
                            </svg>

                        </div>

                        <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap [[data-nav-footer]_&amp;]:hidden [[data-nav-sidebar]_[data-nav-footer]_&amp;]:block"
                            data-content="">Register</div>
                    </a>
                </nav>
                <!--[if ENDBLOCK]><![endif]-->
            </ui-sidebar>
        </aside>
        <main class="flex-grow bg-white">
            <div wire:snapshot="{&quot;data&quot;:{&quot;email&quot;:&quot;&quot;,&quot;password&quot;:&quot;&quot;,&quot;remember&quot;:false},&quot;memo&quot;:{&quot;id&quot;:&quot;vbwNLpwJdO1vccY1TGm1&quot;,&quot;name&quot;:&quot;auth.login&quot;,&quot;path&quot;:&quot;login&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;fae2f57e115ff36c633a33d61e1f19d8c54f97b1ae3e188c3aafbd432058fafe&quot;}"
                wire:effects="[]" wire:id="vbwNLpwJdO1vccY1TGm1"
                class="flex items-center justify-center min-h-screen p-4 sm:p-0">

                <div class="bg-gray-100 max-w-7xl mx-auto rounded-lg overflow-hidden shadow-2xl border-4 ">
                    <div class="flex flex-col md:flex-row">
                        <!-- Left Side - Car Image -->
                        <div class="w-full md:w-1/2 relative h-64 md:h-auto">

                            <div
                                class="bg-gradient-to-r rounded-t-xl from-[#bb8106] to-[#bb8106] px-8 py-8 text-center text-white">
                                <h1 class="text-gray-100 text-3xl font-bold">Secure Payment</h1>
                                <p class="text-gray-100 text-1xl font-medium">Complete your transaction safely and
                                    securely</p>
                            </div>

                            <div>
                                <h1 class="text-3xl font-bold p-2">Total Payment:$1000.00</h1>
                                <p class="text-gray-600 p-3 font-semibold">Recently Days: 7 Day</p>
                                <p class="text-gray-600 p-3 font-semibold">Rental Car: 2020 Nissan Rogue</p>
                                <p class="flex text-gray-600 p-3  font-semibold">Images: <img
                                        src="https://default.houzez.co/wp-content/uploads/2020/03/placeholder.png"
                                        alt="Card" class="p-2 h-20 w-30 opacity-60"></p>
                            </div>

                        </div>

                        <!-- Right Side - Login Form -->
                        <div class="w-full md:w-1/2 bg-white p-8 md:p-10">
                            <div class="max-w-md mx-auto">
                                <h1 class="text-3xl md:text-2xl font-semibold mb-2">Payment Information</h1>

                                <form method="POST" wire:submit="login" class="grid gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Card Holder
                                            Name</label>
                                        <input wire:model="name" type="name" placeholder="enter your Name"
                                            required="" autofocus="" autocomplete="name"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                                    </div>
                                    <!-- Name Input -->

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                                        <!-- Email Input -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input wire:model="email" type="email" placeholder="enter your email"
                                                required="" autofocus="" autocomplete="email"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                            <input wire:model="phone" type="phone" placeholder="phone number"
                                                required="" autocomplete="current-phone"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">

                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                        <input wire:model="cardnumber" type="cardnumber" placeholder="card number"
                                            required="" autocomplete="cardnumber"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- <div>
                                            <label for="expirationdate">Expire Date (mm/yy)</label>
                                            <input wire:model="birthday" type="date" placeholder="card number"
                                                required="" autocomplete="expirationdate"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                                        </div> --}}

                                        <div>
                                            <label class="form-label">Expire Date</label>
                                            <span class="expiration flex">
                                                <input type="text" name="month"
                                                    class="w-[30%] px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent"
                                                    placeholder="MM" maxlength="2" required>

                                                <span></span>

                                                <input type="text" name="year"
                                                    class="w-[30%] px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent"
                                                    placeholder="YY" maxlength="2" required>
                                            </span>
                                        </div>

                                        <div>
                                            <label for="securitycode">CVC/CVV</label>
                                            <input type="securitycode" type="text" placeholder="security code"
                                                required="" autocomplete="securitycode"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#B79347] focus:border-transparent">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </main>
    </div>
</div>
