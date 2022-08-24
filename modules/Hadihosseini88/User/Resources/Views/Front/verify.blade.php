@extends('User::Front.master')


@section('content')
    <form action="{{ route('verification.resend') }}" class="form" method="POST">
        @csrf
        <a class="account-logo" href="index.html">
            <img src="/img/weblogo.png" alt="">
        </a>
        <div class="card-header">
            <p class="activation-code-title">
                {{ __('auth.Verify Your Email Address') }}
            </p>
            @if (session('resent'))
                <p class="activation-code-title" style="color: red;">
                    {{ __('auth.A fresh verification link has been sent to your email address.') }}
                </p>
            @endif
            <p class="activation-code-title">
                {{ __('auth.Before proceeding, please check your email for a verification link.') }}
                {{ __('auth.If you did not receive the email') }}
            </p>
        </div>
        <div class="form-content form-content1">
            <button type="submit" class="btn i-t">{{ __('auth.click here to request another') }}</button>

        </div>
        <div class="form-footer">
            <a href="/">بازگشت به صفحه اصلی</a>
        </div>
    </form>
@endsection


