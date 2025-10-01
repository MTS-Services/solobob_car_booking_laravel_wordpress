@props([
    'icon' => null,
    'iconPosition' => 'left',
    'type' => 'button',
    'href' => 'javascript:void(0);',
    'route' => false,
    'target' => '_self',
    'disabled' => false,
    'title' => '',
    'variant' => 'primary',
    'small' => false,
    'class' => '',
])

@php
    // A map of button variants and their Tailwind CSS classes.
    $variants = [
        'primary' => 'bg-accent text-accent-foreground hover:bg-accent/90 focus:ring-accent/50',
        'secondary' =>
            'bg-bg-tertiary-light dark:bg-bg-tertiary-dark text-text-primary-light dark:text-text-primary-dark hover:bg-bg-secondary-light dark:hover:bg-bg-secondary-dark focus:ring-text-primary-light/50 dark:focus:ring-text-primary-dark/50',
        'outline' => 'bg-transparent border border-accent text-accent hover:bg-accent/10 focus:ring-accent/50',
        'dashed' =>
            'bg-transparent border border-dashed border-accent text-accent hover:bg-accent/10 focus:ring-accent/50',
        'link' => 'bg-transparent text-accent p-0 !h-auto !shadow-none !ring-0 hover:bg-transparent focus:ring-0',
    ];

    // Get the classes for the requested variant, with a fallback to 'primary' if it doesn't exist.
$variantClasses = $variants[$variant] ?? $variants['primary'];

// Base classes for all buttons
$baseClasses =
    'inline-flex items-center justify-center px-6 py-2 font-medium rounded shadow-sm hover:shadow-md focus:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200';

// Handle padding and icon positioning
$paddingClasses = 'py-2';
if ($icon) {
    if ($iconPosition === 'left') {
        $paddingClasses = 'pl-3 pr-4';
    } else {
        $paddingClasses = 'pl-4 pr-3';
    }
} else {
    $paddingClasses = 'px-4';
}

if ($small) {
    $baseClasses =
        'inline-flex items-center justify-center font-medium rounded-xl shadow-sm hover:shadow-md focus:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 text-xs py-1.5 px-3';
}

// Combine all classes
$finalClasses = trim("{$baseClasses} {$variantClasses} {$paddingClasses} {$class}");

// Add disabled classes
if ($disabled) {
    $finalClasses .= ' opacity-50 cursor-not-allowed pointer-events-none';
    }

@endphp

@if ($route)
    <a href="{{ $route }}" target="{{ $target }}" title="{{ $title }}" class="{{ $finalClasses }}"
        {{ $disabled ? 'aria-disabled=true tabindex=-1' : '' }} {{ $attributes->except('class') }}>
        @if ($icon && $iconPosition === 'left')
            <flux:icon name="{{ $icon }}" class="w-4 h-4" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon && $iconPosition === 'right')
            <flux:icon name="{{ $icon }}" class="w-4 h-4" />
        @endif
    </a>
@else
    <button type="{{ $type }}" title="{{ $title }}" class="{{ $finalClasses }}"
        {{ $disabled ? 'disabled aria-disabled=true tabindex=-1' : '' }} {{ $attributes->except('class') }}>
        @if ($icon && $iconPosition === 'left')
            <flux:icon name="{{ $icon }}" class="w-4 h-4" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon && $iconPosition === 'right')
            <flux:icon name="{{ $icon }}" class="w-4 h-4" />
        @endif
    </button>
@endif
