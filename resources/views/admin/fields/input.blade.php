<input
    type="{{ $field['type'] }}"
    id="meta-{{ $field['key'] }}"
    name="{{ $field['key'] }}"
    value="{{ $field['value'] }}"
    class="regular-text"
    @if (! empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
    @if (! empty($field['min'])) min="{{ $field['min'] }}" @endif
    @if (! empty($field['max'])) max="{{ $field['max'] }}" @endif
    @if (! empty($field['step'])) step="{{ $field['step'] }}" @endif
>
