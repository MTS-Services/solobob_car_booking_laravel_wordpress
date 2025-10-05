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
    'mobileColumns' => 2,
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

    {{-- DESKTOP TABLE (md and above) --}}
    <div class="hidden md:block">
        <div class="min-w-full inline-block align-middle">
            {{-- Table Header --}}
            <div
                class="flex bg-gray-50 text-xs font-semibold uppercase tracking-wider text-gray-500 rounded-t-lg border-b border-gray-200">
                @if ($showRowNumber)
                    <div class="p-3 text-center flex-shrink-0" style="width: 60px;">
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
                    <div class="p-3 text-center flex-shrink-0" style="width: 100px;">
                        Actions
                    </div>
                @endif
            </div>

            {{-- Table Body --}}
            @forelse ($data as $item)
                @php
                    $rowNumber = method_exists($data, 'firstItem')
                        ? $data->firstItem() + $loop->index
                        : $loop->iteration;
                @endphp
                <div wire:key="row-{{ $item->id ?? $loop->index }}"
                    class="flex text-sm border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out">
                    @if ($showRowNumber)
                        <div class="p-3 text-center flex-shrink-0" style="width: 60px;">
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
                        <div class="p-3 text-center flex-shrink-0" style="width: 100px;">
                            <div class="relative inline-block text-left">
                                <div x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="flex items-center justify-center gap-2 text-sm font-medium hover:rotate-90 transition-all duration-300 ease-linear group mx-auto">
                                        <flux:icon icon="cog-6-tooth"
                                            class="w-6 h-6 group-hover:stroke-accent transition-all duration-300 ease-linear" />
                                    </button>

                                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute z-10 mt-2 min-w-32 w-fit max-w-52 origin-top-right right-0 rounded-md shadow-lg text-center"
                                        @click.outside="open = false">
                                        <div class="rounded-md bg-white shadow-xs">
                                            <div class="py-1">
                                                @foreach ($actions as $action)
                                                    @if (isset($action['href']) && $action['href'] != null && $action['href'] != '#')
                                                        @php
                                                            $param =
                                                                (isset($action['param']) && $action['param']
                                                                    ? $action['param']
                                                                    : $action['key']) ?? '';
                                                            $actionValue = data_get($item, $param);
                                                            $actionParam = is_numeric($actionValue)
                                                                ? $actionValue
                                                                : "'{$actionValue}'";
                                                            $href = empty($actionParam)
                                                                ? $action['href']
                                                                : "{$action['href']}/{$actionParam}";
                                                        @endphp
                                                        <a href="{{ $href }}" title="{{ $action['label'] }}"
                                                            target="{{ $action['target'] ?? '_self' }}"
                                                            class="block px-4 py-2 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                            wire:navigate>
                                                            {{ $action['label'] }}
                                                        </a>
                                                    @elseif (isset($action['route']) && $action['route'] != null && $action['route'] != '#')
                                                        @php
                                                            $param =
                                                                (isset($action['param']) && $action['param']
                                                                    ? $action['param']
                                                                    : $action['key']) ?? '';
                                                            $actionValue = data_get($item, $param);
                                                            $actionParam = is_numeric($actionValue)
                                                                ? $actionValue
                                                                : "'{$actionValue}'";
                                                        @endphp
                                                        <a href="{{ route($action['route'], $actionParam) }}"
                                                            title="{{ $action['label'] }}"
                                                            target="{{ $action['target'] ?? '_self' }}"
                                                            class="block px-4 py-2 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                            wire:navigate>
                                                            {{ $action['label'] }}
                                                        </a>
                                                    @elseif(isset($action['method']) && $action['method'] != null)
                                                        @php
                                                            $actionValue = data_get(
                                                                $item,
                                                                (isset($action['param']) && $action['param']
                                                                    ? $action['param']
                                                                    : $action['key']) ?? 'id',
                                                            );
                                                            $actionParam = is_numeric($actionValue)
                                                                ? $actionValue
                                                                : "'{$actionValue}'";
                                                        @endphp
                                                        <button type="button"
                                                            wire:click="{{ $action['method'] }}({{ $actionParam }})"
                                                            class="block px-4 py-2 w-full text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                            @click="open = false">
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
    </div>

    {{-- MOBILE CARDS (below md) --}}
    <div class="block md:hidden space-y-4">
        @forelse ($data as $item)
            @php
                $rowNumber = method_exists($data, 'firstItem') ? $data->firstItem() + $loop->index : $loop->iteration;
                $visibleColumns = array_slice($columns, 0, $mobileColumns);
                $hiddenColumns = array_slice($columns, $mobileColumns);
            @endphp
            <div wire:key="mobile-row-{{ $item->id ?? $loop->index }}"
                class="shadow border border-gray-200 rounded-lg p-4  hover:shadow-md transition-shadow duration-200"
                x-data="{ expanded: false }">

                {{-- Row Number Badge --}}
                @if ($showRowNumber)
                    <div class="flex items-start justify-between pb-3">
                        <div class="flex flex-col h-full">
                            <span class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                No.
                            </span>
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 text-sm font-semibold">
                                {{ $rowNumber }}
                            </span>
                        </div>

                        @foreach ($visibleColumns as $column)
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                    {{ $column['label'] }}
                                </span>
                                <span class="text-sm text-gray-900">
                                    @if (isset($column['format']) && is_callable($column['format']))
                                        {!! $column['format']($item) !!}
                                    @else
                                        {{ Str::limit(data_get($item, $column['key']) ?? '-', 20) }}
                                    @endif
                                </span>
                            </div>
                        @endforeach

                        {{-- Actions Button --}}
                        @if (count($actions) > 0)
                            <div class="relative inline-block text-left">
                                <div x-data="{ open: false }">
                                    <button type="button" @click="open = !open"
                                        class="flex items-center justify-center gap-2 text-sm font-medium hover:rotate-90 transition-all duration-300 ease-linear group mx-auto">
                                        <flux:icon icon="cog-6-tooth"
                                            class="w-6 h-6 group-hover:stroke-accent transition-all duration-300 ease-linear" />
                                    </button>

                                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute z-10 mt-2 min-w-32 w-fit max-w-52 origin-top-right right-0 rounded-md shadow-lg text-center bg-white"
                                        @click.outside="open = false">
                                        <div class="py-1">
                                            @foreach ($actions as $action)
                                                @if (isset($action['href']) && $action['href'] != null && $action['href'] != '#')
                                                    @php
                                                        $param =
                                                            (isset($action['param']) && $action['param']
                                                                ? $action['param']
                                                                : $action['key']) ?? '';
                                                        $actionValue = data_get($item, $param);
                                                        $actionParam = is_numeric($actionValue)
                                                            ? $actionValue
                                                            : "'{$actionValue}'";
                                                        $href = empty($actionParam)
                                                            ? $action['href']
                                                            : "{$action['href']}/{$actionParam}";
                                                    @endphp

                                                    <a href="{{ $href }}" title="{{ $action['label'] }}"
                                                        target="{{ $action['target'] ?? '_self' }}"
                                                        class="block px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                                        wire:navigate>
                                                        {{ $action['label'] }}
                                                    </a>
                                                @elseif (isset($action['route']) && $action['route'] != null && $action['route'] != '#')
                                                    @php
                                                        $param =
                                                            (isset($action['param']) && $action['param']
                                                                ? $action['param']
                                                                : $action['key']) ?? '';
                                                        $actionValue = data_get($item, $param);
                                                        $actionParam = is_numeric($actionValue)
                                                            ? $actionValue
                                                            : "'{$actionValue}'";
                                                    @endphp
                                                    <a href="{{ route($action['route'], $actionParam) }}"
                                                        title="{{ $action['label'] }}"
                                                        target="{{ $action['target'] ?? '_self' }}"
                                                        class="block px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
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
                                                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100"
                                                        @click="open = false">
                                                        {{ $action['label'] }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Visible Columns --}}
                {{-- <div class="space-y-2">
                    @foreach ($visibleColumns as $column)
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                {{ $column['label'] }}
                            </span>
                            <span class="text-sm text-gray-900">
                                @if (isset($column['format']) && is_callable($column['format']))
                                    {!! $column['format']($item) !!}
                                @else
                                    {{ data_get($item, $column['key']) ?? '-' }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div> --}}

                {{-- Hidden Columns (Expandable) --}}
                @if (count($hiddenColumns) > 0)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <button type="button" @click="expanded = !expanded"
                            class="flex items-center justify-between w-full text-sm font-medium text-gray-600 hover:text-gray-900">
                            <span x-text="expanded ? 'Show Less' : 'Show More'">Show More</span>
                            <flux:icon icon="chevron-down" class="w-4 h-4 transition-transform duration-200"
                                x-bind:class="expanded && 'rotate-180'" />
                        </button>

                        <div x-show="expanded" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2" class="mt-3 space-y-2">
                            @foreach ($hiddenColumns as $column)
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-gray-500 uppercase mb-1">
                                        {{ $column['label'] }}
                                    </span>
                                    <span class="text-sm text-gray-900">
                                        @if (isset($column['format']) && is_callable($column['format']))
                                            {!! $column['format']($item) !!}
                                        @else
                                            {{ data_get($item, $column['key']) ?? '-' }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-10 text-gray-500">
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
