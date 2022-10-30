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
