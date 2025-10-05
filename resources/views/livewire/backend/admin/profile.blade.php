<section class="container mx-auto mt-5">
    <div>

        <div class="grid    lg:grid-cols-3 gap-5">

            <div class="flex flex-col  h-auto shadow rounded-xl p-6">

                <h1 class="text-xl text-bg-black  font-bold ">Profile Image</h1>
                <div class="w-28 h-28 rounded-full mx-auto mt-10 border-4 border-black overflow-hidden">
                    <img src="{{ asset('assets/images/default/other.png') }}" alt="Profile Image"
                        class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col items-center justify-between ">
                    <h1 class="text-2xl font-bold text-center top-7">Super Admin</h1>
                    <h1 class="">Administrator</h1>
                </div>
            </div>

            <div class="bg-white shadow rounded-xl p-6 col-span-1 lg:col-span-2 ">
                <h2 class="text-lg font-semibold mb-6">Profile Information</h2>

                <div class="grid md:grid-cols-2 gap-6 text-sm">

                    <div class="space-y-6">

                        <div class="flex items-start space-x-2">
                            <span class="text-gray-500">👤</span>
                            <div>
                                <p class="text-gray-500">Full Name</p>
                                <p class="font-medium">Super Admin</p>
                            </div>
                        </div>


                        <div class="flex items-start space-x-2">
                            <span class="text-gray-500">📧</span>
                            <div>
                                <p class="text-gray-500">Email Address</p>
                                <p class="font-medium">superadmin@dev.com</p>
                            </div>
                        </div>


                        <div class="flex items-start space-x-2">
                            <span class="text-gray-500">🟢</span>
                            <div>
                                <p class="text-gray-500">Account Status</p>
                                <span
                         class="px-3 py-1  mt-4 rounded-full text-xs bg-green-100 text-green-600 font-semibold hover:bg-green-200 hover:text-green-800 transition">
                      Active
                           </span>

                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">

                        <div class="flex items-start space-x-2">
                            <span class="text-gray-500">📅</span>
                            <div>
                                <p class="text-gray-500">Member Since</p>
                                <p class="font-medium">Sep 28, 2025</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-2">
                            <span class="text-gray-500">📝</span>
                            <div>
                                <p class="text-gray-500">Last Updated</p>
                                <p class="font-medium">Oct 02, 2025 at 01:27 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
