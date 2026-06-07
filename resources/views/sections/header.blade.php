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


    <div class="bg-primary transition-shadow duration-200">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 lg:justify-start lg:px-0">

            {{-- Desktop navigation (hidden on mobile) --}}
            @if (has_nav_menu('primary_navigation'))
                <x-navigation name="primary_navigation" variant="desktop" />
            @endif

            {{-- Spacer so hamburger aligns right on mobile --}}
            <div class="flex-1 lg:hidden"></div>

            {{-- Hamburger button (hidden on desktop) --}}
            <button type="button"
                class="lg:hidden inline-flex items-center justify-center p-4 text-inverse transition-colors hover:bg-accent focus:outline-none focus:bg-accent"
                :aria-expanded="mobileOpen" aria-controls="mobile-nav-drawer"
                aria-label="{{ __('Toggle navigation', 'sage') }}" @click="toggleMobile()">
                {{-- Hamburger icon → X icon --}}
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Spacer to prevent layout jump when nav bar becomes fixed --}}
    <div x-show="isSticky" x-cloak class="h-14.5 lg:hidden" aria-hidden="true"></div>
    <div x-show="isSticky" x-cloak class="hidden lg:block h-14.5" aria-hidden="true"></div>

    {{-- Mobile drawer backdrop --}}
    <div x-show="mobileOpen" x-cloak @click="closeMobile()" class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        aria-hidden="true" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    {{-- Mobile drawer panel --}}
    <div id="mobile-nav-drawer" x-show="mobileOpen" x-cloak
        class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-primary shadow-xl lg:hidden"
        x-transition:enter="transition-transform duration-250 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        @click.outside="closeMobile()">
        {{-- Drawer header --}}
        <div class="flex items-center justify-between border-b border-white/20 px-4 py-4">
            <span class="text-sm font-semibold uppercase tracking-widest text-inverse/70">
                {{ __('Menu', 'sage') }}
            </span>
            <button type="button" @click="closeMobile()"
                class="rounded p-1 text-inverse transition-colors hover:bg-inverse/10 focus:outline-none focus:bg-inverse/10"
                aria-label="{{ __('Close navigation', 'sage') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Mobile navigation --}}
        @if (has_nav_menu('primary_navigation'))
            <x-navigation name="primary_navigation" variant="mobile" />
        @endif
    </div>
</header>
