<textarea
    id="meta-{{ $field['key'] }}"
    name="{{ $field['key'] }}"
    class="large-text"
    rows="{{ $field['rows'] ?? 4 }}"
    @if (! empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
>{{ $field['value'] }}</textarea>
