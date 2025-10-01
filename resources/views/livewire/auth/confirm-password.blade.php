<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">
    <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
        <div class="flex flex-col gap-6">
            <x-auth-header
                :title="__('Confirm password')"
                :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
            />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" wire:submit="confirmPassword" class="flex flex-col gap-6">
                <flux:input
                    wire:model="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <flux:button variant="primary" type="submit" class="w-full">{{ __('Confirm') }}</flux:button>
            </form>
        </div>
    </div>
</div>
