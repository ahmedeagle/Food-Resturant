@extends('Site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')

    <main class="page-content py-5">
        <div class="container">
            <div class="row">

                @if(auth('web')->check())
                    @include("User.includes.menu")
                @endif

                <div class="@if(auth('web')->check()) col-lg-9 col-md-8 @else col-lg-12 col-md-11 @endif col-12 mt-4 mt-md-0 ">
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">{{ $cat_name }}</h4>

                        {{--<div class="orders-sort dropdown font-body-md text-gray align-self-center">--}}
                        {{--<span class="dropdown-toggle cursor"--}}
                              {{--data-toggle="dropdown"--}}
                              {{--aria-expanded="false"--}}
                              {{--aria-haspopup="true">--}}
                            {{--فرز حسب:--}}
                        {{--</span>--}}
                            {{--<div class="dropdown-menu text-right">--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">الأقرب</a>--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">التاريخ</a>--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">رقم الحجز</a>--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">عدد الأشخاص</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    </div><!-- .section-header -->


                    <div class="row">






                        @if(count($providers) > 0)

                            @foreach($providers as $provider)

                                <div class="col-12 col-lg-4 mt-4">

                                    <div style="height: 100%;" class="rounded-lg shadow-around bg-white text-center py-3">

                                        <img class="rounded-circle mb-lg-0 mb-3"
                                             src="{{ $provider->image_url }}"
                                             style="width:90px;height:90px"
                                             alt="Generic placeholder image">


                                        <p class="my-1 font-body-bold"><a href="{{ url("/restaurant-page/" . $provider-> id) }}">{{ $provider->name }}</a></p>

                                        <div>

                                            @php
                                                $count = 0;
                                            @endphp
                                            @for($i = 1; $i <= (int)$provider->averageRate; $i++)
                                                <img src="{{ url("/assets/site/img/-e-rating-icon.svg") }}"
                                                     class="img-fluid d-inline mx-auto">

                                                @php
                                                    $count++
                                                @endphp
                                            @endfor
                                            @if($count < 5)
                                                @for($i = $count+1; $i <= 5; $i++)
                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                         class="img-fluid d-inline mx-auto">
                                                @endfor
                                            @endif


                                        </div>
                                        <div>

                                            @if($provider->has_booking == "1")
                                                <img src="{{ url("/assets/site/img/-e-reserved-icon.svg") }}"
                                                     class="img-fluid d-inline mx-auto my-2">
                                            @endif

                                            @if($provider->has_delivery == "1")
                                                <img src="{{ url("/assets/site/img/-e-delivery-icon.svg") }}"
                                                     class="img-fluid d-inline mx-auto my-2 pr-2">
                                            @endif

                                        </div>
                                        <div>
                                            <img src="{{ url("/assets/site/img/-e-money-icon.svg") }}"
                                                 class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md">{{ $provider->mealAveragePrice }} ر.س</span>

                                            {{--<img src="assets/img/-e-mark-icon.svg"--}}
                                            {{--class="img-fluid d-inline mx-auto my-2 pr-2">--}}
                                            {{--<span class="font-body-md">10 كم</span>--}}
                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        @else

                            <p class="mt-4">قائمة المطاعم فارغة</p>

                        @endif


                    </div>




                    {{--<nav aria-label="Page navigation" class="d-flex justify-content-center mt-5">--}}
                        {{--<ul class="pagination pr-0">--}}
                            {{--<li class="page-item active">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                   {{--href="#">1</a>--}}
                            {{--</li>--}}
                            {{--<li class="page-item">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                   {{--href="#">2</a>--}}
                            {{--</li>--}}
                            {{--<li class="page-item">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                   {{--href="#">3</a>--}}
                            {{--</li>--}}
                            {{--<span>...</span>--}}
                            {{--<li class="page-item">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                   {{--href="#">التالي</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</nav>--}}

                </div><!-- .col-* -->

            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection