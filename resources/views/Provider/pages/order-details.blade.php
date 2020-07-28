<div class="py-3 rounded-lg shadow-around my-4">

    <div class="row align-items-center flex-column flex-lg-row px-3 px-lg-0">
        <div class="col-lg-2 col-12">
            <img class="rounded-circle mb-lg-0 mb-3 d-block mx-auto img-fluid"
                 src="http://placehold.it/70x70"
                 alt="Generic placeholder image">
        </div>

        <div class="col-lg-8 col-12 pr-lg-0">
            <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                {{ $orderDetails->username }}
            </h5>

            <p class="text-gray font-body-md mb-0">
                <span class="d-block">
                    {{trans('site.order_num')}}<span class="orders-number">{{ $orderDetails->order_code }}</span>
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
                        {{trans('site.payment_method')}}
                    <span class="orders-payment">
                        {{ $orderDetails->payment_name }}
                    </span>
                </span>
                <span class="d-block">
                    {{trans('site.address')}}:
                    <span class="orders-address">
                        
                        {{$orderDetails -> address}}
                      </span>
                </span>
            </p>

        </div><!-- .media-body -->
        <div class="col-lg-2 col-auto mt-3 mt-lg-0 font-body-md text-xl-center">
            <span class="py-2 bg-danger text-white d-lg-inline d-block px-3 rounded-curved">
                {{trans('site.cancelled')}}
            </span>
        </div>
    </div>

    <div class="col-12">
        <hr class="border-light border">
    </div>

    <div class="row px-3 px-lg-0">
        <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
            <h6 class="font-size-base text-lg-right text-center">
                 {{trans('site.details')}}
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
                            <span class="currency"> {{trans('site.riyal')}}</span>
                        </div>
                    </div>
                    <div class="result text-primary">
                        <span class="total">{{ ((int)$meal->meal_price) * ((int)$meal->meal_qty) }}</span>
                        <span class="currency"> {{trans('site.riyal')}}</span>
                    </div>
                </div><!-- .item -->
                @php
                    $sum = $sum + ((int)$meal->meal_price) * ((int)$meal->meal_qty);
                @endphp
            @endforeach

            <div class="invoice d-flex justify-content-between mt-3">
                <h6 class="font-size-base"> {{trans('site.total')}}</h6>
                <div class="result text-primary font-body-md">
                    <span class="total">{{ $sum }}</span>
                    <span class="currency"> {{trans('site.riyal')}}</span>
                </div>
            </div>


       
        </div>
    </div>

</div>