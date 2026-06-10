@props(['item', 'depth' => 0, 'variant' => 'desktop'])

@php
    $hasChildren = !empty($item->children);
    $isTopLevel = $depth === 0;
@endphp

@if ($variant === 'desktop')
    @php
        /**
         * Named groups scope hover to each depth level independently.
         * Without named groups, hovering a depth-0 item triggers group-hover:block
         * on all descendant submenus simultaneously.
         *
         * depth 0 → group/nav  | child ul → group-hover/nav:block
         * depth 1 → group/sub  | child ul → group-hover/sub:block
         * depth 2 → group/leaf | child ul → group-hover/leaf:block
         */
        if ($hasChildren && $depth === 0) {
            $liGroup = 'group/nav relative flex items-stretch';
            $dropdownVis = 'group-hover/nav:block group-focus-within/nav:block';
        } elseif ($hasChildren && $depth === 1) {
            $liGroup = 'group/sub relative';
            $dropdownVis = 'group-hover/sub:block group-focus-within/sub:block';
        } elseif ($hasChildren) {
            $liGroup = 'group/leaf relative';
            $dropdownVis = 'group-hover/leaf:block group-focus-within/leaf:block';
        } else {
            $liGroup = $isTopLevel ? 'flex items-stretch' : '';
            $dropdownVis = '';
        }

        $dropdownPos = $depth === 0 ? 'left-0 top-14 border-t-4 border-t-accent' : 'left-full top-0';
    @endphp

    <li class="{{ $liGroup }}">
        <a href="{{ $item->url }}" @if ($item->target) target="{{ $item->target }}" @endif
            @class([
                'flex items-center uppercase text-sm font-semibold tracking-wide px-5 py-5 transition-colors hover:bg-primary focus:bg-primary focus:outline-none' => $isTopLevel,
                'text-inverse' => $isTopLevel && !$item->active,
                'text-primary hover:text-inverse uppercase' => $isTopLevel && $item->active,
                'inline-flex w-full justify-between uppercase bg-inverse px-4 py-3 text-xs font-bold text-primary transition-colors hover:text-accent' =>
                    !$isTopLevel && !$item->active,
                'inline-flex w-full px-4 py-3 text-xs uppercase font-bold bg-primary text-inverse' =>
                    !$isTopLevel && $item->active,
            ])>
            {{ $item->label }}
            @if ($hasChildren && $isTopLevel)
                <x-heroicon-s-chevron-down class='ml-1 h-4 w-4 shrink-0' />
            @elseif ($hasChildren)
                <x-heroicon-s-chevron-right class='ml-1 h-4 w-4 shrink-0' />
            @endif
        </a>

        @if ($hasChildren)
            <ul
                class="absolute z-50 hidden min-w-53.75  border-t-primary bg-inverse shadow-md {{ $dropdownVis }} {{ $dropdownPos }}">
                @foreach ($item->children as $child)
                    <x-navigation.item :item="$child" :depth="$depth + 1" variant="desktop" />
                @endforeach
            </ul>
        @endif
    </li>
@else
    {{-- Mobile variant --}}
    <li class="border-b border-white/10 last:border-0">
        @if ($hasChildren)
            <div x-data="{ open: false }">
                <button type="button" @click="open = !open" :aria-expanded="open" @class([
                    'flex w-full items-center justify-between px-4 py-3 text-left font-semibold uppercase tracking-wide transition-colors hover:bg-accent' => true,
                    'text-sm text-inverse' => $depth === 0,
                    'text-xs text-primary bg-inverse hover:text-accent pl-6' => $depth > 0,
                ])>
                    <span>{{ $item->label }}</span>
                    <x-heroicon-s-chevron-down class='h-4 w-4 shrink-0 transition-transform duration-200'
                        x-bind:class="{ 'rotate-180': open }" />
                </button>
                <ul x-show="open" x-collapse @class([
                    'border-t border-soft/10 bg-inverse' => $depth === 0,
                    'border-t border-primary/20 bg-inverse/95' => $depth > 0,
                ])>
                    @foreach ($item->children as $child)
                        <x-navigation.item :item="$child" :depth="$depth + 1" variant="mobile" />
                    @endforeach
                </ul>
            </div>
        @else
            <a href="{{ $item->url }}" @if ($item->target) target="{{ $item->target }}" @endif
                @class([
                    'block px-4 py-3 font-semibold uppercase tracking-wide transition-colors hover:bg-primary' => true,
                    'text-sm text-inverse hover:text-inverse' => $depth === 0 && !$item->active,
                    'text-sm bg-primary text-inverse' => $depth === 0 && $item->active,
                    'text-xs text-primary hover:text-inverse pl-6' =>
                        $depth === 1 && !$item->active,
                    'text-xs bg-primary text-inverse pl-6' => $depth === 1 && $item->active,
                    'text-xs text-primary/80 hover:text-inverse pl-10' =>
                        $depth > 1 && !$item->active,
                    'text-xs bg-primary text-inverse pl-10' => $depth > 1 && $item->active,
                ])>
                {{ $item->label }}
            </a>
        @endif
    </li>
@endif
