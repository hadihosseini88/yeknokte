<div class="file-upload">
    <div class="i-file-upload">
        <span>{{ $textSpan }}</span>
        <input type="file" class="file-upload" id="files" name="{{ $name }}" {{ $attributes }}/>
    </div>
    <span class="filesize"></span>
    @if($value)
        <span class="selectedFiles"><img src="{{$value->thumb}}" alt="{{ $name }}"></span>
    @else
        <span class="selectedFiles">فایلی انتخاب نشده است.</span>
    @endif


</div>
<x-validation-error field="{{ $name }}" />
