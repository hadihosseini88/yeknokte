<input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
       value="{{old($name)}}" {{ $attributes->merge(['class' => 'text']) }}>
<x-validation-error field="{{ $name }}"/>

