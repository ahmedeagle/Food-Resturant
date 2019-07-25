<main class="page-content py-5">
    <div class="container">

        <div class="row">

            @include("Provider.pages.menu")

            <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">

                <div class="orders-section">

                    <div class="section-header d-flex p-3 rounded-lg shadow-around justify-content-between flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">{{trans('site.orders')}}</h4>

                        {{--<div class="orders-sort dropdown font-body-md text-gray align-self-center">--}}
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

                    </div><!-- .section-header -->

                    <div class="section-content">

                        @if(count($orders) > 0)
                        @foreach($orders as $order)

                            <div class="p-3 rounded-lg shadow-around mt-4">

                                <div class="media align-items-center flex-column flex-lg-row">
                                    <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                         src="{{ ($order->user_image_url) ? $order->user_image_url : url("/storage/app/public/users/avatar.png") }}"
                                         style="width:70px;height:70px"
                                         alt="Generic placeholder image">
                                    
                                    <div class="media-body">
                                        <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                            {{ $order->username }}  - {{$order -> branch_name}}
                                        </h5>
                                        <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                {{trans('site.order_num')}} <span class="order-number">{{ $order->order_code }}</span>
                                            </span>

                                            <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <span class="order-date">
                                                    <time>{{ $order->order_time }}</time>
                                                    {{ $order->time_extention }}
                                                </span>
                                            </span>

                                            <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">-</span>
                                                <span class="order-price">{{ $order->total_price }}</span>{{trans('site.riyal')}}
                                            </span>
                                        </p>
                                    </div><!-- .media-body -->
                                    @component('Provider.includes.order-status')
                                        @slot('id')
                                            {{ $order->order_id }}
                                        @endslot

                                        @slot('statusname')
                                            {{ $order->status_name }}
                                        @endslot

                                        {{ $order->status_id }}
                                    @endcomponent
                                </div><!-- .media -->

                            </div>

                        @endforeach

                        @else
                            <div class="mt-4">
                                {{ trans("provider.empty-orders") }}
                            </div>
                        @endif


                        {{--{{ $orders->links("Pagination.pagination") }}--}}
                        @if(count($orders) > 0)
                            <div class="mb-4 mt-5 text-center">
                                <a href="{{ url("/restaurant/orders/list/1") }}"
                                class="more-link font-body-bold btn px-5 btn-primary">{{trans('site.more')}}</a>
                            </div>
                        @endif
                    </div><!-- .section-content -->

                </div><!-- .orders-section -->

                <div class="reservation-section mt-5">

                    <div class="section-header d-flex p-3 rounded-lg shadow-around justify-content-between flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">{{trans('site.reservations')}}</h4>

                        {{--<div class="reservation-sort dropdown font-body-md text-gray align-self-center">--}}
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

                    </div><!-- .section-header -->

                    <div class="section-content">
                        @if(count($reservations) > 0)
                        @foreach($reservations as $reservation)

                            <div class="p-3 rounded-lg shadow-around mt-4">

                                <div class="media align-items-center flex-column flex-lg-row">
                                    <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                         style="width:70px;height:70px"
                                         src="{{ ($reservation->user_image_url) ? $reservation->user_image_url : url("/storage/app/public/users/avatar.png") }}"
                                         alt="Generic placeholder image">

                                    <div class="media-body">
                                        <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                            {{ $reservation->username }} - {{$reservation -> branch_name}}
                                        </h5>
                                        <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                   {{trans('site.reservation_num')}} <span class="reservation-number">{{ $reservation->reservation_code }}</span>
                                            </span>
                                            <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                 {{trans('site.person_num')}}    : <span class="reservation-person">{{ $reservation->seats_number }}</span>
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

                        @endforeach
                        @else
                            <div class="mt-4">
                                {{ trans("provider.empty-reservations") }}
                            </div>
                        @endif


                        {{--{{ $reservations->links("Pagination.pagination") }}--}}
                        @if(count($reservations) > 0)
                            <div class="mb-4 mt-5 text-center">
                                <a href="{{ url("/restaurant/reservations/list/1") }}"
                                class="more-link font-body-bold btn px-5 btn-primary">{{trans('site.more')}}</a>
                            </div>
                        @endif
                    </div><!-- .section-content -->

                </div><!-- .reservation-section -->

            </div><!-- .col-* -->
        </div><!-- .row -->

    </div><!-- .container -->
</main><!-- .page-content -->