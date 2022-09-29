@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('users.index') !!}" title="کاربران">کاربران</a></li>
    <li><a href="#" class="is-active">ویرایش کاربران</a></li>
@endsection

@section('content')
    <div class="main-content font-size-13">
        <div class="row no-gutters bg-white margin-bottom-20">
            <div class="col-12">
                <p class="box__title">ویرایش کاربر</p>
                <form action="{{ route('users.update', $user->id) }}" class="padding-30" method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('patch')

                    <x-input value="{{ $user->name }}" name="name" type="text" placeholder="نام و نام خانوادگی"
                             requierd></x-input>

                    <x-input value="{{ $user->email }}" name="email" type="text" class="text" placeholder="ایمیل"
                             requierd></x-input>

                    <x-input value="{{ $user->username }}" name="username" type="text" class="text" placeholder="نام کاربری"
                             ></x-input>

                    <x-input value="{{ $user->mobile }}" name="mobile" type="text" class="text" placeholder="شماره موبایل"
                             ></x-input>

                    <x-input value="{{ $user->headline }}" name="headline" type="text" class="text" placeholder="عنوان"
                             ></x-input>

                    <x-select name="status" required>
                        <option value="">وضعیت کاربر</option>
                        @foreach(\Hadihosseini88\User\Models\User::$statuses as $status)
                            <option value="{{ $status }}"
                                    @if($status == $user->status) selected @endif>@lang($status)</option>
                        @endforeach
                    </x-select>

                    <x-select name="role">
                        <option value="">نقشه کاربری</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }} >
                                @lang($role->name)
                            </option>
                        @endforeach
                    </x-select>

                    <br>
                    <x-file name="image" textSpan="آپلود بنر کاربر" :value="$user->image"></x-file>

                    <x-input name="password" type="text" class="text" placeholder="رمز جدید"
                             value=""></x-input>

                    <x-textarea placeholder="بیوگرافی" name="bio" value="{{ $user->bio }}"></x-textarea>

                    <br><br>
                    <button class="btn btn-yeknokte_ir">بروزرسانی دوره</button>
                </form>

            </div>
        </div>
        <div class="row no-gutters">
            <div class="col-6 margin-left-10 margin-bottom-20">
                <p class="box__title">درحال یادگیری</p>
                <div class="table__box">
                    <table class="table">
                        <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام دوره</th>
                            <th>نام مدرس</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr role="row" class="">
                            <td><a href="">1</a></td>
                            <td><a href="">دوره لاراول</a></td>
                            <td><a href="">صیاد اعظمی</a></td>
                        </tr>
                        <tr role="row" class="">
                            <td><a href="">1</a></td>
                            <td><a href="">دوره لاراول</a></td>
                            <td><a href="">صیاد اعظمی</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6 margin-bottom-20">
                <p class="box__title">دوره های مدرس</p>
                <div class="table__box">
                    <table class="table">
                        <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th>شناسه</th>
                            <th>نام دوره</th>
                            <th>نام مدرس</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->courses as $course)
                        <tr role="row" class="">
                            <td><a href="">{{ $course->id }}</a></td>
                            <td><a href="">{{ $course->title }}</a></td>
                            <td><a href="">{{ $course->teacher->name }}</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection

        @section('js')
            <script src="/panel/js/tagsInput.js"></script>
            <script>
                @include('Common::layouts.feedbacks')
            </script>
        @endsection



