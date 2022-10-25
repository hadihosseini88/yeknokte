@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('users.index') !!}" title="کاربران">کاربران</a></li>
    <li><a href="#" class="is-active">اطلاعات کاربری</a></li>
@endsection

@section('content')
    <div class="main-content  ">
        <div class="user-info bg-white padding-30 font-size-13">
            <x-user-photo></x-user-photo>
            <form action="{{ route('users.profile') }}" method="POST">
                @csrf
                <x-input value="{{ auth()->user()->name }}" name="name" type="text" placeholder="نام و نام خانوادگی"
                         requierd></x-input>

                <x-input value="{{ auth()->user()->email }}" name="email" type="text" class="text text-left"
                         placeholder="ایمیل"
                         requierd></x-input>
                <x-input value="{{ auth()->user()->mobile }}" name="mobile" type="text" class="text text-left"
                         placeholder="شماره موبایل"></x-input>

                <x-input value="" name="password" class="text text-left" type="text" placeholder="رمز عبور"></x-input>
                <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                    غیر الفبا مانند <strong>!@#$%^&*()</strong> باشد.</p>

                @can(\Hadihosseini88\RolePermissions\Models\Permission::PERMISSION_TEACH)
                    <x-input value="{{ auth()->user()->card_number }}" name="card_number" type="text"
                             class="text text-left" placeholder="شماره کارت بانکی"></x-input>
                    <x-input value="{{ auth()->user()->shaba }}" name="shaba" class="text text-left" type="text"
                             placeholder="شماره شبا بانکی"></x-input>
                    <x-input value="{{ auth()->user()->username }}" name="username" class="text text-left" type="text"
                             placeholder="نام کاربری و آدرس پروفایل"></x-input>
                    <p class="input-help text-left margin-bottom-12" dir="ltr">
                        @if(auth()->user()->profilePath())
                            <a href="{{ auth()->user()->profilePath() }}"
                               target="_blank">{{ auth()->user()->profilePath() }}</a>
                        @endif
                    </p>
                    <x-input value="{{ auth()->user()->headline }}" name="headline" type="text" class="text text-left"
                             placeholder="عنوان"></x-input>

                    <br>
                    <x-textarea value="{{ auth()->user()->bio }}" name="bio" class="text"
                                placeholder="درباره من مخصوص مدرسین"></x-textarea>
                @endcan

                <br>
                <br>
                <button class="btn btn-yeknokte_ir">ذخیره تغییرات</button>
            </form>
        </div>

    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection



