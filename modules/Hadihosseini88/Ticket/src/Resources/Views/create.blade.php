@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('tickets.index') !!}" title="تیکت ها">تیکت ها</a></li>
    <li><a href="{!! route('tickets.create') !!}" class="is-active" title="ارسال تیکت جدید">ارسال تیکت جدید</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ایجاد تیکت جدید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="" class="padding-30">
                    <x-input name="title" type="text"  placeholder="عنوان تیکت" required></x-input>
                    <x-textarea name="body" placeholder="متن تیکت" required ></x-textarea>
                    <x-file name="attachment" textSpan="آپلود فایل" placeholder="آپلود فایل پیوست"></x-file>
                    <button class="btn btn-yeknokte_ir">ارسال تیکت</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
