@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection

@section('class')
    {{ $class }}
@endsection

@section("content")
    <main class="page-content py-5">
        <div class="container">

            <div class="row">

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">الحجوزات</h4>
                    </div>
                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-lg-row flex-md-column flex-sm-row flex-column">
                        <ul class="nav nav-tabs border-0 pr-lg-2 pr-0 text-center justify-content-center"
                            id="new-branch-tabs"
                            role="tablist">

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold active"
                                   id="current-tab"
                                   data-toggle="tab"
                                   href="#current"
                                   role="tab"
                                   aria-controls="current"
                                   aria-selected="true">
                                    الحجوزات الحالية
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="prev-tab"
                                   data-toggle="tab"
                                   href="#prev"
                                   role="tab"
                                   aria-controls="prev"
                                   aria-selected="false">
                                    الحجوزات السابقة
                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->
                        {{--<div class="sort-by dropdown font-body-md text-gray align-self-center my-2">--}}
                            {{--<span class="dropdown-toggle cursor"--}}
                                  {{--data-toggle="dropdown"--}}
                                  {{--aria-expanded="false"--}}
                                  {{--aria-haspopup="true">--}}
                                {{--فرز حسب:--}}
                            {{--</span>--}}
                            {{--<div class="dropdown-menu text-right">--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">التاريخ</a>--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">رقم الحجز</a>--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">عدد الأشخاص</a>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="current"
                             role="tabpanel"
                             aria-describedby="current-tab">


                                @foreach($reservations as $reservation)
                                    @if($reservation->status_id == "1" || $reservation->status_id == "2")
                                        <div class="p-3 rounded-lg shadow-around mt-4">

                                            <div class="media align-items-center flex-column flex-lg-row">
                                                <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                                     src="{{ ($reservation->user_image_url) ? $reservation->user_image_url : url("/storage/app/public/users/avatar.png") }}"
                                                     style="width:70px;height:70px"
                                                     alt="Generic placeholder image">

                                                <div class="media-body">
                                                    <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                        {{ $reservation->username }} - {{$reservation -> branch_name}}
                                                    </h5>
                                                    <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                رقم الحجز: <span class="reservation-number">{{ $reservation->reservation_code }}</span>
                                            </span>
                                                        <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                عدد الأشخاص: <span class="reservation-person">{{ $reservation->seats_number }}</span>
                                            </span>
                                                        <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <span class="reservation-date">
                                                    <time datetime="2018-10-25 17:30">
                                                        {{ $reservation->reservation_time }} {{ $reservation->time_extention }} - {{ $reservation->reservation_date }}
                                                    </time>
                                                </span>
                                            </span>
                                                    </p>

                                                     
                           @if(!empty($reservationDetails -> special_reservation) && $reservationDetails -> special_reservation !=null )
                                <p>                                    
                                      وصف المناسبه <br>

                                     
                                </p>

                                 <span class="text-gray font-body-md mb-0">  
                                      {{$reservationDetails -> occasion_description}}
                                  </span>
                            @endif


                                                </div><!-- .media-body -->


                                                @component('Provider.includes.reservation-status')
                                                    @slot('id')
                                                        {{ $reservation->reservation_id }}
                                                    @endslot

                                                    @slot('statusname')
                                                        {{ $reservation->status_name }}
                                                    @endslot

                                                    {{ $reservation->status_id }}
                                                @endcomponent

                                            </div><!-- .media -->

                                        </div>
                                    @endif
                                @endforeach


                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="prev"
                             role="tabpanel"
                             aria-labelledby="prev-tab">


                            @foreach($reservations as $reservation)
                                @if($reservation->status_id == "3" || $reservation->status_id == "4")
                                <div class="p-3 rounded-lg shadow-around mt-4">

                                    <div class="media align-items-center flex-column flex-lg-row">
                                        <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                             src="{{ ($reservation->user_image_url) ? $reservation->user_image_url : url("/storage/app/public/users/avatar.png") }}"
                                             style="width:70px;height:70px"
                                             alt="Generic placeholder image">

                                        <div class="media-body">
                                            <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                {{ $reservation->username }}
                                            </h5>
                                            <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                رقم الحجز: <span class="reservation-number">{{ $reservation->reservation_code }}</span>
                                            </span>
                                                <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                عدد الأشخاص: <span class="reservation-person">{{ $reservation->seats_number }}</span>
                                            </span>
                                                <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <span class="reservation-date">
                                                    <time datetime="2018-10-25 17:30">
                                                        {{ $reservation->reservation_time }} {{ $reservation->time_extention }} - {{ $reservation->reservation_date }}
                                                    </time>
                                                </span>
                                            </span>
                                            </p>
                                        </div><!-- .media-body -->


                                        @component('Provider.includes.reservation-status')
                                            @slot('id')
                                                {{ $reservation->reservation_id }}
                                            @endslot

                                            @slot('statusname')
                                                {{ $reservation->status_name }}
                                            @endslot

                                            {{ $reservation->status_id }}
                                        @endcomponent

                                    </div><!-- .media -->

                                </div>
                                @endif
                            @endforeach


                        </div><!-- .tab-pane -->

                        {{ $reservations->links("Pagination.pagination") }}

                    </div><!-- .tab-content -->
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection