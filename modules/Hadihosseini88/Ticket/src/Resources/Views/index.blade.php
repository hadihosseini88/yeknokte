@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{!! route('tickets.index') !!}" class="is-active" title="تیکت ها">تیکت ها</a></li>
@endsection

@section('content')

    <div class="main-content tickets">
        <div class="tab__box">
            <div class="tab__items">
                <a class="tab__item is-active" href="{!! route('tickets.index') !!}">همه تیکت ها</a>
                <a class="tab__item " href="tickets.html">جدید ها (خوانده نشده)</a>
                <a class="tab__item " href="tickets.html">پاسخ داده شده ها</a>
                <a class="tab__item " href="{!! route('tickets.create') !!}">ارسال تیکت جدید</a>
            </div>
        </div>
        <div class="bg-white padding-20">
            <div class="t-header-search">
                <form action="" onclick="event.preventDefault();">
                    <div class="t-header-searchbox font-size-13">
                        <input type="text" class="text search-input__box font-size-13" placeholder="جستجوی در تیکت ها">
                        <div class="t-header-search-content ">
                            <input type="text" class="text" placeholder="ایمیل">
                            <input type="text" class="text " placeholder="نام و نام خانوادگی">
                            <input type="text" class="text margin-bottom-20" placeholder="تاریخ">
                            <btutton class="btn btn-yeknokte_ir">جستجو</btutton>
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
                    <th>موضوع</th>
                    <th>نام ارسال کننده</th>
                    <th>ایمیل ارسال کننده</th>
                    <th>آخرین بروزرسانی</th>
                    <th>وضعیت</th>
                    @can(\Hadihosseini88\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                        <th>عملیات</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @foreach($tickets as $ticket)
                    <tr role="row"
                        @if($ticket->status == \Hadihosseini88\Ticket\Models\Ticket::STATUS_CLOSE) class="close-status" @endif >
                        <td><a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->id }}</a></td>
                        <td><a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->title }}</a></td>
                        <td><a href="">{{ $ticket->user->name }}</a></td>
                        <td><a href="">{{ $ticket->user->email }}</a></td>
                        <td>{{ $ticket->updated_at }}</td>
                        <td class="{{ $ticket->getStatusCssClass() }}">@lang($ticket->status)</td>
                        @can(\Hadihosseini88\RolePermissions\Models\Permission::PERMISSION_MANAGE_TICKETS)
                            <td>
                                <a href="" onclick="deleteItem(event,'{{ route('tickets.destroy', $ticket->id) }}')"
                                   class="item-delete mlg-15" title="حذف"></a>
                                <a href="{{ route('tickets.show', $ticket->id) }}" target="_blank"
                                   class="item-eye mlg-15" title="مشاهده"></a>
                                <a href="{{ route('tickets.close', $ticket->id) }}" class="item-confirm "
                                   title="بستن تیکت"></a>
                            </td>
                        @endcan
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
