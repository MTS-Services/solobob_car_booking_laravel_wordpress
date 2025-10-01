<flux:header container class="bg-zinc-50 dark:bg-zinc-950/40 border-b border-zinc-200 dark:border-zinc-700">

    <style>
        [data-current] {
            color: red !important;
        }
    </style>

    <flux:sidebar.toggle class="lg:hidden" icon="bars-4" inset="left" />
    <flux:brand href="{{ route('home') }}" wire:navigate logo="{{ asset('assets/images/logo.png') }}"
        name="{{ config('app.name') }}" class="max-lg:hidden dark:hidden" />
    <flux:brand href="{{ route('home') }}" wire:navigate logo="{{ asset('assets/images/logo.png') }}"
        name="{{ config('app.name') }}" class="max-lg:hidden! hidden dark:flex" />
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" href="{{ route('home') }}" wire:navigate>
            Home
        </flux:navbar.item>
        <flux:navbar.item icon="rectangle-group" href="{{ route('buttons') }}" wire:navigate>
            Buttons
        </flux:navbar.item>
    </flux:navbar>
    <flux:spacer />
    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="me-4 hidden lg:flex">
        <flux:radio value="light" icon="sun">Light</flux:radio>
        <flux:radio value="dark" icon="moon">Dark</flux:radio>
        <flux:radio value="system" icon="computer-desktop">System</flux:radio>
    </flux:radio.group>
    @auth
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
            <flux:menu>
                @if (auth()->user()->is_admin)
                    <flux:menu.item icon="layout-dashboard" href="{{ route('admin.dashboard') }}" wire:navigate>Admin
                        Dashboard
                    </flux:menu.item>
                    <flux:menu.separator />
                @endif
                <flux:menu.item icon="user-circle">Profile</flux:menu.item>
                <flux:menu.item icon="envelope">Messages</flux:menu.item>
                <flux:menu.item icon="wrench-screwdriver">Settings</flux:menu.item>
                <flux:menu.item icon="credit-card">Billing</flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @else
        <flux:navbar class="me-4">
            <flux:navbar.item icon="log-in" href="{{ route('login') }}" wire:navigate>Login</flux:navbar.item>
            <flux:separator vertical variant="subtle" class="my-2" />
            <flux:navbar.item icon="user-plus" href="{{ route('register') }}" wire:navigate>Register</flux:navbar.item>
        </flux:navbar>
    @endauth

</flux:header>
