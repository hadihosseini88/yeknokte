@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('courses.index') !!}" title="دوره ها">دوره ها</a></li>
    <li><a href="{!! route('courses.edit', $course->id) !!}" class="is-active" title="ویرایش دوره">ویرایش دوره</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ویرایش دوره</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route('courses.update',$course->id) }}" class="padding-30" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <x-input value="{{ $course->title }}" type="text" name="title" placeholder="عنوان دوره"
                             class="margin-top-0" required></x-input>

                    <x-input value="{{ $course->slug }}" type="text" name="slug" placeholder="نام انگلیسی دوره"
                             class="text-left"
                             required></x-input>

                    <div class="d-flex multi-text">
                        <div class="mlg-15" style="width: 100%;">
                            <x-input value="{{ $course->priority }}" type="text" class="text-left" name="priority"
                                     placeholder="ردیف دوره"></x-input>
                        </div>
                        <div class="mlg-15" style="width: 100%;">
                            <x-input value="{{ $course->price }}" type="text" placeholder="مبلغ دوره" name="price"
                                     class="text-left"
                                     required></x-input>
                        </div>
                        <div style="width: 100%;">
                            <x-input value="{{ $course->percent }}" type="text" placeholder="درصد مدرس" name="percent"
                                     class="text-left"
                                     required></x-input>
                        </div>
                    </div>
                    <x-select name="teacher_id" required>
                        <option value="">انتخاب مدرس دوره</option>
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}"
                                    @if($teacher->id == $course->teacher_id) selected @endif>{{$teacher->name}}</option>
                        @endforeach
                    </x-select>

                    <x-tag-select name="tags"></x-tag-select>

                    <x-select name="type" required>
                        <option value="">نوع دوره</option>
                        @foreach(\Hadihosseini88\Course\Models\Course::$types as $type)
                            <option value="{{ $type }}"
                                    @if($type == $course->type) selected @endif>@lang($type)</option>
                        @endforeach
                    </x-select>

                    <x-select name="status" required>
                        <option value="">وضعیت دوره</option>
                        @foreach(\Hadihosseini88\Course\Models\Course::$statuses as $status)
                            <option value="{{$status}}"
                                    @if($status == $course->status) selected @endif
                            >@lang($status)</option>
                        @endforeach
                    </x-select>

                    <x-select name="category_id" required>
                        <option value="">دسته بندی</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}"
                                    @if($category->id == $course->category_id) selected @endif
                            >{{$category->title}}</option>
                        @endforeach
                    </x-select>

                    <br>

                    <x-file name="image" textSpan="آپلود بنر دوره" :value="$course->banner"></x-file>

                    <x-textarea placeholder="توضیحات دوره" name="body" value="{{ $course->body }}"></x-textarea>

                    <br>
                    <br>

                    <button class="btn btn-yeknokte_ir">بروزرسانی دوره</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
