{{-- Change Password Blade Template with Alpine.js --}}

<div class="min-h-[calc(70vh-3.5rem)] bg-gray-50 p-8" x-data="passwordForm()">
    <div class="max-w-4xl mx-auto"
     x-data="{ 
         showCurrentPassword: false, 
         showNewPassword: false, 
         showConfirmPassword: false, 
         password: '', 
         password_confirmation: '' 
     }">

    <form wire:submit.prevent="updatePassword">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Change Password</h2>

            {{-- Current Password --}}
            <div class="mb-6">
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input :type="showCurrentPassword ? 'text' : 'password'" id="current_password"
                        wire:model.defer="current_password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition-all pr-12 @error('current_password') border-red-500 @enderror"
                        placeholder="Enter current password" required>

                    <button type="button" @click="showCurrentPassword = !showCurrentPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                        <flux:icon name="eye" class="w-5 h-5" x-show="!showCurrentPassword"/>
                        <flux:icon name="eye-slash" class="w-5 h-5" x-show="showCurrentPassword"/>
                    </button>
                </div>
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input :type="showNewPassword ? 'text' : 'password'" id="password"
                        x-model="password" wire:model.defer="password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition-all pr-12 @error('password') border-red-500 @enderror"
                        placeholder="Enter new password" required>

                    <button type="button" @click="showNewPassword = !showNewPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                        <flux:icon name="eye" class="w-5 h-5" x-show="!showNewPassword"/>
                        <flux:icon name="eye-slash" class="w-5 h-5" x-show="showNewPassword"/>
                    </button>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    Password must be at least 8 characters long
                </p>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                        x-model="password_confirmation" wire:model.defer="password_confirmation"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 outline-none transition-all pr-12 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Confirm new password" required>

                    <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                        <flux:icon name="eye" class="w-5 h-5" x-show="!showConfirmPassword"/>
                        <flux:icon name="eye-slash" class="w-5 h-5" x-show="showConfirmPassword"/>
                    </button>
                </div>

                {{-- Password match feedback --}}
                <template x-if="password_confirmation.length > 0">
                    <p class="mt-2 text-sm"
                       :class="password === password_confirmation ? 'text-green-600' : 'text-red-600'">
                        <span x-text="password === password_confirmation 
                            ? '✅ Passwords match' 
                            : '❌ Passwords do not match'"></span>
                    </p>
                </template>

                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-yellow-600 hover:bg-yellow-700 text-white font-medium px-8 py-2.5 rounded-md transition-colors duration-200 shadow-sm">
                Change Password
            </button>
        </div>
    </form>
</div>


    {{-- Success Message --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Alpine.js Component --}}
    <script>
        function passwordForm() {
            return {
                showCurrentPassword: false,
                showNewPassword: false,
                showConfirmPassword: false
            }
        }
    </script>
</div>
