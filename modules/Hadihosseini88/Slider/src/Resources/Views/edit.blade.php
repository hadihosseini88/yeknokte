@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('slides.index') !!}" class="" title="اسلایدر">اسلایدر</a></li>
    <li><a href="{!! route('slides.edit', $slide->id) !!}" class="is-active" title="ویرایش اسلاید">ویرایش اسلاید</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ویرایش اسلاید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route('slides.update', $slide->id) }}" method="post" class="padding-30" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input name="title" value="{{ $slide->title }}" type="text" class="text" placeholder="عنوان اسلاید">
                    <select name="status" id="status">
                        <option value="1" {{ $slide->status == 1 ? 'selected' : '' }} >فعال</option>
                        <option value="0" {{ $slide->status == 0 ? 'selected' : '' }} >غیرفعال</option>
                    </select>
                    <input name="priority" value="{{ $slide->priority }}"  type="text" class="text" placeholder="اولویت">
                    <input name="link" value="{{ $slide->link }}" type="text" class="text text-left " placeholder="لینک اسلاید">
                    <img style="margin-top: 15px" class="img__slideshow" src="{{ $slide->media->thumb }}"
                         alt="{{$slide->title}}">
                    <div class="file-upload">
                        <div class="i-file-upload">
                            <span>آپلود تصویر</span>
                            <input type="file" class="file-upload" name="image"/>
                        </div>
                        <span class="filesize"></span>
                        <span class="selectedFiles">فایلی انتخاب نشده است</span>
                    </div>

                    <button class="btn btn-yeknokte_ir">ویرایش اسلاید</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
