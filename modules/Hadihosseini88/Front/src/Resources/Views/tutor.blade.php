@extends('Front::layout.master')



@section('content')

    <main id="index">
        <div class="bt-0-top article mr-202"></div>
        <div class="bt-1-top">
            <div class="container">
                <div class="tutor">
                    <div class="tutor-item">
                        <div class="tutor-avatar">
                            <span class="tutor-image" id="tutor-image"><img src="{{ $tutor->thumb }}"
                                                                            class="tutor-avatar-img"></span>
                            <div class="tutor-author-name">
                                <a id="tutor-author-name" href="{{ route('singleTutor', $tutor->username) }}"
                                   title="{{ $tutor->name }}">
                                    <h3 class="title"><span class="tutor-author--name">{{ $tutor->name }}</span></h3>
                                </a>
                            </div>
                            <div id="Modal1" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="close">&times;</div>
                                    </div>
                                    <div class="modal-body">
                                        <img class="tutor--avatar--img" src="" alt="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tutor-item">
                        <div class="stat">
                            <span class="tutor-number tutor-count-courses">{{ count($tutor->courses) }}</span>
                            <span class="">تعداد دوره ها</span>
                        </div>
                        <div class="stat">

                            <span class="tutor-number">{{ $tutor->studentsCount() }}</span>
                            <span class="">تعداد دانشجویان</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="box-filter">
                <div class="b-head">
                    <h2>دوره های {{$tutor->name}}</h2>
                </div>
                <div class="posts">
                    @foreach($tutor->courses as $courseItem)
                        @include('Front::layout.singleCourseBox')
                    @endforeach
{{--                        <div class="col">--}}
{{--                            <a href="react.html">--}}
{{--                                <div class="course-status">--}}
{{--                                    تکمیل شده--}}
{{--                                </div>--}}
{{--                                <div class="discountBadge">--}}
{{--                                    <p>45%</p>--}}
{{--                                    تخفیف--}}
{{--                                </div>--}}
{{--                                <div class="card-img"><img src="img/banner/reactjs.png" alt="reactjs"></div>--}}
{{--                                <div class="card-title"><h2>دوره مقدماتی تا پیشرفته reactJs</h2></div>--}}
{{--                                <div class="card-body">--}}
{{--                                    <img src="img/profile.png" alt="سیدهادی حسینی">--}}
{{--                                    <span>سیدهادی حسینی</span>--}}
{{--                                </div>--}}
{{--                                <div class="card-details">--}}
{{--                                    <div class="time">135:40:00</div>--}}
{{--                                    <div class="price">--}}
{{--                                        <div class="discountPrice">159,000</div>--}}
{{--                                        <div class="endPrice">270,000</div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </div>--}}
                </div>
            </div>


{{--            <div class="pagination">--}}
{{--                <a href="" class="pg-prev"></a>--}}
{{--                <a href="" class="page current">1</a>--}}
{{--                <a href="" class="page ">2</a>--}}
{{--                <a href="" class="page ">3</a>--}}
{{--                <a href="" class="page ">4</a>--}}
{{--                <a href="" class="page ">5</a>--}}
{{--                <a href="" class="page ">6</a>--}}
{{--                <a href="" class="page ">7</a>--}}
{{--                <a href="" class="page ">...</a>--}}
{{--                <a href="" class="page ">100</a>--}}
{{--                <a href="" class="pg-next"></a>--}}
{{--            </div>--}}
        </div>
    </main>

@endsection

@section('js')
    <script src="/js/modal.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/modal.css">
@endsection
