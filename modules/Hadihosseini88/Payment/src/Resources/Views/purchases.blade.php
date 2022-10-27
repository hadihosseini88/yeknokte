@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('purchases.index') }}" class="is-active" >پرداخت های من</a></li>

@endsection

@section('content')

    <div class="main-content">
        <div class="table__box">
            <table  class="table">
                <thead>
                <tr class="title-row">
                    <th>عنوان دوره</th>
                    <th>تاریخ پرداخت</th>
                    <th>مقدار پرداختی</th>
                    <th>وضعیت پرداخت</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td><a href="{{ $payment->paymentable->path() }}" target="_blank">{{ $payment->paymentable->title }}</a></td>
                    <td>{{ createFromCarbon($payment->created_at) }}</td>
                    <td>{{ number_format($payment->amount) }} تومان</td>
                    <td class="@if($payment->status == \Hadihosseini88\Payment\Models\Payment::STATUS_SUCCESS) text-success @elseif($payment->status == \Hadihosseini88\Payment\Models\Payment::STATUS_PENDING) text-pending @else text-error @endif">@lang($payment->status)</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $payments->render() }}

        </div>
    </div>

@endsection
