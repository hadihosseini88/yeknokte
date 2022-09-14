@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('courses.index') !!}" class="is-active" title="دوره ها">دوره ها</a></li>
@endsection

@section('content')
    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="courses.html">لیست دوره ها</a>
                <a class="tab__item" href="approved.html">دوره های تایید شده</a>
                <a class="tab__item" href="new-course.html">دوره های تایید نشده</a>
                <a class="tab__item" href="{{ route('courses.create') }}">ایجاد دوره جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی دوره">
                        <div class="t-header-search-content ">
                            <input type="text"  class="text"  placeholder="نام دوره">
                            <input type="text"  class="text" placeholder="ردیف">
                            <input type="text"  class="text" placeholder="قیمت">
                            <input type="text"  class="text" placeholder="نام مدرس">
                            <input type="text"  class="text margin-bottom-20" placeholder="دسته بندی">
                            <btutton class="btn btn-yeknokte_ir">جستجو</btutton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table__box">
            <table class="table">

                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>ردیف</th>
                    <th>عکس دوره</th>
                    <th>شناسه</th>
                    <th>ردیف در صفحه اصلی</th>
                    <th>عنوان</th>
                    <th>مدرس دوره</th>
                    <th>قیمت (تومان)</th>
                    <th>جزئیات</th>
                    <th>تراکنش ها</th>
                    <th>نظرات</th>
                    <th>تعداد دانشجویان</th>
                    <th>تعداد تایید</th>
                    <th>درصد مدرس</th>
                    <th>وضعیت دوره</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                <tr role="row" >
                    <td><a href="">{{ $loop->index +1 }}</a></td>
                    <td><img src="{{ $course->thumb }}" alt="{{$course->title}}" width="80"></td>
                    <td><a href="">{{ $course->id }}</a></td>
                    <td><a href="">{{ $course->priority ?? '0' }}</a></td>
                    <td><a href="">{{ $course->title }}</a></td>
                    <td><a href="">{{ $course->teacher->name }}</a></td>
                    <td>{{$course->price}}</td>
                    <td><a href="course-detail.html" class="color-2b4a83">مشاهده</a></td>
                    <td><a href="course-transaction.html" class="color-2b4a83" >مشاهده</a></td>
                    <td><a href="" class="color-2b4a83" >مشاهده (10 نظر)</a></td>
                    <td>120</td>
                    <td>تایید شده</td>
                    <td>{{ $course->percent }}%</td>
                    <td>@lang($course->status)</td>
                    <td>
                        <a href="" class="item-delete mlg-15" title="حذف"></a>
                        <a href="" class="item-reject mlg-15" title="رد"></a>
                        <a href="" class="item-lock mlg-15" title="قفل دوره"></a>
                        <a href="" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                        <a href="" class="item-confirm mlg-15" title="تایید"></a>
                        <a href="" class="item-edit " title="ویرایش"></a>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection



