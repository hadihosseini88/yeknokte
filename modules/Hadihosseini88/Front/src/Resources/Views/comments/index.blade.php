<div class="container">
    <div class="comments">
        @include('Front::comments.create', ['commentable'=> $course])

        <div class="comments-list">
            @include('Front::comments.reply', ['commentable'=> $course])
            @foreach($commentable->approvedComments as $comment)
                <ul class="comment-list-ul">
                    <div class="div-btn-answer">
                        <button class="btn-answer" onclick="setCommentId({{ $comment->id }})">پاسخ به دیدگاه</button>
                    </div>
                    <li class="is-comment">
                        <div class="comment-header">
                            <div class="comment-header-avatar">
                                <img src="{{ $comment->user->thumb }}" alt="{{ $comment->user->name }}">
                            </div>
                            <div class="comment-header-detail">
                                <div class="comment-header-name">کاربر : {{ $comment->user->name }}</div>
                                <div class="comment-header-date">{{ $comment->created_at }} روز پیش</div>
                            </div>
                        </div>
                        <div class="comment-content">
                            <p>
                                {{ $comment->body }}
                            </p>
                        </div>
                    </li>
                    @foreach($comment->comments as $reply)
                    <li class="is-answer">
                        <div class="comment-header">
                            <div class="comment-header-avatar">
                                <img src="{{ $reply->user->thumb }}">
                            </div>
                            <div class="comment-header-detail">
                                <div class="comment-header-name">مدیر سایت : {{ $reply->user->name }}</div>
                                <div class="comment-header-date">{{ $reply->created_at }} روز پیش</div>
                            </div>
                        </div>
                        <div class="comment-content">
                            <p>
                                {{ $reply->body }}
                            </p>
                        </div>
                    </li>
                    @endforeach
{{--                    <li class="is-comment">--}}
{{--                        <div class="comment-header">--}}
{{--                            <div class="comment-header-avatar">--}}
{{--                                <img src="img/profile.jpg">--}}
{{--                            </div>--}}
{{--                            <div class="comment-header-detail">--}}
{{--                                <div class="comment-header-name">کاربر : گوگل</div>--}}
{{--                                <div class="comment-header-date">10 روز پیش</div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="comment-content">--}}
{{--                            <p>--}}
{{--                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان--}}
{{--                                گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و--}}
{{--                                برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای--}}
{{--                                کاربردی می باشد.--}}
{{--                            </p>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                </ul>
            @endforeach
        </div>
    </div>
</div>
