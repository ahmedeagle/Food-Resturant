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
                        <h4 class="page-title">{{trans('site.orders')}}</h4>
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

                    <div class="py-3 rounded-lg shadow-around my-4">

                        <div class="row align-items-center flex-column flex-lg-row px-3 px-lg-0">
                            <div class="col-lg-2 col-12">
                                <img class="rounded-circle mb-lg-0 mb-3 d-block mx-auto img-fluid"
                                     src="{{ ($orderDetails->user_image_url) ? $orderDetails->user_image_url : url("/storage/app/public/users/avatar.png")}}"
                                     style="width:90px;height:90px"
                                     alt="Generic placeholder image">
                            </div>

                            <div class="col-xl-7 col-lg-6 col-12 pr-lg-0">
                                <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                    {{ $orderDetails->username }}
                                </h5>

                                <p class="text-gray font-body-md mb-0">
                                    <span class="d-block">
                                           {{trans('site.order_num')}}: <span
                                                class="orders-number">{{ $orderDetails->order_code }}</span>
                                    </span>
                                    <span class="d-block">
                                        <span class="orders-date">
                                           {{trans('site.time_date')}}
                                            <time datetime="2018-10-25 17:30">
                                                {{ $orderDetails->order_date }} - {{ $orderDetails->time_extention }} {{ $orderDetails->order_time }}
                                            </time>
                                        </span>
                                    </span>
                                    <span class="d-block">
                                            {{trans('site.payment_method')}}:  <span
                                                class="orders-payment">{{ $orderDetails->payment_name }}</span>
                                    </span>
                                    <span class="d-block">
                    {{trans('site.status')}}:
                    <span class="orders-address">

                        {{$orderDetails -> is_delivery  == 1 ? trans('site.delivery') : trans('site.fromResturant')}}
                      </span>
                </span>
                                </p>

                            </div><!-- .media-body -->
                            <div class="col-xl-3 col-lg-4 col-auto mt-3 mt-lg-0 font-body-md text-lg-center">
                                <span class="py-2 bg-pending text-white d-lg-inline d-block px-3 rounded-curved">
                                    {{ $orderDetails->status_name }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border-light border">
                        </div>

                        <div class="row px-3 px-lg-0">
                            <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
                                <h6 class="font-size-base text-lg-right text-center">
                                    {{trans('site.details')}}:
                                </h6>


                                @php
                                    $sum = 0;
                                @endphp
                                @foreach($meals as $meal)

                                    <div class="item d-flex justify-content-between font-body-md text-gray">
                                        <div class="item-details">
                                            <p class="item-head mb-auto">{{ $meal->meal_name }}</p>
                                            <div class="item-body d-flex flex-row">
                                                <span class="price">{{ $meal->meal_price }}</span>
                                                &times;
                                                <span class="count">{{ $meal->meal_qty }}</span>
                                                &nbsp;
                                                <span class="currency">{{trans('site.riyal')}}</span>
                                            </div>

                                            <!-- start meal options -->
                                            @php
                                                $options_sum = 0;
                                            @endphp
                                            @if(count($meal->options) > 0)
                                                <p class="item-head mb-auto">{{trans('site.adds')}}</p>
                                                @foreach($meal->options as $option)

                                                    <div class="item-body d-flex flex-row">
                                                        <span class="price">{{ $option->option_name }}</span>
                                                        : {{trans('site.added_price')}} :
                                                        <span class="count"> {{ $option->added_price }} </span>
                                                        &nbsp;
                                                        <span class="currency"> {{trans('site.riyal')}} </span>
                                                    </div>
                                                    @php
                                                        $options_sum  = $options_sum + $option->added_price;
                                                    @endphp
                                                @endforeach

                                            @endif
                                        <!-- end meal options -->

                                            <!-- start meal adds -->
                                            @php
                                                $adds_sum = 0;
                                            @endphp
                                            @if(count($meal->adds) > 0)
                                                <p class="item-head mb-auto">{{trans('site.options')}}</p>
                                                @foreach($meal->adds as $add)

                                                    <div class="item-body d-flex flex-row">
                                                        <span class="price">{{ $add->add_name }}</span>
                                                        : {{trans('site.added_price')}} :
                                                        <span class="count"> {{ $add->added_price }} </span>
                                                        &nbsp;
                                                        <span class="currency"> {{trans('site.riyal')}} </span>
                                                    </div>
                                                @php
                                                    $adds_sum  = $adds_sum + $add->added_price;
                                                @endphp
                                            @endforeach

                                        @endif
                                        <!-- end meal adds -->

                                        </div>
                                        <div class="result text-primary">
                                            <span class="total">{{ ( ( (int)$meal->meal_price + $options_sum + $adds_sum ) * ( (int)$meal->meal_qty ) )  }}</span>
                                            <span class="currency"> {{trans('site.riyal')}}</span>
                                        </div>
                                    </div><!-- .item -->
                                    <hr class="border-light border">
                                    @php
                                        $sum = $sum + ( ( (int)$meal->meal_price + $options_sum + $adds_sum ) * ( (int)$meal->meal_qty ) );
                                    @endphp

                                @endforeach


                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base">{{trans('site.total')}}:</h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total">{{ $sum }}</span>
                                        <span class="currency">{{trans('site.riyal')}}</span>
                                    </div>
                                </div>
                                @php
                                    $taxData = DB::table("app_settings")
                                   ->first();

                                $orderTax = $taxData->order_tax;

                                @endphp


                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base">{{trans('site.tax')}}: </h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total">{{ ($sum * $orderTax ) / 100 }} </span>
                                        <span class="currency">{{trans('site.riyal')}} ({{$orderDetails -> order_tax}} %)</span>
                                    </div>
                                </div>

                                @if($orderDetails -> is_delivery)

                                    <div class="invoice d-flex justify-content-between mt-3">
                                        <h6 class="font-size-base">{{trans('site.delivery_price')}}: </h6>
                                        <div class="result text-primary font-body-md">
                                            <span class="total">{{ $orderDetails -> delivery_price}}</span>
                                            <span class="currency">{{trans('site.riyal')}}</span>
                                        </div>
                                    </div>
                                @endif


                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base">{{trans('site.total_all')}}: </h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total">{{ $orderDetails ->  total_price}}</span>
                                        <span class="currency">{{trans('site.riyal')}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <hr class="border-light border">
                    </div>

                    <div class="row px-3 px-lg-0">
                        <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
                            <div class="order-confirm text-center text-sm-right">
                                <a href="{{ url("/restaurant/orders/decline-order/" . $orderDetails->order_id) }}"
                                   class="btn btn-primary px-xl-5 px-md-3 px-sm-5 px-5 ml-0 mt-2 ml-sm-2"
                                >
                                    {{trans('site.cancel_order')}}
                                </a>
                                <a href="{{ url("/restaurant/orders/accept-order/" . $orderDetails->order_id) }}"
                                   class="btn btn-primary px-xl-5 px-md-3 px-sm-5 px-5 mt-2"
                                >
                                    {{trans('site.confirm_order')}}
                                </a>

                            </div>
                        </div>
                        <a href="{{ url("/restaurant/orders/list/1") }}"
                           class="btn btn-primary px-5"> {{trans('site.back')}}</a>


                    </div>

                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title"> موقع العميل </h4>
                    </div>
                    <div class="py-3 rounded-lg shadow-around my-4">


                        @if($orderDetails -> is_delivery)
                            <div class="col-xl-7 col-lg-6 col-12 pr-lg-0 " style=" width: 500px; height: 400px;">
                                <div id="map-user"></div>
                            </div><!-- .media-body -->
                        @endif

                    </div>
                </div>


            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection


@section('script')

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&callback=initMap">
    </script>


    <script>
        // Initialize and add the map
        function initMap() {
            var uluru = {lat: {{$orderDetails -> user_latitude }} , lng: {{$orderDetails -> user_longitude}}  };
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map-user'), {zoom: 15, center: uluru});
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
            });
        }
    </script>



@stop