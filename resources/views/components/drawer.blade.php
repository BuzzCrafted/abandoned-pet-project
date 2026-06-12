    {{-- Mobile drawer panel --}}
    <div id="mobile-nav-drawer" x-show="mobileOpen" x-cloak
        class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto bg-secondary shadow-xl lg:hidden"
        x-transition:enter="transition-transform duration-250 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-200 ease-in"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" @click.outside="closeMobile()">
        {{-- Drawer header --}}
        <div class="flex items-center justify-between border-b border-primary px-4 py-4">
            <span class="text-sm font-semibold uppercase tracking-widest text-soft">
                {{ __('Menu', 'abandoned-pet-project') }}
            </span>
            <button type="button" @click="closeMobile()"
                class="rounded p-1 text-inverse transition-colors hover:bg-primary focus:outline-none focus:bg-primary"
                aria-label="{{ __('Close navigation', 'abandoned-pet-project') }}">
                <x-heroicon-s-x-mark x-show="mobileOpen" x-cloak class="h-5 w-5 aria-hidden:true" />
            </button>
        </div>

        {{-- Mobile navigation --}}
        @if (has_nav_menu('primary_navigation'))
            <x-navigation name="primary_navigation" variant="mobile" />
        @endif
    </div>
