<header class="banner" x-data="siteHeader()" x-init="init()" @scroll.window.throttle.50ms="onScroll()"
    @keydown.escape.window="closeMobile()">
    {{-- Top bar: centered logo --}}
    <div class=bg-inverse">
        <div class="mx-auto flex max-w-7xl items-center justify-center px-4">
            @if (has_custom_logo())
                <a href="{{ home_url('/') }}" rel="home" class="block h-20 w-20">
                    {!! wp_get_attachment_image(get_theme_mod('custom_logo'), 'full', false, [
                        'class' => 'h-full w-auto object-contain',
                    ]) !!}
                </a>
            @else
                <a href="{{ home_url('/') }}" rel="home" class="text-xl font-bold text-primary">
                    {!! get_bloginfo('name') !!}
                </a>
            @endif
        </div>
    </div>


    <div class="bg-surface transition-shadow duration-200 flex justify-center items-center mx-auto">
        <div class="flex px-4 md:px-0 items-center justify-between gap-x-6 max-w-7xl w-full">
            <div class="md:mx-auto flex items-center justify-between px-4 lg:justify-start lg:px-0">

                {{-- Desktop navigation (hidden on mobile) --}}
                @if (has_nav_menu('primary_navigation'))
                    <x-navigation name="primary_navigation" variant="desktop" />
                @endif

                {{-- Spacer so hamburger aligns right on mobile --}}
                <div class="flex-1 lg:hidden"></div>

                {{-- Hamburger button (hidden on desktop) --}}
                <button type="button"
                    class="lg:hidden inline-flex items-center justify-center p-4 text-inverse transition-colors hover:bg-primary focus:outline-none focus:bg-primary"
                    :aria-expanded="mobileOpen" aria-controls="mobile-nav-drawer"
                    aria-label="{{ __('Toggle navigation', 'abandoned-pet-project') }}" @click="toggleMobile()">
                    {{-- Hamburger icon → X icon --}}

                    <x-heroicon-s-bars-3 x-show="!mobileOpen" class="h-6 w-6" />
                    <x-heroicon-s-x-mark x-show="mobileOpen" x-cloak class="h-6 w-6" />
                </button>
            </div>
            <div class="flex items-center gap-x-4">
                <x-search />
                <a href="{{ home_url('/donate-here') }}" class="relative w-16">
                    <x-heroicon-s-shopping-bag
                        class="h-auto w-full border-inverse border-l-2 border-r-2 text-inverse bg-primary p-4" />
                </a>
            </div>
        </div>
    </div>


    {{-- Mobile drawer backdrop --}}
    <div x-show="mobileOpen" x-cloak @click="closeMobile()" class="fixed inset-0 z-40 bg-secondary/30 lg:hidden"
        aria-hidden="true" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- Mobile drawer panel --}}
    <x-drawer />
</header>
