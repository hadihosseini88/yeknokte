<input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
       {{ $attributes->merge(['class' => 'text']) }} value="{{old($name)}}">
<x-validation-error field="{{ $name }}"/>

