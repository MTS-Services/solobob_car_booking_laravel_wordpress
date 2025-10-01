<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">
    <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" wire:submit="register" class="flex flex-col gap-6">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
                    :placeholder="__('Full name')" />

                <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
                    placeholder="email@example.com" />

                <flux:input wire:model="password" :label="__('Password')" type="password" required
                    autocomplete="new-password" :placeholder="__('Password')" viewable />

                <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
                    autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

                <div class="flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="w-full">
                        {{ __('Create account') }}
                    </flux:button>
                </div>
            </form>

            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Already have an account?') }}</span>
                <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
            </div>
        </div>
    </div>
</div>
