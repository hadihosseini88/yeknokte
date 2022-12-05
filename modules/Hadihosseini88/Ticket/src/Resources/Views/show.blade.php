@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('tickets.index') !!}" title="تیکت ها">تیکت ها</a></li>
    <li><a href="{!! route('tickets.show', $ticket->id) !!}" class="is-active" title="نمایش تیکت">نمایش تیکت</a></li>
@endsection

@section('content')

    <div class="main-content">
        <div class="show-comment">
            <div class="ct__header">
                <div class="comment-info">
                    <a class="back" href="{!! route('tickets.index') !!}"></a>
                    <div>
                        <p class="comment-name"><a
                                href="{!! route('tickets.show', $ticket->id) !!}">{{ $ticket->title }}</a></p>
                    </div>
                </div>
            </div>
            @foreach($ticket->replies as $reply)
                <div class="transition-comment {{ $reply->user_id != $ticket->user_id ? 'is-answer': '' }}">
                    <div class="transition-comment-header">
                       <span>
                            <img src="{{ $reply->user->thumb }}" class="logo-pic">
                       </span>
                        <span class="nav-comment-status">
                            <p class="username">کاربر : {{ $ticket->user->name }}</p>
                            <p class="comment-date">{{ $reply->created_at }} ماه پیش</p>
                    </span>
                        <div>

                        </div>
                    </div>
                    <div class="transition-comment-body">
                        <pre>{{ $reply->body }}</pre>
                        <div>

                        </div>
                    </div>
                </div>
            @endforeach
            <div class="transition-comment is-answer">
                <div class="transition-comment-header">
                       <span>
                                         <img src="img/profile.jpg" class="logo-pic">
                       </span>
                    <span class="nav-comment-status">
                            <p class="username">مدیر : یک نکته</p>
                            <p class="comment-date">10 ماه پیش</p></span>
                    <div>

                    </div>
                </div>
                <div class="transition-comment-body">
                        <pre>سلام خسته نباشید من زرین کارتم دستم رسیده و الان میخام گردش مالی رو چک کنم ولی
 رمز دوم و cvv2 رو که میزنم  خطا میده  و گردش مالی رو چک نمیکنه مشکل کجاست؟
فایل رو ضمیمه میکنم ببنید
من باید برم جایی این کارت رو فعال کنم؟ یا خیر فعال شده هستش؟</pre>
                    <div>

                    </div>
                </div>
            </div>
        </div>
        <div class="answer-comment">
            <p class="p-answer-comment">ارسال پاسخ</p>
            <form action="{{ route('tickets.reply', $ticket->id) }}" method="post">
                @csrf
                <x-textarea name="body" placeholder="متن پاسخ" required></x-textarea>
                <br><br>
                <x-file name="attachment" textSpan="آپلود فایل" placeholder="آپلود فایل پیوست"></x-file>
                <button class="btn btn-yeknokte_ir">پاسخ تیکت</button>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
