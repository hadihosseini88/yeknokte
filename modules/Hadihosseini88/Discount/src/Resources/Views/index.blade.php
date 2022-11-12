@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('discounts.index') }}" class="is-active" title="تخفیف ها">تخفیف ها</a></li>

@endsection

@section('content')

    <div class="main-content padding-0 discounts">
        <div class="row no-gutters  ">
            <div class="col-8 margin-left-10 margin-bottom-15 border-radius-3">
                <p class="box__title">تخفیف ها</p>
                <div class="table__box">
                    <div class="table-box">
                        <table class="table">
                            <thead role="rowgroup">
                            <tr role="row" class="title-row">
                                <th>شناسه</th>
                                <th>درصد</th>
                                <th>محدودیت زمانی</th>
                                <th>توضیحات</th>
                                <th>استفاده شده</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="">
                                <td><a href="">1</a></td>
                                <td><a href="">50%</a></td>
                                <td>2 ساعت دیگر</td>
                                <td>مناسبت عید نوروز</td>
                                <td>0 نفر</td>
                                <td>
                                    <a href="" class="item-delete mlg-15"></a>
                                    <a href="edit-discount.html" class="item-edit " title="ویرایش"></a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 bg-white">
                <p class="box__title">ایجاد تخفیف جدید</p>
                <form action="" method="post" class="padding-30">
                    <input type="text" placeholder="کد تخفیف" class="text" name="code" required>
                    <input type="number" placeholder="درصد تخفیف" class="text" name="percent" required>
                    <input type="number" placeholder="محدودیت افراد" class="text" name="usage_limitation">
                    <input id="expire_at" type="text" placeholder="محدودیت زمانی" class="text" name="expire_at">
                    <p class="box__title">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="discounts-field" value="all" type="radio"/>
                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn" name="discounts-field" value="special" type="radio"/>
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>
                    <div id="selectCourseContainer" class="d-none">
                        <select class="mySelect2" name="courses[]" multiple="multiple">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <input type="text" name="link" placeholder="لینک اطلاعات بیشتر" class="text">
                    <input type="text" name="description" placeholder="توضیحات" class="text margin-bottom-15">

                    <button type="submit" class="btn btn-yeknokte_ir" style="margin-top: 15px;">اضافه کردن</button>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <link rel="stylesheet" href="/assets/persianDatepicker/css/persianDatepicker-default.css"/>
    <link href="/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="/assets/persianDatepicker/js/persianDatepicker.min.js"></script>
    <script src="/js/select2.min.js"></script>

    <script>
        $("#expire_at").persianDatepicker({formatDate: "YYYY/MM/DD hh:mm"});
        $('.mySelect2').select2({
            placeholder : "یک یا چند دوره را انتخاب کنید."
        });
    </script>

@endsection

