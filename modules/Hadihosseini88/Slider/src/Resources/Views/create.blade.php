@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('slides.index') !!}" class="" title="اسلایدر">اسلایدر</a></li>
    <li><a href="{!! route('slides.create') !!}" class="is-active" title="اسلاید جدید">اسلاید جدید</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ایجاد اسلاید جدید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route('slides.store') }}" method="post" class="padding-30" enctype="multipart/form-data">
                    @csrf
                    <input name="title"  type="text" class="text" placeholder="عنوان اسلاید">
                    <select name="status" id="status">
                        <option value="1" selected>فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                    <input name="priority"  type="text" class="text" placeholder="اولویت">
                    <input name="link" type="text" class="text text-left " placeholder="لینک اسلاید">
                    <div class="file-upload">
                        <div class="i-file-upload">
                            <span>آپلود تصویر</span>
                            <input type="file" class="file-upload" name="image"/>
                        </div>
                        <span class="filesize"></span>
                        <span class="selectedFiles">فایلی انتخاب نشده است</span>
                    </div>

                    <button class="btn btn-yeknokte_ir">ایجاد اسلاید</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
