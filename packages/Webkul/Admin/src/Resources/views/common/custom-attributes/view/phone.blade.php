@if (is_array($value))

    @foreach ($value as $key => $item)
        <span class="multi-value">
            <a id="js-phonelink<?=$key?>"
               href="https://t.me/+{{ $item['value'] }}"
               target="_blank">+{{ $item['value'] }}</a>
             &nbsp;
            <i
                class="icon email-blue-icon btn-clipboard"
                data-clipboard-target="#js-phonelink<?=$key?>"
                style="cursor:pointer"
            ></i>
        </span>
    @endforeach

@else

    {{ __('admin::app.common.not-available') }}

@endif
