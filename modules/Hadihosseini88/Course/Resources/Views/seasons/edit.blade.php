@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('courses.index') !!}" title="دوره ها">دوره ها</a></li>
    <li><a href="{!! route('courses.details', $season->course_id) !!}" title="دوره ها">جزئیات</a></li>
    <li><a href="#" class="is-active" title="ویرایش فصل">ویرایش فصل</a></li>
@endsection

@section('content')

    <div class="main-content padding-0">
        <p class="box__title">ویرایش فصل</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route('seasons.update',$season->id) }}" class="padding-30" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <x-input value="{{ $season->title }}" type="text" name="title" placeholder="عنوان سرفصل" class="text" required></x-input>
                    <x-input value="{{ $season->number }}" type="text" name="number" placeholder="شماره سرفصل" class="text"></x-input>
                    <br>
                    <br>
                    <button class="btn btn-yeknokte_ir">بروزرسانی فصل</button>
                </form>
            </div>
        </div>
    </div>
@endsection

