<div class="sidebar__nav border-top border-left  ">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="./home"></a>

    <x-user-photo></x-user-photo>

    <ul>
        @foreach(config('sidebar.items') as $sidebarItem)
            @if(!array_key_exists('permission', $sidebarItem) || auth()->user()->hasPermissionTo($sidebarItem['permission'])
            || auth()->user()->hasPermissionTo(\Hadihosseini88\RolePermissions\Models\Permission::PERMISSION_SUPER_ADMIN))
            <li class="item-li {{$sidebarItem['icon']}} @if(str_starts_with(request()->url(), $sidebarItem['url'])) is-active @endif">
                <a href="{{$sidebarItem['url']}}">{{$sidebarItem['title']}}</a></li>
            @endif
        @endforeach

    </ul>
    <ul>
{{--        <li class="item-li i-courses "><a href="courses.html">دوره ها</a></li>--}}
        {{--    <li class="item-li i-users"><a href="users.html"> کاربران</a></li>--}}
        {{--    <li class="item-li i-categories"><a href="categories.html">دسته بندی ها</a></li>--}}
        {{--    <li class="item-li i-slideshow"><a href="slideshow.html">اسلایدشو</a></li>--}}
        {{--    <li class="item-li i-banners"><a href="banners.html">بنر ها</a></li>--}}
        {{--    <li class="item-li i-articles"><a href="articles.html">مقالات</a></li>--}}
        {{--    <li class="item-li i-ads"><a href="ads.html">تبلیغات</a></li>--}}
        {{--    <li class="item-li i-comments"><a href="comments.html"> نظرات</a></li>--}}
        {{--    <li class="item-li i-tickets"><a href="tickets.html"> تیکت ها</a></li>--}}
        {{--    <li class="item-li i-discounts"><a href="discounts.html">تخفیف ها</a></li>--}}
        {{--    <li class="item-li i-transactions"><a href="transactions.html">تراکنش ها</a></li>--}}
        {{--    <li class="item-li i-checkouts"><a href="checkouts.html">تسویه حساب ها</a></li>--}}
        {{--    <li class="item-li i-checkout__request "><a href="checkout-request.html">درخواست تسویه </a></li>--}}
        {{--    <li class="item-li i-my__purchases"><a href="mypurchases.html">خرید های من</a></li>--}}
        {{--    <li class="item-li i-my__peyments"><a href="mypeyments.html">پرداخت های من</a></li>--}}
        {{--    <li class="item-li i-notification__management"><a href="notification-management.html">مدیریت اطلاع رسانی</a>--}}
        {{--    </li>--}}
{{--        <li class="item-li i-user__inforamtion"><a href="user-information.html">اطلاعات کاربری</a></li>--}}
    </ul>
</div>
