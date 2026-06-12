<select
    id="meta-{{ $field['key'] }}"
    name="{{ $field['key'] }}"
>
    @if (! empty($field['placeholder']))
        <option value="">{{ $field['placeholder'] }}</option>
    @endif

    @foreach ($field['options'] ?? [] as $optValue => $optLabel)
        <option value="{{ $optValue }}" @if ($field['value'] === (string) $optValue) selected @endif>
            {{ $optLabel }}
        </option>
    @endforeach
</select>
