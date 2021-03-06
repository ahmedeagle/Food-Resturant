<header class="site-header shadow-bottom py-lg-0 py-3 bg-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg font-body-bold px-0">
            <a href="{{ url('/user/dashboard') }}" class="navbar-brand site-logo mr-0 col-3">
                <img src="{{ url('/assets/site/img/logo.png') }}"
                     width="115"
                     height="56"
                     alt="Site Logo">
            </a><!-- .site-logo -->
            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#top-navigation"
                    aria-controls="top-navigation"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end col-lg-9 col-md px-1" id="top-navigation">

                <form id="user-search-form" method = "POST" action="{{ url('/search') }}">
                    {{ csrf_field() }}
                </form>

                <div class="input-group input-group-sm mb-0 justify-content-end align-items-center flex-lg-row">
                    <input type="search" form="user-search-form" name="query" class="form-control border-gray font-body-md text-gray d-sm-inline-flex" placeholder="{{trans('site.search_for')}}" aria-label="" aria-describedby="basic-addon1" required>
                    <div class="input-group-prepend d-inline d-sm-inline-flex">
                        <button form="user-search-form" class="btn btn-primary py-1 px-4" type="submit">{{trans('site.search')}}</button>
                    </div>
                </div>


                

                <div class="client-area mt-lg-0 mt-md-2 mt-sm-0 d-flex justify-content-center flex-column flex-lg-row align-items-center">

@if(auth('web') -> check())
                    <a class="d-inline-flex m-2 mr-md-3 ml-sm-0">
                        <img src="{{ url('/assets/site/img/-e-wallet-icon.svg') }}" class="ml-2" width="25"
                        height="25">
                        <h2 class="font-size-base font-body-md ml-2 mb-1 wallet">{{ \App\Http\Controllers\User\BalanceController::get_balance() }} {{trans('site.riyal')}}</h2>
                    </a>

                    <a class="text-gray m-2 mr-md-2" href="{{ url('/user/cart') }}">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </a>

                    <a class="text-gray m-2 navigation mr-md-2" href="{{ url('/user/notifications') }}">
                        @if(\App\Http\Controllers\User\NotificationController::getUserNotification(true) > 0)
                            <span class="badge badge-light bg-primary">

                                {{ \App\Http\Controllers\User\NotificationController::getUserNotification(true) }}

                            </span>
                        @endif
                        <i class="fas fa-bell fa-lg"></i>

                    </a>
                    <a href="{{ url('/user/profile') }}" class="mr-0 mr-md-2">
                        <img src="{{ \App\Http\Controllers\User\ProfileController::get_image() }}"
                            class="rounded-circle bg-medium"
                            width="65"
                            height="65"
                            alt="avatar">
                    </a>
                    @endif
                </div><!-- .client-area -->

 
            </div>
            {{--@if(Session::has('empty-query'))--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xl-7 col-lg-9 col-md-11 col-sm-12 col-12 mx-auto">--}}
                        {{--{{ Session::get('empty-query') }}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}
        </nav>
    </div>
</header><!-- .site-header -->