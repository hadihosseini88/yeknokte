<!DOCTYPE html>
<html lang="fa">
@include('Dashboard::layouts.head')
<body>
@include('Dashboard::layouts.sidebar')
<div class="content">
    @include('Dashboard::layouts.header')
    @include('Dashboard::layouts.breadcrumb')


    <div class="main-content">
        @yield('content')
    </div>
</div>
</body>
@include('Dashboard::layouts.foot')
</html>
