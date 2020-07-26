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


                <div class="col-lg-12 col-md-12 col-12 mt-4 mt-md-0 ">

                    @if(count($providers) > 0)
                        <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                            <h4 class="page-title mb-auto">{{trans('site.show_results')}}  {{  $query  }}</h4>

                            <!--<div class="orders-sort dropdown font-body-md text-gray align-self-center">
                            <span class="dropdown-toggle cursor"
                                  data-toggle="dropdown"
                                  aria-expanded="false"
                                  aria-haspopup="true">
                                فرز حسب:
                            </span>
                                <div class="dropdown-menu text-right">
                                    <a href="#"
                                       class="dropdown-item bg-white text-gray">الأقرب</a>
                                    <a href="#"
                                       class="dropdown-item bg-white text-gray">التاريخ</a>
                                    <a href="#"
                                       class="dropdown-item bg-white text-gray">رقم الحجز</a>
                                    <a href="#"
                                       class="dropdown-item bg-white text-gray">عدد الأشخاص</a>
                                </div>
                            </div>-->

                        </div><!-- .section-header -->
                    @endif

                    <div class="row">

                        @if(count($providers) > 0)

                            @foreach($providers as $provider)

                                <div class="col-12 col-lg-4 mt-4">
                                    <div class="rounded-lg shadow-around bg-white text-center py-3">
                                        <img class="rounded-circle mb-lg-0 mb-3"
                                             src="{{ $provider->image_url }}"
                                             alt="{{ $provider->name }}"
                                             style="width:90px;height:90px">
                                        <p class="my-1 font-body-bold"><a
                                                    href="{{ url("/restaurant-page/" . $provider->id) }}">{{ $provider->name }}</a>
                                        </p>
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
                                            <span class="font-body-md">{{ $provider->mealAveragePrice }} {{trans('site.riyal')}}</span>
                                            <!--
                                            <img src="assets/img/-e-mark-icon.svg"
                                            class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md">10 كم</span> -->
                                        </div>

                                    </div>
                                </div>

                            @endforeach
                    </div>
                        @else

                            <div class="col-12 mt-4 mt-md-0 font-body-bold">
                                <div class="section-header d-flex p-3 rounded-lg shadow-around justify-content-center flex-lg-row flex-md-column flex-sm-row flex-column">
                                    <p class="text-center">{{ trans('site.empty-search-results') }}</p>
                                </div>
                            </div>
                        @endif


                    {{ $providers->links('Pagination.pagination') }}
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection
@if(count($providers) == 0)
@section('style')

    .site-footer{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    }

@endsection
@endif