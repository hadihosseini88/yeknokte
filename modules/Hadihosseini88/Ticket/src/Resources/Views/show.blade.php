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
                            <p class="comment-date">{{ $ticket->created_at->diffForHumans() }}</p>
                    </span>
                        <div>

                        </div>
                    </div>
                    <div class="transition-comment-body">
                        <pre>{{ $reply->body }}</pre>
                        <hr style="border-style: inset; border-width: 1px;margin-left: 20px;margin-right: 20px;">
                        <div>
                            @if($reply->media_id)
                                <a href="{{ $reply->attachmentLink() }}" class="text-warning" style="padding-right: 30px;padding-top: 10px;padding-bottom: 10px;">دانلود فایل پیوست</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="answer-comment">
            <p class="p-answer-comment">ارسال پاسخ</p>
            <form action="{{ route('tickets.reply', $ticket->id) }}" method="post" enctype="multipart/form-data">
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
