@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('settlements.index') }}"> تسویه حساب ها</a></li>
    <li><a href="{{ route('settlements.edit', $settlement->id) }}" class="is-active">ویرایش تسویه حساب</a></li>
@endsection

@section('content')
    
    <div class="main-content">
        <form action="{{ route('settlements.update', $settlement->id) }}" method="POST" class="padding-30 bg-white font-size-14">
            @csrf
            @method('patch')
            <x-input type="text" name="from[name]" value="{{ is_array($settlement->from) && array_key_exists('name', $settlement->from) ? $settlement->from['name'] : '' }}" placeholder="نام صاحب حساب فرستنده" />
            <x-input type="text" name="from[cart]" value="{{ is_array($settlement->from) && array_key_exists('cart', $settlement->from) ? $settlement->from['cart'] : '' }}" placeholder="شماره کارت فرستنده" />

            <x-input type="text" name="to[name]" value="{{ is_array($settlement->to) && array_key_exists('name', $settlement->to) ? $settlement->to['name'] : '' }}" placeholder="نام صاحب حساب گیرنده" required />
            <x-input type="text" name="to[cart]" value="{{ is_array($settlement->to) && array_key_exists('cart', $settlement->to) ? $settlement->to['cart'] : '' }}" placeholder="شماره کارت گیرنده" required />
            <x-input type="text" name="amount" value="{{ $settlement->amount }}" placeholder="مبلغ به تومان"
                   class="text" required />

            <x-select name="status" required>
{{--                <option value="">وضعیت پرداخت</option>--}}
                @foreach(\Hadihosseini88\Payment\Models\Settlement::$statuses as $status)
                    <option value="{{$status}}"
{{--                            @if($status == old('status')) selected @endif--}}
                    >@lang($status)</option>
                @endforeach
            </x-select>
            <div class="row no-gutters border-2 margin-bottom-15 text-center" style="margin-top: 15px">
                <div class="w-50 padding-20 w-50">موجودی قابل برداشت :‌</div>
                <div class="bg-fafafa padding-20 w-50"> {{ number_format($settlement->user->balance) }} تومان</div>
            </div>
            <div class="row no-gutters border-2 text-center margin-bottom-15">
                <div class="w-50 padding-20">حداکثر زمان واریز :‌</div>
                <div class="w-50 bg-fafafa padding-20">۳ روز</div>
            </div>
            <button type="submit" class="btn btn-yeknokte_ir">بروزرسانی تسویه</button>
        </form>
    </div>

@endsection
