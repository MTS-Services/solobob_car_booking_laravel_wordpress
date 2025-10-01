<main class="flex min-h-screen items-center justify-center p-8 bg-accent-foreground transition-colors duration-300">
    <div class="max-w-4xl w-full flex flex-col md:flex-row items-center justify-between gap-12 text-center md:text-left">

        {{-- Left Section: Marketing Content --}}
        <div class="md:w-1/2 space-y-6">
            <flux:heading level="1" size="3xl" class="font-bold tracking-tight text-text-primary-light dark:text-text-primary-dark">
                Simplify Your Workflow, <br class="max-md:hidden">Boost Your Productivity
            </flux:heading>
            <flux:heading level="2" size="lg" class="text-text-secondary-light dark:text-text-secondary-dark font-medium">
                Our platform provides powerful tools designed to streamline your projects and elevate your team's efficiency.
            </flux:heading>
            <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-4">
                <a href="{{ route('register') }}" wire:navigate>
                    <flux:button icon="arrow-right">Get Started Today</flux:button>
                </a>
                <a href="{{ route('login') }}" wire:navigate>
                    <flux:button variant="ghost">Log In</flux:button>
                </a>
            </div>
        </div>

        {{-- Right Section: Visual Mockup --}}
        <div class="md:w-1/2 flex justify-center p-4">
            {{-- This is a placeholder for an image or a product screenshot --}}
            <img src="https://placehold.co/600x400/F5F5F5/4B4B4B?text=Product+Mockup"
                 alt="Product Mockup"
                 class="rounded-lg shadow-xl border border-zinc-200 dark:border-zinc-700 w-full max-w-xl transition-shadow duration-300">
        </div>

    </div>

    
</main>
