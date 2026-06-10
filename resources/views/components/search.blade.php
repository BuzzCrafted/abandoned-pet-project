<div x-data="{ open: false }">
    <span class="text-inverse hover:text-primary transition-colors cursor-pointer" @click="open = true">
        <x-heroicon-s-magnifying-glass class="h-6 w-6" />
    </span>

    <div x-show="open" class="absolute top-0 left-0 mt-2 w-full min-h-37 bg-inverse p-4 rounded shadow-lg z-10"
        x-transition:enter="transition ease-out duration-800" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2">
        <div class="flex items-center justify-center mb-4">
            <x-heroicon-s-x-mark class="h-10 w-10 cursor-pointer" @click="open = false" />
        </div>
        <form method="get" action="{{ home_url('/') }}" x-ref="searchForm"
            class="flex items-center  border-b border-b-soft rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            <label for="search" class="block w-full">
                <span class="sr-only">Search for:</span>
                <input type="search" id="search" class="w-full focus:outline-none " placeholder="Search"
                    name="s">
            </label>
            <x-heroicon-s-magnifying-glass @click="$refs.searchForm.submit()" class="h-6 w-6 cursor-pointer" />
        </form>

    </div>
</div>
