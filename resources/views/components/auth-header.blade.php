@props([
    'title',
    'description',
    
])

<div class="flex w-full flex-col text-center ">
    <flux:heading size="xl" class="text-gray-500">{{ $title }}</flux:heading>
    <flux:subheading class="text-gray-500">{{ $description }}</flux:subheading>
</div>
