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

        $dropdownPos = $depth === 0 ? 'left-0 top-full border-t-4 border-t-accent' : 'left-full top-0';
    @endphp

    <li class="{{ $liGroup }}">
        <a href="{{ $item->url }}" @if ($item->target) target="{{ $item->target }}" @endif
            @class([
                'flex items-center uppercase text-sm font-semibold tracking-wide px-5 py-5 transition-colors hover:bg-accent focus:bg-accent focus:outline-none' => $isTopLevel,
                'text-inverse' => $isTopLevel && !$item->active,
                'bg-accent text-inverse' => $isTopLevel && $item->active,
                'block w-full px-4 py-3 text-accent bg-white text-xs font-bold hover:bg-accent hover:text-inverse transition-colors' =>
                    !$isTopLevel && !$item->active,
                'block w-full px-4 py-3 text-xs font-bold bg-accent text-inverse' =>
                    !$isTopLevel && $item->active,
            ])>
            {{ $item->label }}
            @if ($hasChildren && $isTopLevel)
                <svg class="ml-1 h-3 w-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            @endif
        </a>

        @if ($hasChildren)
            <ul
                class="absolute z-50 hidden min-w-[215px] border border-accent bg-white shadow-md {{ $dropdownVis }} {{ $dropdownPos }}">
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
                    'text-xs text-accent bg-white hover:text-inverse pl-6' => $depth > 0,
                ])>
                    <span>{{ $item->label }}</span>
                    <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="open" x-collapse @class([
                    'border-t border-white/10 bg-white' => $depth === 0,
                    'border-t border-accent/20 bg-white/95' => $depth > 0,
                ])>
                    @foreach ($item->children as $child)
                        <x-navigation.item :item="$child" :depth="$depth + 1" variant="mobile" />
                    @endforeach
                </ul>
            </div>
        @else
            <a href="{{ $item->url }}" @if ($item->target) target="{{ $item->target }}" @endif
                @class([
                    'block px-4 py-3 font-semibold uppercase tracking-wide transition-colors hover:bg-accent' => true,
                    'text-sm text-inverse hover:text-inverse' => $depth === 0 && !$item->active,
                    'text-sm bg-accent text-inverse' => $depth === 0 && $item->active,
                    'text-xs text-accent hover:text-inverse pl-6' =>
                        $depth === 1 && !$item->active,
                    'text-xs bg-accent text-inverse pl-6' => $depth === 1 && $item->active,
                    'text-xs text-accent/80 hover:text-inverse pl-10' =>
                        $depth > 1 && !$item->active,
                    'text-xs bg-accent text-inverse pl-10' => $depth > 1 && $item->active,
                ])>
                {{ $item->label }}
            </a>
        @endif
    </li>
@endif
