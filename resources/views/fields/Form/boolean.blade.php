<label>
    <span class="label">{{ $field->label }}</span>&nbsp;
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <input @if (($data->{$field->name} ?? null )==true) checked @endif name="{{ $field->name }}" class="uk-checkbox" type="checkbox">
</label>