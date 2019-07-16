@extends("User.layouts.master")

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

                @include("User.includes.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">الطلبات</h4>
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
                                      style="width:70px;height:70px"
                                     alt="Generic placeholder image">
                            </div>

                            <div class="col-xl-7 col-lg-6 col-12 pr-lg-0">
                                <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                    {{ $orderDetails->username }}
                                </h5>

                                <p class="text-gray font-body-md mb-0">
                                    <span class="d-block">
                                        رقم الطلب: <span class="orders-number">{{ $orderDetails->order_code }}</span>
                                    </span>
                                    <span class="d-block">
                                        <span class="orders-date">
                                            الوقت والتاريخ:
                                            <time datetime="2018-10-25 17:30">
                                                {{ $orderDetails->order_date }} - {{ $orderDetails->time_extention }} {{ $orderDetails->order_time }}
                                            </time>
                                        </span>
                                    </span>
                                    <span class="d-block">
                                        طريقة الدفع:  <span class="orders-payment">{{ $orderDetails->payment_name }}</span>
                                    </span>
                                    <span class="d-block">
                                        العنوان:
                                        <span class="orders-address">
                                            العنوان بشكل مفصل حسب ما كتبه المستخدم
                                        </span>
                                    </span>
                                </p>

                            </div><!-- .media-body -->
                            <div class="col-xl-3 col-lg-4 col-auto mt-3 mt-lg-0 font-body-md text-lg-center">
                                <span class="py-2 bg-success text-white d-lg-inline d-block px-3 rounded-curved">
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
                                    التفاصيل
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
                                                <span class="currency">ر.س</span>
                                            </div>
                                        </div>
                                        <div class="result text-primary">
                                            <span class="total">{{ ((int)$meal->meal_price) * ((int)$meal->meal_qty) }}</span>
                                            <span class="currency">ر.س</span>
                                        </div>
                                    </div><!-- .item -->
                                    @php
                                        $sum = $sum + ((int)$meal->meal_price) * ((int)$meal->meal_qty);
                                    @endphp
                                @endforeach


                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base">المجموع</h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total">{{ $sum }}</span>
                                        <span class="currency">ر.س</span>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <hr class="border-light border">
                        </div>


                    </div>

                    <a href="{{ url("/user/orders") }}" class="btn btn-primary px-5">العودة</a>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection