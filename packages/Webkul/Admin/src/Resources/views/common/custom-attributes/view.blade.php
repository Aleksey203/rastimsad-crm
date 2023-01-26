@foreach ($customAttributes as $attribute)

    @if (view()->exists($typeView = 'admin::common.custom-attributes.view.' . $attribute->type) &&
           !in_array($attribute->name, ['Менеджер', 'Планируем завершить']) &&
           isset($entity) && !is_null($entity[$attribute->code]))

        <div class="attribute-value-row">
            <div class="label">{{ $attribute->name }}</div>

            <div class="value" v-pre>
                @include ($typeView, ['value' => isset($entity) ? $entity[$attribute->code] : null])
            </div>
        </div>

    @endif

@endforeach
