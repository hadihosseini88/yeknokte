@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('comments.index') !!}" class="" title="نظرات">نظرات</a></li>
    <li><a href="{!! route('comments.show', $comment) !!}" class="is-active" title="مشاهده نظرات">مشاهده نظرات</a></li>
@endsection

@section('content')

    <div class="main-content">
        <div class="show-comment">
            <div class="ct__header">
                <div class="comment-info">
                    <a class="back" href="{{ route('comments.index') }}"></a>
                    <div>
                        <p class="comment-name"><a href="">{{ $comment->commentable->title }}</a></p>
                    </div>
                </div>
            </div>
            @include('Comments::comment', ['comment'=> $comment, 'isAnswer' => false])
            @foreach($comment->comments as $reply)
                @include('Comments::comment', ['comment'=> $reply, 'isAnswer' => true])
            @endforeach
        </div>
        @if($comment->status == \Hadihosseini88\Comment\Models\Comment::STATUS_APPROVED)
            <div class="answer-comment">
                <p class="p-answer-comment">ارسال پاسخ</p>
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf
                    <input type="hidden" id="comment_id" name="comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="commentable_type" value="{{ get_class($comment->commentable) }}">
                    <input type="hidden" name="commentable_id" value="{{ $comment->commentable->id }}">
                    <x-textarea class="textarea" name="body" placeholder="متن پاسخ نظر"></x-textarea>
                    <button type="submit" class="btn btn-yeknokte_ir">ارسال پاسخ</button>
                </form>

            </div>
        @else
            <p class="bg-fafafa text-warning padding-12-30">برای ارسال پاسخ لطفا آن را تایید نمایید.</p>
        @endif
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection
