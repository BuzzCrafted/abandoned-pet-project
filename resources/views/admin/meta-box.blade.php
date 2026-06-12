<input type="hidden" name="post_meta_{{ $postType }}_nonce" value="{{ $nonce }}">

<table class="form-table" role="presentation">
    <tbody>
        @foreach ($fields as $field)
            <tr>
                <th scope="row">
                    <label for="meta-{{ $field['key'] }}">{{ $field['label'] }}</label>
                </th>
                <td>
                    @switch($field['type'])
                        @case('textarea')
                            @include('admin.fields.textarea', ['field' => $field])
                            @break

                        @case('checkbox')
                            @include('admin.fields.checkbox', ['field' => $field])
                            @break

                        @case('select')
                            @include('admin.fields.select', ['field' => $field])
                            @break

                        @default
                            @include('admin.fields.input', ['field' => $field])
                    @endswitch

                    @if (! empty($field['help']))
                        <p class="description">{{ $field['help'] }}</p>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
