<div class="col-12 bg-white margin-bottom-15 border-radius-3">
    <p class="box__title">سرفصل ها</p>
    <form action="{{ route('seasons.store', $course->id) }}" method="post" class="padding-30">
        @csrf
        <x-input type="text" name="title" placeholder="عنوان سرفصل" class="text" required></x-input>
        <x-input type="text" name="number" placeholder="شماره سرفصل" class="text"></x-input>

        <button type="submit" class="btn btn-yeknokte_ir" style="margin-top: 10px;">اضافه کردن</button>
    </form>

    <div class="table__box padding-30">
        <table class="table">
            <thead role="rowgroup">
            <tr role="row" class="title-row">

                <th class="p-r-90">ردیف</th>
                <th>عنوان فصل</th>
                <th class="p-r-90">شماره فصل</th>
                <th>وضعیت تایید</th>
                <th>وضعیت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($course->seasons as $season)
            <tr role="row" class="">
                <td><a href="">{{ $loop->index + 1 }}</a></td>
                <td><a href="">{{ $season->title }}</a></td>
                <td><a href="">{{ $season->number }}</a></td>
                <td class="confirmation_status
                        @switch($season->confirmation_status)
                            @case('accepted')
                                text-success
                            @break
                            @case('rejected')
                                text-error
                            @break
                            @case('pending')
                                text-pending
                            @break
                        @endswitch

                    ">@lang($season->confirmation_status)</td>
                <td class="status">@lang($season->status)</td>
                <td>
                    <a href="" onclick="deleteItem(event,'{{route('seasons.destroy', $season->id)}}')" class="item-delete mlg-15"  title="حذف"></a>
                    <a href="" onclick="updateConfirmationStatus(event,'{{route('seasons.reject', $season->id)}}','آیا از رد این آیتم اطمینان دارید؟','رد شده')" class="item-reject mlg-15" title="رد"></a>
                    <a href="" onclick="updateConfirmationStatus(event,'{{route('seasons.accept', $season->id)}}','آیا از تایید این آیتم اطمینان دارید؟','تایید شده')" class="item-confirm mlg-15" title="تایید"></a>
                    @if($season->status == \Hadihosseini88\Course\Models\Season::STATUS_OPENED)
                    <a href="" onclick="updateConfirmationStatus(event,'{{route('seasons.lock', $season->id)}}','آیا از قفل این آیتم اطمینان دارید؟','قفل شده','status')"
                       class="item-lock mlg-15 text-error" title="قفل فصل"></a>
                    @else
                    <a href="" onclick="updateConfirmationStatus(event,'{{route('seasons.unlock', $season->id)}}','آیا از باز این آیتم اطمینان دارید؟','باز','status')"
                       class="item-lock mlg-15 text-success" title="باز کردن فصل"></a>
                    @endif
                    <a href="{{ route('seasons.edit', $season->id) }}" class="item-edit " title="ویرایش"></a>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
