<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">
    <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
        <div class="mt-4 flex flex-col gap-6">
            <flux:text class="text-center">
                {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
            </flux:text>

            @if (session('status') == 'verification-link-sent')
                <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </flux:text>
            @endif

            <div class="flex flex-col items-center justify-between space-y-3">
                <flux:button wire:click="sendVerification" variant="primary" class="w-full">
                    {{ __('Resend verification email') }}
                </flux:button>

                <flux:link class="text-sm cursor-pointer" wire:click="logout">
                    {{ __('Log out') }}
                </flux:link>
            </div>
        </div>
    </div>
</div>
