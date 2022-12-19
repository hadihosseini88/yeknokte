@component('mail::message')
# یک کامنت جدید برای دوره ی "{{ $comment->commentable->title }}" ارسال شده است

مدرس گرامی یک کامنت جدید برای دوره ی "{{ $comment->commentable->title }}" در یک نکته ارسال شده است.

جهت رفتن به دوره کیک کنید.
@component('mail::button',['url' => $comment->commentable->path()])
مشاهده دوره
@endcomponent

با تشکر، <br>
{{ config('app.name') }}
@endcomponent
