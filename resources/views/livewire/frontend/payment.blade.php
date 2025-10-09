 <div>

     <div class="bg-gradient-to-b from-[#fff8f3] to-[#fff1e6] min-h-screen  flex flex-col items-center justify-center">
         <!-- Header -->
         <div class="text-center mb-10">
             <div class="flex justify-center mb-3">
                 <div class="bg-[#bb8106] p-3 rounded-full">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="white" class="size-6 text-white">
                         <path stroke-linecap="round" stroke-linejoin="round"
                             d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                     </svg>

                 </div>
             </div>
             <h1 class="text-3xl font-bold text-gray-800">Choose Your Payment Method</h1>
             <p class="text-gray-500 mt-2">Select your preferred payment gateway to complete your transaction securely
                 and efficiently.</p>
         </div>

         <!-- Payment Options -->
         <div class="w-full max-w-6xl space-y-6">

             <!-- PayPal -->
             <label
                 class="block bg-white shadow-sm rounded-2xl p-6 border border-gray-200 cursor-pointer 
           hover:border-orange-400  transition duration-500 ease-in-out text-white   transform hover:-translate-y-1 hover:scale-2.5">
                 <div class="flex items-center">

                     <input type="radio" name="payments" value="paypal" wire:model="paymentGateway"
                         class="radio bg-white border-zinc-300 checked:bg-white checked:text-zinc-600 checked:border-zinc-600 checked:before:bg-zinc-600" />

                     <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"
                         class="h-8 ml-4">
                     <div class="ml-4">
                         <h3 class="text-lg font-semibold text-gray-800">PayPal</h3>
                         <p class="text-gray-500 text-sm">Pay securely with your PayPal account or credit card.</p>
                     </div>
                     <div class="ml-auto space-x-2">
                         <span
                             class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">Secure</span>
                         <span
                             class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full">Global</span>
                     </div>
                 </div>

                 <div class="mt-4 flex flex-wrap gap-2 text-xs text-gray-600">
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                             <path
                                 d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                         </svg> <span>Buyer Protection</span>
                     </span>
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                             <path
                                 d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                         </svg> <span>No account required</span>
                     </span>
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                             <path
                                 d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                         </svg> <span>24/7 Support</span>
                     </span>
                 </div>
             </label>

             <!-- Stripe -->
             {{-- <label
                 class="block bg-bg-white shadow-sm rounded-2xl p-6 border border-gray-200 cursor-pointer hover:border-orange-400 transition delay-150 duration-300 ease-in-out">
                 <div class="flex items-center">
                     <input type="radio" name="payments" value="paypal" wire:model="paymentGateway"
                         class="radio bg-white border-zinc-300 checked:bg-white checked:text-zinc-600 checked:border-zinc-600 checked:before:bg-zinc-600" />

                     <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg"
                         alt="Stripe" class="h-8 ml-4">
                     <div class="ml-4">
                         <h3 class="text-lg font-semibold text-gray-800">Stripe</h3>
                         <p class="text-gray-500 text-sm">Supports all major credit cards & digital wallets.</p>
                     </div>
                     <div class="ml-auto space-x-2">
                         <span
                             class="bg-purple-100 text-purple-700 text-xs font-medium px-2 py-1 rounded-full">Advanced</span>
                         <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full">Fast</span>
                     </div>
                 </div>

                 <div class="mt-4 flex flex-wrap gap-2 text-xs text-gray-600">
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                             <path
                                 d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                         </svg>
                         <span>SSL Encrypted</span>
                     </span>
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                             <path
                                 d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                         </svg> <span>Apple Pay & Google Pay</span>
                     </span>
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                             <path
                                 d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                         </svg> <span>PCI Compliant</span>
                     </span>
                 </div>
             </label> --}}
             <label
                 class="block bg-white shadow-sm rounded-2xl p-6 border border-gray-200 cursor-pointer 
           hover:border-orange-400  transition duration-500 ease-in-out text-white   transform hover:-translate-y-1 hover:scale-2.5">
                 <div class="flex items-center ">
                     <input type="radio" name="payments" value="paypal" wire:model="paymentGateway"
                         class="radio bg-white border-zinc-300 checked:bg-white checked:text-zinc-600 checked:border-zinc-600 checked:before:bg-zinc-600" />

                     <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg"
                         alt="Stripe" class="h-8 ml-4">
                     <div class="ml-4">
                         <h3 class="text-lg font-semibold text-gray-800">Stripe</h3>
                         <p class="text-gray-500 text-sm">Supports all major credit cards & digital wallets.</p>
                     </div>

                     <div class="ml-auto space-x-2">
                         <span
                             class="bg-purple-100 text-purple-700 text-xs font-medium px-2 py-1 rounded-full">Advanced</span>
                         <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full">Fast</span>
                     </div>

                 </div>

                 <div class="mt-4 flex flex-wrap gap-2 text-xs text-gray-600">
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="size-4">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                         </svg>
                         <span>SSL Encrypted</span>
                     </span>
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="size-4">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                         </svg>
                         <span>Apple Pay & Google Pay</span>
                     </span>
                     <span class="bg-gray-100 px-2 py-1 rounded-md flex items-center space-x-1">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="size-4">
                             <path fill-rule="evenodd"
                                 d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                 clip-rule="evenodd" />
                         </svg>
                         <span>PCI Compliant</span>
                     </span>
                 </div>
             </label>

         </div>

         <!-- Button -->
         <div class="mt-10">
             <button
                 class="bg-[#bb8106] hover:bg-[#dcb65a] text-white font-semibold px-8 py-3 rounded-xl shadow-md transition">
                 Continue to Payment →
             </button>
         </div>
     </div>
 </div>
