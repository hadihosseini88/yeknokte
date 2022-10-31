@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('settlements.index') }}"> تسویه حساب ها</a></li>
    <li><a href="{{ route('settlements.create') }}" class="is-active">درخواست تسویه حساب جدید</a></li>
@endsection

@section('content')

    <div class="main-content">
        <form action="{{ route('settlements.store') }}" method="POST" class="padding-30 bg-white font-size-14">
            @csrf
            <x-input type="text" name="name" placeholder="نام صاحب حساب" required />
            <x-input type="text" name="cart" placeholder="شماره کارت" required />
            <x-input type="text" name="amount" value="{{ auth()->user()->balance }}" placeholder="مبلغ به تومان"
                   class="text" required />
            <div class="row no-gutters border-2 margin-bottom-15 text-center" style="margin-top: 15px">
                <div class="w-50 padding-20 w-50">موجودی قابل برداشت :‌</div>
                <div class="bg-fafafa padding-20 w-50"> {{ number_format(auth()->user()->balance) }} تومان</div>
            </div>
            <div class="row no-gutters border-2 text-center margin-bottom-15">
                <div class="w-50 padding-20">حداکثر زمان واریز :‌</div>
                <div class="w-50 bg-fafafa padding-20">۳ روز</div>
            </div>
            <button type="submit" class="btn btn-yeknokte_ir">درخواست تسویه</button>
        </form>
    </div>

@endsection
