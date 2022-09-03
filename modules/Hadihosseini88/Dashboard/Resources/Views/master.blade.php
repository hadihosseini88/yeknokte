<!DOCTYPE html>
<html lang="fa">
@include('Dashboard::layouts.head')
<body>
@include('Dashboard::layouts.sidebar')
<div class="content">
    @include('Dashboard::layouts.header')
    @include('Dashboard::layouts.breadcrumb')

        @yield('content')

</div>
</body>
@include('Dashboard::layouts.foot')
</html>
