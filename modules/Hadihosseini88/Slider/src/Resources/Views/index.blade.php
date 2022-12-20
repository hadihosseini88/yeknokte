@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('slides.index') !!}" class="is-active" title="اسلایدر">اسلایدر</a></li>
@endsection

@section('content')

    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{!! route('slides.index') !!}">لیست اسلاید ها</a>
                <a class="tab__item " href="{{ route('slides.create') }}">ایجاد اسلاید جدید</a>

            </div>
        </div>
        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th class="p-r-90">شناسه</th>
                    <th>عنوان</th>
                    <th>تصویر</th>
                    <th>اولویت</th>
                    <th>لینک</th>
                    <th>تاریخ ایجاد</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($slides as $slide)
                    <tr role="row" class="">
                        <td><a href="">{{ $slide->id }}</a></td>
                        <td><a href="">{{ $slide->title }}</a></td>
                        <td><a href=""><img class="img__slideshow" src="{{ $slide->media->thumb }}"
                                            alt="{{$slide->title}}"></a>
                        </td>
                        <td>{{ $slide->priority }}</td>
                        <td><a href="{{ $slide->link }}">لینک</a></td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($slide->updated_at) }}</td>
                        <td>{{ $slide->status == 1 ? 'فعال' : 'غیرفعال' }}</td>
                        <td>
                            <a href="" onclick="deleteItem(event, '{{ route('slides.destroy', $slide->id) }}')"
                               class="item-delete mlg-15" title="حذف"></a>
                            <a href="" class="item-reject mlg-15" title="رد"></a>
                            <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                            <a href="" class="item-confirm mlg-15" title="تایید"></a>
                            <a href="{{ route('slides.edit', $slide->id) }}" class="item-edit" title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
