@props([
    'columns' => [],
    'data' => [],
    'actions' => [],
    'searchProperty' => 'search',
    'showSearch' => true,
    'perPageProperty' => 'perPage',
    'showPerPage' => true,
    'perPageOptions' => [5, 10, 15, 20, 50, 100],
    'emptyMessage' => 'No records found.',
    'class' => '',
    'showRowNumber' => true,
])

<div class="glass-card rounded-2xl p-6 mb-6 {{ $class }}">

    {{-- HEADER --}}
    <div class="flex flex-col xs:flex-row items-center justify-between gap-4 mb-4">

        @if ($showPerPage)
            @php
                $currentPerPage = method_exists($data, 'perPage') ? $data->perPage() : 10;
            @endphp
            <div x-data="{ open: false, selectedPerPage: {{ $currentPerPage }} }" class="relative py-2">
                <button type="button" @click="open = !open"
                    class="flex items-center gap-1 text-gray-700 hover:text-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-500 rounded-md p-1">
                    PerPage: <span x-text="selectedPerPage"></span>
                    <flux:icon icon="chevron-down" class="w-4 h-4 transition-transform duration-200"
                        x-bind:class="open && 'rotate-180'" />
                </button>

                <div x-show="open" x-cloak @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-10 top-full left-0 mt-1 bg-white shadow-lg rounded-md w-max min-w-[5rem] border border-gray-100 origin-top-left">
                    <ul class="flex flex-col gap-1 w-full text-center py-1">
                        @foreach ($perPageOptions as $option)
                            <li class="px-4 py-1 cursor-pointer text-gray-600 hover:bg-zinc-50 hover:text-zinc-600 font-medium"
                                @click="open = false; selectedPerPage = {{ $option }}"
                                wire:click="$set('{{ $perPageProperty }}', {{ $option }})">
                                {{ $option }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if ($showSearch)
            <div class="relative w-full sm:max-w-xs">
                <x-input wire:model.live.debounce.500ms="{{ $searchProperty }}" type="text" placeholder="Search..."
                    class="w-full" />
            </div>
        @endif
    </div>

    <hr class="mb-4">

    {{-- TABLE --}}
    <div class="min-w-full inline-block align-middle">
        {{-- Table Header --}}
        <div
            class="flex bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500 rounded-t-lg border-b border-gray-200 flex-wrap">
            @if ($showRowNumber)
                <div class="p-3 text-center" style="flex-shrink: 0;">
                    No.
                </div>
            @endif
            @foreach ($columns as $column)
                <div class="p-3 text-left flex-1"
                    style="flex-basis: {{ $column['width'] ?? 100 / count($columns) . '%' }}">
                    {{ $column['label'] }}
                </div>
            @endforeach
            @if (count($actions) > 0)
                <div class="p-3 text-center" style="flex-shrink: 0;">
                    Actions
                </div>
            @endif
        </div>

        {{-- Table Body --}}
        @forelse ($data as $item)
            @php
                $rowNumber = method_exists($data, 'firstItem') ? $data->firstItem() + $loop->index : $loop->iteration;
            @endphp
            <div wire:key="row-{{ $item->id ?? $loop->index }}"
                class="flex text-sm border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out">
                @if ($showRowNumber)
                    <div class="p-3 text-center" style="flex-shrink: 0;">
                        {{ $rowNumber }}
                    </div>
                @endif
                @foreach ($columns as $column)
                    <div class="p-3 text-left flex-1 break-words"
                        style="flex-basis: {{ $column['width'] ?? 100 / count($columns) . '%' }}">
                        @if (isset($column['format']) && is_callable($column['format']))
                            {!! $column['format']($item) !!}
                        @else
                            {{ data_get($item, $column['key']) }}
                        @endif
                    </div>
                @endforeach

                @if (count($actions) > 0)
                    {{-- Dropdown style like popover --}}
                    <div class="p-3 text-center" style="flex-shrink: 0;">
                        <div class="relative inline-block text-left">
                            <div x-data="{ open: false }">
                                <button type="button" @click="open = !open"
                                    class="flex items-center justify-center gap-2 text-sm font-medium hover:rotate-90 transition-all duration-300 ease-linear group">
                                    <flux:icon icon="cog-6-tooth"
                                        class="w-6 h-6 group-hover:stroke-accent transition-all duration-300 ease-linear" />
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute z-10 mt-2 min-w-32 w-fit max-w-52 origin-top-left right-0 rounded-md shadow-lg text-center">
                                    <div class="rounded-md bg-white shadow-xs" @click.outside="open = false">
                                        <div class="py-1">
                                            @foreach ($actions as $action)
                                                @if (isset($action['href']) && $action['href'] != null && $action['href'] != '#')
                                                    <a href="{{ $action['href'] }}" title="{{ $action['label'] }}"
                                                        target="{{ $action['target'] ?? '_self' }}"
                                                        class="block px-4 py-2 w-full text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                        wire:navigate>
                                                        {{ $action['label'] }}
                                                    </a>
                                                @elseif(isset($action['method']) && $action['method'] != null)
                                                    @php
                                                        $actionValue = data_get($item, $action['key'] ?? 'id');
                                                        $actionParam = is_numeric($actionValue)
                                                            ? $actionValue
                                                            : "'{$actionValue}'";
                                                    @endphp
                                                    <button type="button"
                                                        wire:click="{{ $action['method'] }}({{ $actionParam }})"
                                                        class="block px-4 py-2 w-full text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                        @click="open = false">
                                                        {{ $action['label'] }}
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="block px-4 py-2 text-sm w-full text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                        wire:navigate>
                                                        {{ $action['label'] }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-10 text-gray-500 text-lg">
                {{ $emptyMessage }}
            </div>
        @endforelse
    </div>

    <hr class="mt-4">

    {{-- PAGINATION --}}
    @if (method_exists($data, 'links'))
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    @endif
</div>
