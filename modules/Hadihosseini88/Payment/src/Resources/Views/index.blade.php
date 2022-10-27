@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" class="" title="دوره ها"> دوره ها</a></li>
    <li><a href="{{ route('payments.index') }}" class="is-active" title="تراکنش ها">تراکنش ها</a></li>
@endsection

@section('content')

    <div class="main-content font-size-13">
        <div class="row no-gutters  margin-bottom-10">
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>کل فروش ۳۰ روز گذشته سایت </p>
                <p>{{ number_format($last30DaysTotal) }} تومان</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>درامد خالص ۳۰ روز گذشته سایت</p>
                <p>{{ number_format($last30DaysSiteBenefit) }} تومان</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-left-10 margin-bottom-10">
                <p>کل فروش سایت</p>
                <p>{{ number_format($totalSell) }} تومان</p>
            </div>
            <div class="col-3 padding-20 border-radius-3 bg-white margin-bottom-10">
                <p> کل درآمد خالص سایت</p>
                <p>{{ number_format($totalBenefit) }} تومان</p>
            </div>
        </div>
        <div class="row no-gutters border-radius-3 font-size-13">
            <div class="col-12 bg-white padding-30 margin-bottom-20">
                محل نمودار درآمد سی روز گذشته

                <div id="container"></div>
                <p class="highcharts-description">
                    در این نمودار درآمد خالص سایت و درآمد خالص مدرسان به نمایش گذشته شده است.
                </p>

            </div>

        </div>
        <div class="d-flex flex-space-between item-center flex-wrap padding-30 border-radius-3 bg-white">
            <p class="margin-bottom-15">همه تراکنش ها</p>
            <div class="t-header-search">
                <form action="">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی تراکنش">
                        <div class="t-header-search-content ">
                            <input type="text" class="text" name="email" value="{{ request('emila') }}" placeholder="ایمیل">
                            <input type="text" class="text" name="amount" value="{{ request('amount') }}" placeholder="مبلغ به تومان">
                            <input type="text" class="text" name="invoice_id" value="{{ request('invoice_id') }}" placeholder="شماره">
                            <input type="text" class="text" name="start_date" value="{{ request('start_date') }}" placeholder="از تاریخ : 1399/10/11">
                            <input type="text" class="text margin-bottom-20" name="end_date" value="{{ request('end_date') }}" placeholder="تا تاریخ : 1399/10/12">
                            <button class="btn btn-yeknokte_ir" type="submit">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table__box">
            <table width="100%" class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه پرداخت</th>
                    <th>شناسه تراکنش</th>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل پرداخت کننده</th>
                    <th>مبلغ (تومان)</th>
                    <th>درامد مدرس</th>
                    <th>درامد سایت</th>
                    <th>نام دوره</th>
                    <th>تاریخ و ساعت</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr role="row">
                        <td><a href="">{{ $payment->id }}</a></td>
                        <td>{{ $payment->invoice_id }}</td>
                        <td><a href="">{{ $payment->buyer->name }}</a></td>
                        <td><a href="">{{ $payment->buyer->email }}</a></td>
                        <td><a href="">{{ $payment->amount }}</a></td>
                        <td><a href="">{{ $payment->seller_share }}</a></td>
                        <td><a href="">{{ $payment->site_share }}</a></td>
                        <td><a href="">{{ $payment->paymentable->title }}</a></td>
                        <td><a href="">{{ createFromCarbon($payment->created_at) }}</a></td>
                        <td><a href=""
                               class="@if($payment->status == \Hadihosseini88\Payment\Models\Payment::STATUS_SUCCESS) text-success @elseif($payment->status == \Hadihosseini88\Payment\Models\Payment::STATUS_PENDING) text-pending @else text-error @endif">@lang($payment->status)</a>
                        </td>
                        <td>
                            <a href="" class="item-delete mlg-15"></a>
                            <a href="edit-transaction.html" class="item-edit"></a>
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

    <script src="/panel/js/highcharts.js"></script>
    <script src="/panel/js/series-label.js"></script>
    <script src="/panel/js/exporting.js"></script>
    <script src="/panel/js/export-data.js"></script>
    <script src="/panel/js/accessibility.js"></script>

    <script>

        Highcharts.chart('container', {
            title: {
                text: 'نمودار درآمد فروش سایت',
                align: 'center',
                useHTML: true,
                style: {
                    fontFamily: 'irs',
                    direction: 'rtl',
                },
            },
            tooltip: {
                useHTML: true,
                style: {
                    fontFamily: 'irs',
                    direction: 'rtl',
                },

                formatter: function () {
                    return (this.x ? 'تاریخ: ' + this.x + '<br>' : '')  + 'مبلغ: ' + this.y + ' تومان';

                }

            },
            xAxis: {
                categories: [@foreach($dates as $date =>$value) '{{ getJalaliFromFormat($date) }}', @endforeach],
                useHTML: true,
                style: {
                    fontFamily: 'irs',
                    direction: 'rtl',
                },
            },
            yAxis: {
                title: {
                    text: 'مبلغ به تومان'
                },
                labels: {
                    formatter: function () {
                        return this.value + ' تومان';
                    }
                },
            },
            labels: {
                items: [{
                    html: 'درآمد 30 روز گذشته',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: 'تراکنش موفق',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where('date',$date)->first()) {{ $day->totalAmount }} , @else 0, @endif @endforeach]
            }, {
                type: 'column',
                name: 'مبلغ روز مدرسین',
                color: 'pink',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where('date',$date)->first()) {{ $day->totalSellerShare }} , @else 0, @endif @endforeach]
            }, {
                type: 'column',
                name: 'مبلغ روز سایت',
                color: 'green',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where('date',$date)->first()) {{ $day->totalSiteShare }} , @else 0, @endif @endforeach]
            }, {
                type: 'spline',
                name: 'نمودار خطی تراکنش موفق',
                data: [@foreach($dates as $date => $value) @if($day = $summery->where('date',$date)->first()) {{ $day->totalAmount }} , @else 0, @endif @endforeach],
                marker: {
                    lineWidth: 2,
                    lineColor: 'lightblue',
                    fillColor: 'white'
                },
                color: "lightblue"
            }, {
                type: 'pie',
                name: 'مبلغ فروش',
                data: [{
                    name: 'مبلغ کل سایت',
                    y: {{ $last30DaysSiteBenefit }},
                    color: 'green'
                }, {
                    name: 'مبلغ کل مدرسین',
                    y: {{ $last30DaysSellerShare }},
                    color: 'pink'
                }],
                center: [80, 70],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    </script>

@endsection




