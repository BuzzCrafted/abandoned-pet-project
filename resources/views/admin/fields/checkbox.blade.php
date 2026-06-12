<label>
    <input
        type="checkbox"
        id="meta-{{ $field['key'] }}"
        name="{{ $field['key'] }}"
        value="1"
        @if ($field['value'] === '1') checked @endif
    >
    @if (! empty($field['checkbox_label'])) {{ $field['checkbox_label'] }} @endif
</label>
