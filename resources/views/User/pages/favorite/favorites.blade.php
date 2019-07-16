@extends("User.layouts.master")

@section("title")
    {{ $title }}
@endsection

@section("class")
    {{ $class }}
@endsection

@section("content")

    <main class="page-content py-5">
        <div class="container">
            <div class="row">

                @include("User.includes.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">المفضلة</h4>
                    </div>

                    @if(Session::has('success'))
                        <div class="alert alert-success top-margin">

                            {{ Session::get('success') }}

                        </div>
                    @endif

                    <div class="row">


                        @if(count($branches) > 0)

                            @foreach($branches as $favorite)

                                <div class="col-12 col-lg-4 mt-4">

                                    <div class="fav-box rounded-lg shadow-around bg-white text-center py-3">
                                        <a href="{{ url("/user/favorites/remove/" . $favorite->branch_id) }}" class="delete-x">&times;</a>

                                        <img class="rounded-circle mb-lg-0 mb-3"
                                             src="{{ $favorite->image_url }}"
                                             style="width:90px;height:90px"
                                             alt="Generic placeholder image">


                                        <p class="my-1 font-body-bold"><a href="{{ url("/restaurant-page/" . $favorite->branch_id) }}">{{ $favorite->name }}</a></p>

                                        <div>

                                            @php
                                                $count = 0;
                                            @endphp
                                            @for($i = 1; $i <= (int)$favorite->averageRate; $i++)
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

                                            @if($favorite->has_booking == "1")
                                                <img src="{{ url("/assets/site/img/-e-reserved-icon.svg") }}"
                                                     class="img-fluid d-inline mx-auto my-2">
                                            @endif

                                            @if($favorite->has_delivery == "1")
                                                <img src="{{ url("/assets/site/img/-e-delivery-icon.svg") }}"
                                                     class="img-fluid d-inline mx-auto my-2 pr-2">
                                            @endif

                                        </div>
                                        <div>
                                            <img src="{{ url("/assets/site/img/-e-money-icon.svg") }}"
                                                 class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md">{{ $favorite->mealAveragePrice }} ر.س</span>

                                            {{--<img src="assets/img/-e-mark-icon.svg"--}}
                                                 {{--class="img-fluid d-inline mx-auto my-2 pr-2">--}}
                                            {{--<span class="font-body-md">10 كم</span>--}}
                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        @else

                            <p class="mt-4">قائمة المفضلة فارغة</p>

                        @endif

                    </div> <!-- .row -->

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



