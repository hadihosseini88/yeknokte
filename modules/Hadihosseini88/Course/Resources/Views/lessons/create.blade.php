@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('courses.index') !!}" title="دوره ها">دوره ها</a></li>
    <li><a href="{!! route('courses.details', $course) !!}" title="جزئیات">جزئیات</a></li>
    <li><a href="#" class="is-active" title="ایجاد درس جدید">ایجاد درس جدید</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ایجاد درس جدید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{route('courses.store')}}" class="padding-30" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input type="text" name="title" placeholder="عنوان درس"
                             class="margin-top-0" required></x-input>

                    <x-input type="text" name="slug" placeholder="نام انگلیسی درس اختیاری" class="text-left"
                             required></x-input>

                    <x-select name="season_id" required>
                        <option value="">انتخاب سرفصل</option>
                        @foreach($seasons as $season)
                            <option value="{{$season->id}}"
                                    @if($season->id == old('season_id')) selected @endif>{{$season->title}}</option>
                        @endforeach
                    </x-select>

                    <div class="w-50">
                    <p class="box__title">ایا این درس رایگان است ؟ </p>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-1" name="free" value="0" type="radio" checked="">
                            <label for="lesson-upload-field-1">خیر</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-2" name="free" value="1" type="radio">
                            <label for="lesson-upload-field-2">بله</label>
                        </div>
                    </div>
                    <br>

                    <x-file name="lesson_file" textSpan="آپلود درس" required></x-file>

                    <x-textarea placeholder="توضیحات درس" name="body"></x-textarea>

                    <br>
                    <br>

                    <button class="btn btn-yeknokte_ir">ایجاد درس</button>
                </form>
            </div>
        </div>
    </div>
@endsection

