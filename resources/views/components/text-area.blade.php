<textarea placeholder="{{ $placeholder }}" class="text h" name="{{ $name }}">{!! old($name) !!}</textarea>
<x-validation-error field="{{ $name }}" />
