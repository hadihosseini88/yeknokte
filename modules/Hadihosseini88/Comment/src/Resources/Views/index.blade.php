@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('comments.index') !!}" class="is-active" title="نظرات">نظرات</a></li>
@endsection

@section('content')

    <div class="main-content">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item {{ request()->status == '' ? 'is-active':'' }}"
                   href="{{ route('comments.index') }}"> همه نظرات</a>
                <a class="tab__item {{ request()->status == 'approved' ? 'is-active':'' }}"
                   href="{{ route('comments.index') }}?status=approved">نظرات تاییده شده</a>
                <a class="tab__item {{ request()->status == 'new' ? 'is-active':'' }}"
                   href="{{ route('comments.index') }}?status=new">نظرات تاییده نشده</a>
                <a class="tab__item {{ request()->status == 'rejected' ? 'is-active':'' }}"
                   href="{{ route('comments.index') }}?status=rejected">نظرات رد شده</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در نظرات">
                        <div class="t-header-search-content ">
                            <input type="text" name="body" class="text" placeholder="قسمتی از متن">
                            <input type="text" name="email" class="text" placeholder="ایمیل">
                            <input type="text" name="name" class="text margin-bottom-20"
                                   placeholder="نام و نام خانوادگی">
                            <button type="submit" class="btn btn-yeknokte_ir">جستجو</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table__box">
            <table class="table">
                <thead role="rowgroup">
                <tr role="row" class="title-row">
                    <th>شناسه</th>
                    <th>ارسال کننده</th>
                    <th>برای</th>
                    <th>دیدگاه</th>
                    <th>تاریخ</th>
                    <th>تعداد پاسخ ها</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr role="row">
                        <td><a href="">{{ $comment->id }}</a></td>
                        <td><a href="{{ route('users.info', $comment->user->id) }}">{{ $comment->user->name }}</a></td>
                        <td><a href="{{ $comment->commentable->path() }}">{{ $comment->commentable->title }}</a></td>
                        <td>{{ $comment->body }}</td>
                        <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($comment->created_at) }}</td>
                        <td>{{ $comment->comments->count() }} ({{ $comment->not_approved_comments_count }} جدید)</td>
                        <td class="commentStatus {{ $comment->getStatusCssClass() }}">@lang($comment->status)</td>
                        <td>
                            @can(\Hadihosseini88\RolePermissions\Models\Permission::PERMISSION_MANAGE_COMMENTS)
                                <a href="" onclick="deleteItem(event,'{{ route('comments.destroy', $comment->id) }}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href=""
                                   onclick="updateConfirmationStatus(event, '{{ route('comments.reject', $comment->id) }}','آیا از رد این آیتم اطمینان دارید؟','رد شده','commentStatus')"
                                   class="item-reject mlg-15" title="رد"></a>
                            @endcan
                            <a href="{{ route('comments.show', $comment->id) }}" target="_blank" class="item-eye mlg-15"
                               title="مشاهده"></a>
                            @can(\Hadihosseini88\RolePermissions\Models\Permission::PERMISSION_MANAGE_COMMENTS)
                                <a href=""
                                   onclick="updateConfirmationStatus(event, '{{ route('comments.accept', $comment->id) }}','آیا از تایید این آیتم اطمینان دارید؟','تایید شده','commentStatus')"
                                   class="item-confirm mlg-15" title="تایید"></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="/panel/js/tagsInput.js"></script>
@endsection

