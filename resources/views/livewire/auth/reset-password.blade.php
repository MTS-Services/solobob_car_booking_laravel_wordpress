<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">
    <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" wire:submit="resetPassword" class="flex flex-col gap-6">
                <flux:input
                    wire:model="email"
                    :label="__('Email')"
                    type="email"
                    required
                    autocomplete="email"
                />

                <flux:input
                    wire:model="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <flux:input
                    wire:model="password_confirmation"
                    :label="__('Confirm password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm password')"
                    viewable
                />

                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full">
                        {{ __('Reset password') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
