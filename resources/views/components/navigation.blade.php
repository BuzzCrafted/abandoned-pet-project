@props(['name' => 'primary_navigation', 'variant' => 'desktop'])

@php($menu = Navi::build($name))

@if ($menu->isNotEmpty())
  @if ($variant === 'desktop')
    <nav
      aria-label="{{ wp_get_nav_menu_name($name) ?: __('Primary Navigation', 'sage') }}"
      class="hidden lg:flex"
    >
      <ul class="flex items-stretch">
        @foreach ($menu->all() as $item)
          <x-navigation.item :item="$item" :depth="0" variant="desktop" />
        @endforeach
      </ul>
    </nav>

  @else
    <nav
      aria-label="{{ wp_get_nav_menu_name($name) ?: __('Primary Navigation', 'sage') }}"
    >
      <ul class="bg-primary">
        @foreach ($menu->all() as $item)
          <x-navigation.item :item="$item" :depth="0" variant="mobile" />
        @endforeach
      </ul>
    </nav>
  @endif
@endif
