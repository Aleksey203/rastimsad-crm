@if (is_array($value))

    @foreach ($value as $key => $item)
        <span class="multi-value">
            <span id="js-emaillink<?=$key?>">{{ $item['value'] }}</span>
             &nbsp;
            <i
                class="icon email-blue-icon btn-clipboard"
                data-clipboard-target="#js-emaillink<?=$key?>"
                style="cursor:pointer"
            ></i>
        </span>
    @endforeach

@else

    {{ __('admin::app.common.not-available') }}

@endif
