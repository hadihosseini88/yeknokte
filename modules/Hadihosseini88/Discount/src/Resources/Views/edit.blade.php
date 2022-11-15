@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('discounts.index') }}" class="" title="تخفیف ها">تخفیف ها</a></li>
    <li><a href="{{ route('discounts.edit', $discount->id) }}" class="is-active" title="ویرایش تخفیف">ویرایش تخفیف</a></li>


@endsection

@section('content')

    <div class="main-content padding-0 discounts">
        <div class="row no-gutters  ">
            <div class="col-8 bg-white" style="margin-left: auto;margin-right: auto;">
                <p class="box__title">ویرایش کد تخفیف</p>
                <form action="{{ route('discounts.update', $discount->id) }}" method="POST" class="padding-30">
                    @csrf
                    @method('patch')
                    <x-input type="text" placeholder="کد تخفیف" class="text" name="code" value="{{ $discount->code }}" />
                    <x-input type="number" placeholder="درصد تخفیف" class="text" name="percent" required value="{{ $discount->percent }}" />
                    <x-input type="number" placeholder="محدودیت افراد" class="text" name="usage_limitation" value="{{ $discount->usage_limitation }}" />
                    <x-input id="expire_at" type="text" placeholder="محدودیت زمانی" class="text" name="expire_at" value="{{ $discount->expire_at ? \Morilog\Jalali\Jalalian::fromCarbon($discount->expire_at)->format('Y/m/d H:i') : '' }}" />
                    <p class="box__title" style="margin-top: 10px;margin-bottom: -10px">این تخفیف برای</p>
                    <div class="notificationGroup">
                        <input id="discounts-field-1" class="discounts-field-pn" name="type" value="all" type="radio" {{ $discount->type == \Hadihosseini88\Discount\Models\Discount::TYPE_ALL ? 'checked' : '' }}/>
                        <label for="discounts-field-1">همه دوره ها</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="discounts-field-2" class="discounts-field-pn" name="type" value="special" type="radio" {{ $discount->type == \Hadihosseini88\Discount\Models\Discount::TYPE_SPECIAL ? 'checked' : '' }}/>
                        <label for="discounts-field-2">دوره خاص</label>
                    </div>
                    <div id="selectCourseContainer" class="{{ $discount->type == \Hadihosseini88\Discount\Models\Discount::TYPE_ALL ? 'd-none' : '' }}">
                        <select class="mySelect2" name="courses[]" multiple="multiple">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $discount->courses->contains($course->id) ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-input type="text" name="link" placeholder="لینک اطلاعات بیشتر" class="text" value="{{ $discount->link }}" />
                    <x-input type="text" name="description" placeholder="توضیحات" class="text margin-bottom-15" value="{{ $discount->description }}" />

                    <button type="submit" class="btn btn-yeknokte_ir" style="margin-top: 15px;">بروزرسانی</button>
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
