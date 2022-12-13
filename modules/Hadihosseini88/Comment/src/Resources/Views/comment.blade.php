<div class="transition-comment {{ $isAnswer ? 'is-answer' : '' }}">
    <div class="transition-comment-header">
        <span>
            <img src="{{ $comment->user->thumb }}" class="logo-pic">
        </span>
        <span class="nav-comment-status" style="top: unset">
            <p class="username">کاربر : {{ $comment->user->name }}</p>
            <p class="comment-date">{{ $comment->created_at->diffForHumans() }}</p>
                <p class="p_status">
            @if($isAnswer)
                <a href=""
                   onclick="updateConfirmationStatus(event, '{{ route('comments.accept', $comment->id) }}','آیا از تایید این آیتم اطمینان دارید؟','تایید شده','commentStatus','p.p_status','span.')"
                   class="item-confirm mlg-15" title="تایید"></a>
                <a href=""
                   onclick="updateConfirmationStatus(event, '{{ route('comments.reject', $comment->id) }}','آیا از رد این آیتم اطمینان دارید؟','رد شده','commentStatus','p.p_status','span.')"
                   class="item-reject mlg-15" title="رد"></a>
                <a href=""
                   onclick="deleteItem(event,'{{ route('comments.destroy', $comment->id) }}','div.transition-comment')"
                   class="item-delete mlg-15" title="حذف"></a>
            @endif
                <span class="commentStatus {{ $comment->getStatusCssClass() }}">@lang($comment->status)</span>
            </p>
        </span>
    </div>
    <div class="transition-comment-body">
        <pre>{{ $comment->body }}</pre>
    </div>
</div>
