@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('users.index') !!}" class="is-active" title="کاربران">کاربران</a></li>
@endsection

@section('content')
    <div class="main-content font-size-13">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="users.html">همه کاربران</a>
                <a class="tab__item" href="">مدیران</a>
                <a class="tab__item" href="">مدرسین</a>
                <a class="tab__item" href="">نویسنده</a>
                <a class="tab__item" href="">کاربران تاییده نشده</a>
                <a class="tab__item" href="">کاربران تایید شده</a>
                <a class="tab__item" href="create-user.html">ایجاد کاربر جدید</a>
            </div>
        </div>
        <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی کاربر">
                        <div class="t-header-search-content ">
                            <input type="text" class="text" placeholder="ایمیل">
                            <input type="text" class="text" placeholder="شماره">
                            <input type="text" class="text" placeholder="آی پی">
                            <input type="text" class="text margin-bottom-20" placeholder="نام و نام خانوادگی">
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
                    <th>شناسه</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>شماره موبایل</th>
                    <th>سطح کاربری</th>
                    <th>تاریخ عضویت</th>
                    <th>ای پی</th>
                    <th>درحال یادگیری</th>
                    <th>وضعیت حساب</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr role="row" class="">
                        <td><a href="">{{ $loop->index +1 }}</a></td>
                        <td><a href="">{{ $user->id }}</a></td>
                        <td><a href="">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile ?? 'موبایل ثبت نشده' }}</td>
                        <td>
                            <ul>
                                @foreach($user->roles as $userRole)
                                    <li class="delete_able_list_item">@lang($userRole->name)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $user->created_at->format('Y/m/d') }}</td>
                        <td>{{ $user->ip }}</td>
                        <td>5 دوره</td>
                        <td class="confirmation_status">{!! $user->hasVerifiedEmail() ? "<span class='text-success'>تایید شده</span>" : "<span class='text-error'>تایید نشده</span>" !!}</td>
                        <td>
                            <a href="" onclick="deleteItem(event,'{{route('users.destroy', $user->id)}}')"
                               class="item-delete mlg-15" title="حذف"></a>
                            <a href=""
                               onclick="updateConfirmationStatus(event,'{{ route('users.manualVerify', $user->id) }}','آیا از تایید این کاربر اطمینان دارید؟','تایید شده')"
                               class="item-confirm mlg-15" title="تایید"></a>
                            <a href="" class="item-reject mlg-15" title="رد"></a>
                            <a href="edit-user.html" target="_blank" class="item-eye mlg-15" title="مشاهده"></a>
                            <a href="{{ route('users.edit', $user->id) }}" class="item-edit " title="ویرایش"></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('js')

    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection



