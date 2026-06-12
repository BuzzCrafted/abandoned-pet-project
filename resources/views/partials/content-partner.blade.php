@php
    $is_dark = get_post_meta(get_the_ID(), 'partner_dark_mode', true);
@endphp

<a href="{{ esc_url(get_post_meta(get_the_ID(), 'partner_url', true)) }}" class="block min-h-0" target="_blank"
    rel="noopener noreferrer">
    <div class="flex h-40 md:h-48 w-full items-center justify-center overflow-hidden p-4">
        @if (has_post_thumbnail())
            {!! get_the_post_thumbnail(null, 'full', [
                'class' => 'max-h-full max-w-full object-contain' . ($is_dark ? ' bg-secondary/20 rounded-md p-3' : ''),
            ]) !!}
        @else
            <div class="flex h-full w-full items-center justify-center">
                <span class="text-sm text-secondary">{{ __('No image available', 'abandoned-pet-project') }}</span>
            </div>
        @endif
    </div>
</a>
