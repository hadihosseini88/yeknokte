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
                                <th>کد تخفیف</th>
                                <th>درصد</th>
                                <th>محدودیت زمانی</th>
                                <th>توضیحات</th>
                                <th>استفاده شده</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($discounts as $discount)
                            <tr role="row" class="">
                                <td><a href="">{{ $discount->id }}</a></td>
                                <td><a href="">{{ $discount->code ?? '-' }}</a></td>
                                <td><a href="">{{ $discount->percent }}%</a> برای @lang($discount->type)</td>
                                <td>{{ $discount->expire_at ? createFromCarbon($discount->expire_at) : 'نامحدود' }}</td>
                                <td>{{ $discount->description }}</td>
                                <td>{{ $discount->uses }} نفر</td>
                                <td>
                                    <a href="" onclick="deleteItem(event, '{{ route('discounts.destroy', $discount->id) }}')" class="item-delete mlg-15" title="حذف"></a>
                                    <a href="{{ route('discounts.edit', $discount->id) }}" class="item-edit " title="ویرایش"></a>
                                </td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 bg-white">
                <p class="box__title">ایجاد تخفیف جدید</p>
                <form action="{{ route('discounts.store') }}" method="POST" class="padding-30">
                    @csrf
                    <x-input type="text" placeholder="کد تخفیف" class="text" name="code" />
                    <x-input type="number" placeholder="درصد تخفیف" class="text" name="percent" required />
                    <x-input type="number" placeholder="محدودیت افراد" class="text" name="usage_limitation" />
                    <x-input id="expire_at" type="text" placeholder="محدودیت زمانی" class="text" name="expire_at" />
                    <p class="box__title" style="margin-top: 10px;margin-bottom: -10px">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="type" value="all" type="radio"/>
                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn" name="type" value="special" type="radio"/>
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>
                    <div id="selectCourseContainer" class="d-none">
                        <select class="mySelect2" name="courses[]" multiple="multiple">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر" class="text" />
                    <x-input type="text" name="description" placeholder="توضیحات" class="text margin-bottom-15" />

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
        $("#expire_at").persianDatepicker({formatDate: "YYYY/0M/0D 0h:0m"});
        $('.mySelect2').select2({
            placeholder : "یک یا چند دوره را انتخاب کنید."
        });
    </script>

@endsection

