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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">

                    @if(Session::has("success"))

                        <div class="alert alert-success top-margin">
                            {{ Session::get("success") }}
                        </div>

                    @endif
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">السلة</h4>
                    </div>




                    @if(count($cart) > 0)
                    @foreach($cart as $key => $item)

                    <div class="py-3 py-lg-2 rounded-lg shadow-around my-4 bg-white">

                        <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                            <img class="ml-2 mr-2 rounded mb-lg-0 mb-3"
                                 src="{{ $item['meal_image_url'] }}"
                                 draggable="false"
                                 style="width: 132px;height: 132px;"
                                 alt="Generic placeholder image">

                            <div class="media-body">

                                <h5 class="mt-lg-1 mt-md-0 mt-xs-0 text-lg-right text-center font-body-bold font-size-base">
                                    <a href="user-mealpage.html">
                                        {{ $item['meal_name'] }}
                                    </a>
                                </h5>

                                <div class="mb-0 mt-1 mt-sm-0 ">
                                    <p class="d-flex flex-row text-gray font-body-md mb-0 justify-content-center justify-content-lg-start">
                                        <span class="price">{{ $item['price'] }}</span>
                                        &times;
                                        <span class="count">{{ $item['qty'] }}</span>
                                        &nbsp;
                                        <span class="currency">ر.س</span>
                                    </p>
                                </div>


                                <p class="mt-lg-1 mt-md-0 mt-xs-0 mb-lg-0 text-lg-right text-center font-body-md font-size-base">
                                    الإضافات:
                                    <span class="text-gray">{{ $item['addsNameString'] }} ( السعر المضاف : {{ $item['addsAddedPrice'] }} ر.س)</span>
                                </p>

                                <p class="mt-lg-1 mt-md-0 mt-xs-0 mb-lg-0 text-lg-right text-center font-body-md font-size-base">
                                    التفضيلات:
                                    <span class="text-gray">{{ $item['optionsNameString'] }}   ( السعر المضاف : {{ $item['optionsAddedPrice'] }} ر.س)</span>
                                </p>

                            </div><!-- .media-body -->

                            <a href="{{ url("/user/cart/remove-cart-meal/" . $key) }}" class="cancel-btn py-1 px-4 mt-lg-4 no-bg border border-primary d-lg-inline d-block rounded text-primary font-body-md ml-lg-3">إلغاء</a>


                        </div><!-- .media -->

                    </div>

                    @endforeach

                        <a href="{{ url("/user/cart/complete-order") }}" class="btn btn-primary px-5">التالي</a>
                    @else

                        <div class="mt-4">محتويات السلة فارغة</div>

                    @endif



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



