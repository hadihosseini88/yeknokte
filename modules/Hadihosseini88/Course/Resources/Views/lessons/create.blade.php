@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('courses.index') !!}" title="دوره ها">دوره ها</a></li>
    <li><a href="{!! route('courses.details', $course->id) !!}" title="جزئیات">{{ $course->title }}</a></li>
    <li><a href="{{ route('lessons.create', $course->id) }}" class="is-active" title="ایجاد درس جدید">ایجاد درس جدید</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ایجاد درس جدید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{route('lessons.store' , $course->id)}}" class="padding-30" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-input type="text" name="title" placeholder="عنوان درس *"
                             class="margin-top-0" required></x-input>

                    <x-input type="text" name="slug" placeholder="نام انگلیسی درس اختیاری" class="text-left"
                             ></x-input>

                     <x-input type="number" name="time" placeholder="مدت زمان جلسه *" class="text-left"
                             required></x-input>

                    <x-input type="number" name="number" placeholder="شماره درس" class="text-left"
                             ></x-input>

                    @if(count($seasons))
                        <x-select name="season_id" required>
                            <option value="">انتخاب سرفصل *</option>
                            @foreach($seasons as $season)
                                <option value="{{$season->id}}"
                                        @if($season->id == old('season_id')) selected @endif>{{$season->title}}</option>
                            @endforeach
                        </x-select>
                    @endif

                    <div class="w-50">
                    <p class="box__title">آیا این درس رایگان است ؟ *</p>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-1" name="is_free" value="0" type="radio" checked="">
                            <label for="lesson-upload-field-1">خیر</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-2" name="is_free" value="1" type="radio">
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

