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


                @if(Session::has("success"))
                    <div class="alert alert-success top-margin">
                        {{ Session::get("success") }}
                    </div>
                @endif

                @if(Session::has("error"))
                    <div class="alert alert-danger top-margin">
                        {{ Session::get("error") }}
                    </div>
                @endif

                <div class="p-3 rounded-lg shadow-around my-4">

                    <div class="media align-items-center flex-column flex-lg-row">
                        <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                             src="{{ ($reservationDetails->user_image_url == null) ? url("/storage/app/public/users/avatar.png") : $reservationDetails->user_image_url }}"
                             style="width:90px;height:90px"
                             alt="Generic placeholder image">

                        <div class="media-body">

                            <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                {{ $reservationDetails->username }}
                            </h5>

                            <p class="text-gray font-body-md mb-0">
                                <span class="d-block">
                                    رقم الحجز: <span class="reservation-number">{{ $reservationDetails->reservation_code }}</span>
                                </span>
                                <span class="d-block">
                                        عدد الأشخاص: <span class="reservation-person">{{ $reservationDetails->seats_number }}</span>
                                </span>
                                <span class="d-block">
                                    <span class="reservation-date">
                                        الوقت والتاريخ:
                                        <time datetime="2018-10-25 17:30">
                                             {{ $reservationDetails->reservation_time }} {{ $reservationDetails->time_extention }} - {{ $reservationDetails->reservation_date }}
                                        </time>
                                    </span>
                                </span>
                            </p>

                              <p>
                                
                                  djfdfndfndfj
                            </p>

                        </div><!-- .media-body -->
                        <span class="py-2 bg-warning text-white mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
                                {{ $reservationDetails->status_name }}
                        </span>
                    </div><!-- .media -->

                </div>

                <a href="{{ url("/restaurant/reservations/list/1") }}" class="btn btn-primary px-5">العودة</a>

            </div><!-- .col-* -->
        </div><!-- .row -->

    </div><!-- .container -->
</main><!-- .page-content -->
@endsection