@if (is_array($value))

    @foreach ($value as $item)
        <span class="multi-value">
            <a href="https://t.me/+{{ $item['value'] }}">{{ $item['value'] }}</a>

<!--<span>{{--{{ ' (' . $item['label'] . ')'}}--}}</span>-->
        </span>
    @endforeach

@else

    {{ __('admin::app.common.not-available') }}

@endif
