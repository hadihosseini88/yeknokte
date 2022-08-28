@extends('User::Front.master')


@section('content')
    <form action="{{ route('verification.verify') }}" class="form" method="POST">
        @csrf
        <a class="account-logo" href="/">
            <img src="/img/weblogo.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">کد فرستاده شده به ایمیل  <span>{{auth()->user()->email}}</span>
                را وارد کنید . ممکن است ایمیل به پوشه spam فرستاده شده باشد
            </p>
        </div>
        <div class="form-content form-content1">
            <input name="verify_code" class="activation-code-input" required placeholder="فعال سازی">
            @error('verify_code')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <br>
            <button class="btn i-t">تایید</button>
            <a class="btn i-t a-btn-danger" href="#" onclick="
            event.preventDefault();
            document.getElementById('resend-code').submit();"
            >ارسال مجدد کدفعالسازی</a>

        </div>
        <div class="form-footer">
            <a href="{{route('register')}}">صفحه ثبت نام</a>
        </div>
    </form>

    <form id="resend-code" action="{{route('verification.resend')}}" method="POST" hidden>@csrf</form>
@endsection

@section('js')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/activation-code.js"></script>
@endsection


