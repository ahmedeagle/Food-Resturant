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
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">{{trans('site.orders')}}</h4>
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
                                   {{trans('site.current_orders')}}
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
                                    {{trans('site.previous_orders')}}
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
                                   {{--class="dropdown-item bg-white text-gray">رقم الطلب</a>--}}
                                {{--<a href="#"--}}
                                   {{--class="dropdown-item bg-white text-gray">السعر</a>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="current"
                             role="tabpanel"
                             aria-describedby="current-tab">
                            @if(count($currentOrders) > 0)
                                @foreach($currentOrders as $order)
                                    @if($order->status_id == "1" || $order->status_id == "2" || $order->status_id == "3")
                                        <div class="p-3 rounded-lg shadow-around mt-4">

                                            <div class="media align-items-center flex-column flex-lg-row">
                                                <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                                     style="width:70px;height:70px"
                                                     src="{{ ($order->user_image_url == null) ? url("/storage/app/public/users/avatar.png") : $order->user_image_url }}"
                                                     alt="Generic placeholder image">

                                                <div class="media-body">
                                                    <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                        {{ $order->username }}
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
                                                            <span class="order-price">{{ $order->total_price }}</span> {{trans('site.riyal')}}
                                                        </span>
                                                    </p>
                                                </div><!-- .media-body -->
                                                @component('User.pages.order.order-status')
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
                                    @endif
                                @endforeach

                                {{ $currentOrders->links("Pagination.pagination") }}

                            @else

                                <div class="mt-4">{{trans('site.orders_list_empty')}}</div>

                            @endif
                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="prev"
                             role="tabpanel"
                             aria-labelledby="prev-tab">
                            @if(count($previousOrders) > 0)
                                @foreach($previousOrders as $order)
                                    @if($order->status_id == "4" || $order->status_id == "5")
                                        <div class="p-3 rounded-lg shadow-around mt-4">

                                            <div class="media align-items-center flex-column flex-lg-row">
                                                <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                                     src="{{ ($order->user_image_url == null) ? url("/storage/app/public/users/avatar.png") : $order->user_image_url }}"
                                                     style="width:70px;height:70px"
                                                     alt="Generic placeholder image">

                                                <div class="media-body">
                                                    <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                        {{ $order->username }}
                                                    </h5>
                                                    <p class="text-gray font-body-md mb-0">
                                                        <span class="d-block d-lg-inline">
                                                            {{trans('site.order_num')}}<span class="order-number">{{ $order->order_code }}</span>
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
                                                            <span class="order-price">{{ $order->total_price }}</span> {{trans('site.riyal')}}
                                                        </span>
                                                    </p>
                                                </div><!-- .media-body -->
                                                @component('User.pages.order.order-status')
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
                                    @endif
                                @endforeach
                                {{ $previousOrders->links("Pagination.pagination") }}

                            @else
                                <div class="mt-4">{{trans('site.orders_list_empty')}}</div>
                            @endif
                        </div><!-- .tab-pane -->


                    </div><!-- .tab-content -->
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



