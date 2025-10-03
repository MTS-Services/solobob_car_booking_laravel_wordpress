<div class="container mx-auto p-6 space-y-6">
    <!-- Basic Information Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Basic Information</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- First Name -->
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                    First Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="first_name" 
                    name="first_name" 
                    value="Coby"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter First Name"
                >
            </div>

            <!-- Last Name -->
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Last Name
                </label>
                <input 
                    type="text" 
                    id="last_name" 
                    name="last_name" 
                    value="Pollard"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter Last Name"
                >
            </div>

            <!-- User Name -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    User Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="username" 
                    name="username" 
                    value="qapupuru@mailinator.com"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter User Name"
                >
            </div>
        </div>

        <!-- Phone Number -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="phone_number" 
                    name="phone_number" 
                    value="93"
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter Phone Number"
                >
            </div>
        </div>
    </div>

    <!-- Address Information Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Address Information</h2>
        
        <!-- Address -->
        <div class="mb-6">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                Address
            </label>
            <textarea 
                id="address" 
                name="address" 
                rows="4"
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition resize-none"
                placeholder="Enter Address"
            ></textarea>
        </div>

        <!-- State, City, ZIP Code -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- State -->
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                    State
                </label>
                <input 
                    type="text" 
                    id="state" 
                    name="state" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter State"
                >
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    City
                </label>
                <input 
                    type="text" 
                    id="city" 
                    name="city" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter City"
                >
            </div>

            <!-- ZIP Code -->
            <div>
                <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">
                    ZIP Code
                </label>
                <input 
                    type="text" 
                    id="zip_code" 
                    name="zip_code" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-zinc-500 focus:border-transparent outline-none transition"
                    placeholder="Enter ZIP Code"
                >
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button 
            type="submit"
            class="px-8 py-3 bg-zinc-500 hover:bg-cyzincan-600 text-white font-medium rounded-lg transition duration-200 shadow-sm"
        >
            Save Changes
        </button>
    </div>
</div>
