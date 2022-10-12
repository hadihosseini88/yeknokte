@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('courses.index') !!}" title="دوره ها">دوره ها</a></li>
    <li><a href="{!! route('courses.details', $course->id) !!}" title="جزئیات">{{ $course->title }}</a></li>
    <li><a href="{{ route('lessons.edit',[$course->id, $lesson->id]) }}" class="is-active" title="بروزرسانی درس">بروزرسانی
            درس {{ $lesson->title }}</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ایجاد درس جدید</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route('lessons.update',[$course->id, $lesson->id]) }}" class="padding-30"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <x-input type="text" name="title" value="{{ $lesson->title }}" placeholder="عنوان درس *"
                             class="margin-top-0" required></x-input>

                    <x-input type="text" name="slug" value="{{ $lesson->slug }}" placeholder="نام انگلیسی درس اختیاری"
                             class="text-left"
                    ></x-input>

                    <x-input type="number" name="time" value="{{ $lesson->time }}" placeholder="مدت زمان جلسه *"
                             class="text-left"
                             required></x-input>

                    <x-input type="number" name="number" value="{{ $lesson->number }}" placeholder="شماره درس"
                             class="text-left"
                    ></x-input>

                    @if(count($seasons))
                        <x-select name="season_id" required>
                            <option value="">انتخاب سرفصل *</option>
                            @foreach($seasons as $season)
                                <option value="{{$season->id}}"
                                        @if($season->id == $lesson->season_id) selected @endif>{{$season->title}}</option>
                            @endforeach
                        </x-select>
                    @endif

                    <div class="w-50">
                        <p class="box__title">آیا این درس رایگان است ؟ *</p>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-1" name="is_free" value="0" type="radio"
                                   @if(! $lesson->is_free)  checked="" @endif>
                            <label for="lesson-upload-field-1">خیر</label>
                        </div>
                        <div class="notificationGroup">
                            <input id="lesson-upload-field-2" name="is_free" value="1" type="radio"
                                   @if($lesson->is_free)  checked="" @endif>
                            <label for="lesson-upload-field-2">بله</label>
                        </div>
                    </div>
                    <br>

                    <x-file name="lesson_file" textSpan="آپلود درس" :value="$lesson->media"></x-file>

                    <x-textarea placeholder="توضیحات درس" name="body" value="{{ $lesson->body }}"></x-textarea>

                    <br>
                    <br>

                    <button class="btn btn-yeknokte_ir">بروزرسانی درس</button>
                </form>
            </div>
        </div>
    </div>
@endsection

