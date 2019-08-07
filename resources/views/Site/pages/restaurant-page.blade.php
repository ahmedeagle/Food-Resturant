@extends('Site.layouts.master')

@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')
    <main class="page-content py-5">
        <div class="container">


            <div class="row">

                @if(auth('web')->user())
                    @include("User.includes.menu")
                @endif
                <div class="@if(auth('web')->user()) col-lg-9 col-md-8 col-12 @else col-lg-12 col-md-11 col-12 @endif mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{ $branch->name }}</h4>
                    </div>

                    @if(Session::has('success'))
                        <div class="alert alert-success top-margin">

                            {{ Session::get('success') }}

                        </div>
                    @endif

                    @if(Session::has('error'))
                        <div class="alert alert-danger top-margin">

                            {{ Session::get('error') }}

                        </div>
                    @endif

                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-lg-row flex-md-column flex-sm-column flex-column bg-white">
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
                                     {{trans('site.details')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="features-tab"
                                   data-toggle="tab"
                                   href="#features"
                                   role="tab"
                                   aria-controls="features"
                                   aria-selected="false">
                                    {{trans('site.advantages')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="reservations-tab"
                                   data-toggle="tab"
                                   href="#reservations"
                                   role="tab"
                                   aria-controls="reservations"
                                   aria-selected="false">
                                   {{trans('site.reservations')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="menu-tab"
                                   data-toggle="tab"
                                   href="#menu"
                                   role="tab"
                                   aria-controls="menu"
                                   aria-selected="false">
                                  {{trans('site.food_list')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="comments-tab"
                                   data-toggle="tab"
                                   href="#comments"
                                   role="tab"
                                   aria-controls="comments"
                                   aria-selected="false">
                                   {{trans('site.comments')}}
                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->
                    </div>


                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="current"
                             role="tabpanel"
                             aria-describedby="current-tab">


                            <div class="mael-pic mt-4 rounded-lg shadow-around bg-white">

                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                                    <ol class="carousel-indicators">
                                        @foreach($branch->images as $key => $img)
                                            <li data-target="#carouselExampleControls" data-slide-to="{{ $key }}" class="@if($key == 0) active @endif"></li>
                                        @endforeach
                                    </ol>

                                    <div class="carousel-inner">

                                        @foreach($branch->images as $key => $img)

                                            <div class="carousel-item @if($key == 0) active @endif">
                                                <img style="width:825px;height:331px" class="d-block w-100" src="{{ $img->image_url }}" alt="First slide" draggable="false">
                                            </div>

                                        @endforeach

                                    </div>

                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">{{trans('site.previous')}}</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">{{trans('site.next')}}</span>
                                    </a>
                                </div>


                                <!-- <div class="d-flex justify-content-center flex-sm-row">
                                    <p class="page-content font-body-md text-gray py-2 py-3 px-3">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                                    </p>
                                    <span class="love mt-xs-5 ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mr-sm-3 mt-2 mb-auto mt-sm-auto rounded-lg shadow-around">
                                        <i class="fa fa-heart fa-lg text-white cursor"></i>
                                    </span>

                                </div> -->

                                <div class="d-flex justify-content-center flex-column flex-sm-row pb-3">
                                    <p class="page-content font-body-md text-gray py-3 px-3 mb-0">
                                        {{ $branch->description }}
                                    </p>
                                    @if(auth('web')->user())

                                        @if($branch->is_favorite)
                                            <a href="{{ url("/user/favorites/remove/" . $branch->id) }}">
                                                    <span title="{{ trans("user.remove-favorite") }}" style="background:#97246b" class="love rounded-lg shadow-around ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mt-2 mt-sm-auto mr-3">
                                                        <i class="fa fa-heart fa-lg text-white cursor text-center justify-content-center align-items-center"></i>
                                                    </span>
                                            </a>
                                        @else
                                            <a href="{{ url("/user/favorites/add/" . $branch->id) }}">
                                                    <span title="{{ trans("user.add-favorite") }}" class="love rounded-lg shadow-around ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mt-2 mt-sm-auto mr-3">
                                                        <i class="fa fa-heart fa-lg text-white cursor text-center justify-content-center align-items-center"></i>
                                                    </span>
                                            </a>
                                        @endif
                                    @endif

                                </div>

                            </div>
                            <div class="p-3 rounded-lg shadow-around mt-3 bg-white">

                                <div class="row">
                                    <div class="res-column-one col-sm-4 col font-body-md ">
                                        <p>{{trans('site.work_hours')}}</p>
                                        <p>{{trans('site.average_price')}}</p>
                                        <p>{{trans('site.food_type')}}</p>
                                        <p>{{trans('site.address')}}</p>
                                        <p>{{trans('site.services')}}</p>
                                    </div>
                                    <div class="res-column-two col-sm-8 col text-gray font-body-md">
                                        <p>الأحد :-@if($branch_working_hours->sunday_start_work != null) من {{ $branch_working_hours->sunday_start_work }} {{ $branch_working_hours->sunday_start_work_extention }} حتى {{ $branch_working_hours->sunday_end_work }} {{ $branch_working_hours->sunday_end_work_extention }} @else لا يعمل @endif
                                            <a style="color:#97246b;text-decoration: underline;cursor: pointer"
                                                  data-toggle="modal"
                                                  title="مشاهدة جميع اوقات العمل"
                                                  data-target="#confirm-delete"
                                                  aria-hidden="true">
                                            <i class="fas fa-eye"></i>        
                                            </a>
                                        </p>
                                        <p>{{ $branch->menu_average_price }} {{trans('site.riyal')}}</p>
                                        <p>{{ $branch->categories_string }}</p>
                                        <p>{{ !empty($branch->address) ?  $branch->address : '' }}</p>
                                        <div>
                                            @if($branch->has_delivery || $branch->has_booking)
                                                @if($branch->has_booking)
                                                    <img src="{{ url('/assets/site/img/-e-reserved-icon.svg') }}"
                                                         class="img-fluid d-inline mx-auto my-2">
                                                @endif

                                                @if($branch->has_delivery)
                                                    <img src="{{ url('/assets/site/img/-e-delivery-icon.svg') }}"
                                                         class="img-fluid d-inline mx-auto my-2 pr-2">
                                                @endif

                                            @else
                                                <p>{{trans('site.no_services')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Working Hours Modal -->

                            <div class="modal fade"
                                 id="confirm-delete"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content py-3">
                                        <p class="modal-body h4 font-weight-bold text-center mb-auto">
                                           {{trans('site.work_hours')}}
                                        </p>
                                        <div style="padding: 15px;" class="form-group">

                                        <p>الأحد :-@if($branch_working_hours->sunday_start_work != null) من {{ $branch_working_hours->sunday_start_work }} {{ $branch_working_hours->sunday_start_work_extention }} حتى {{ $branch_working_hours->sunday_end_work }} {{ $branch_working_hours->sunday_end_work_extention }} @else لا يعمل @endif</p>

                                        <p>الاثنين :-@if($branch_working_hours->monday_start_work != null) من {{ $branch_working_hours->monday_start_work }} {{ $branch_working_hours->monday_start_work_extention }} حتى {{ $branch_working_hours->monday_end_work }} {{ $branch_working_hours->monday_end_work_extention }} @else لا يعمل @endif</p>

                                        <p>الثلاثاء :-@if($branch_working_hours->tuesday_start_work != null) من {{ $branch_working_hours->tuesday_start_work }} {{ $branch_working_hours->tuesday_start_work_extention }} حتى {{ $branch_working_hours->tuesday_end_work }} {{ $branch_working_hours->tuesday_end_work_extention }} @else لا يعمل @endif</p>

                                        <p>الاربعاء :-@if($branch_working_hours->wednesday_start_work != null) من {{ $branch_working_hours->wednesday_start_work }} {{ $branch_working_hours->wednesday_start_work_extention }} حتى {{ $branch_working_hours->wednesday_end_work }} {{ $branch_working_hours->wednesday_end_work_extention }} @else لا يعمل @endif</p>

                                        <p>الخميس :-@if($branch_working_hours->thursday_start_work != null) من {{ $branch_working_hours->thursday_start_work }} {{ $branch_working_hours->thursday_start_work_extention }} حتى {{ $branch_working_hours->thursday_end_work }} {{ $branch_working_hours->thursday_end_work_extention }} @else لا يعمل @endif</p>
                                        <hr />
                                        <p>الجمعة :-@if($branch_working_hours->friday_start_work != null) من {{ $branch_working_hours->friday_start_work }} {{ $branch_working_hours->friday_start_work_extention }} حتى {{ $branch_working_hours->friday_end_work }} {{ $branch_working_hours->friday_end_work_extention }} @else لا يعمل @endif</p>
                                        <hr />
                                        <p>السبت :-@if($branch_working_hours->saturday_start_work != null) من {{ $branch_working_hours->saturday_start_work }} {{ $branch_working_hours->saturday_start_work_extention }} حتى {{ $branch_working_hours->saturday_end_work }} {{ $branch_working_hours->saturday_end_work_extention }} @else لا يعمل @endif</p>

                                        </div>
                                        <div class="modal-footer d-flex justify-content-center pt-0">
                                            <button type="button"
                                                    class="top-margin btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                                    data-dismiss="modal">  {{trans('site.cancel')}} </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Working Hours Modal -->
                            <div class="rounded-lg shadow-around mt-3">
                                <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                                    {{--<iframe class="embed-responsive-item"--}}
                                    {{--src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d192882.79659999761!2d-73.86776777721985!3d40.95593697131265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1suber+near+Vailsburg+Park%2C+South+Orange+Avenue%2C+Newark%2C+NJ%2C+USA!5e0!3m2!1sen!2seg!4v1537878398432"></iframe>--}}
                                    <input type="hidden" id="latitude" value="{{ $branch->latitude }}" />
                                    <input type="hidden" id="longitude" value="{{ $branch->longitude }}" />
                                    <input type="hidden" id="branch_name" value="{{ $branch->name }}" />
                                    <div id="map" class="embed-responsive-item"></div>
                                </div>

                            </div>


                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="features"
                             role="tabpanel"
                             aria-labelledby="features-tab">

                            <div class="row">


                                @if(count($branch->options) > 0)
                                    @foreach($branch->options as $option)
                                        <div class="col-12 col-lg-3 mt-4">
                                            <div class="rounded-lg shadow-around bg-white text-center py-3 font-body-md">
                                                <img src="{{ $option->option_image_url }}"
                                                     class="img-fluid d-inline mx-auto">
                                                <p  class="pt-3 mb-1">{{ $option->option_name }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else

                                    <p class="mt-4">{{trans('site.advantages_list_empty')}}</p>

                                @endif
                            </div>

                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="reservations"
                             role="tabpanel"
                             aria-labelledby="reservations-tab">

                            <div class="row">
                                @if($branch->has_booking)

                                    @if($branch->booking_status == 0 || $branch->booking_status == 2)
                                        <div class="col-12 col-lg-4 mt-4">
                                            <div class="rounded-lg shadow-around bg-white text-center  font-body-md">
                                                <a href="{{ url("/user/reservations/add-reservation/" . $branch->id ."/0") }}"
                                                   class="text-center no-decoration text-secondary p-4 d-block">
                                                    <img src="{{ url('/assets/site/img/reservations-menu/-e-persons-icon.svg') }}"
                                                         class="img-fluid d-block mx-auto"
                                                         alt="">
                                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                                        {{trans('site.persons')}}
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    @if($branch->booking_status == 1 || $branch->booking_status == 2)
                                        <div class="col-12 col-lg-4 mt-4">
                                            <div class="rounded-lg shadow-around bg-white text-center font-body-md">
                                                <a href="{{ url("/user/reservations/add-reservation/". $branch->id ."/1") }}"
                                                   class="text-center no-decoration text-secondary p-4 d-block">
                                                    <img src="{{ url('/assets/site/img/reservations-menu/-e-families-icon.svg') }}"
                                                         class="img-fluid d-block mx-auto"
                                                         alt="">
                                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                                        {{trans('site.famlies')}}
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                @else

                                    <div class="col-12 col-lg-4 mt-4">{{trans('site.recieve_reservation_service_stoped')}}</div>

                                @endif
                            </div>

                        </div><!-- .tab-pane -->



                        <div class="tab-pane fade"
                             id="menu"
                             role="tabpanel"
                             aria-describedby="menu-tab">

                            @if(count($mealCategories) > 0)
                                @foreach($mealCategories as $c)
                                    <div class="py-2 pr-3 rounded-lg mt-3 shadow-around bg-white">
                                        <h4 class="page-title font-body-bold">{{ $c->cat_name }}</h4>
                                    </div>

                                    <div class="row">
                                        @foreach($c->meals as $meal)
                                            <div class="col-12 col-lg-6 mt-3">
                                                <div class="rounded-lg shadow-around bg-white py-2 font-body-md">

                                                    <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                                        <img class="ml-2 mr-2 rounded mb-lg-0 mb-3"
                                                             src="{{ $meal->image_url }}"
                                                             draggable="false"
                                                             style="width:105px;height:105px"
                                                             alt="Generic placeholder image">

                                                        <div class="media-body">

                                                            <h5 class="mt-lg-3 mt-md-0 mt-xs-0 text-lg-right text-center font-body-md font-size-base">
                                                                <a href="{{ url('/meal-page/' . $meal->meal_id) }}">
                                                            {{ $meal->meal_name }}
                                                                </a>
                                                            </h5>

                                                            <p class="text-primary font-body-md mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center">

                                                            <span class="d-block">
                                                                {{ $meal->price }}  {{trans('site.riyal')}}
                                                            </span>

                                                            </p>
                                                        </div><!-- .media-body -->

                                                    </div><!-- .media -->

                                                </div>
                                            </div>
                                        @endforeach
                                    </div> <!-- .row -->
                                @endforeach

                            @else
                                <p class="mt-4">{{trans('site.meals_list_empty')}}</p>
                            @endif
                        </div><!-- .tab-pane -->


                        <div class="tab-pane fade"
                             id="comments"
                             role="tabpanel"
                             aria-describedby="comments-tab">

                            @if(auth('web')->user())
                                <a href="new-branch.html"
                                   class="btn btn-primary no-decoration mt-3 px-5"
                                   data-toggle="modal"
                                   data-target="#add-comment"
                                   aria-hidden="true"
                                >
                                     {{trans('site.add_comment')}}
                                </a>


                                <div class="modal fade mt-5"
                                     id="add-comment"
                                     tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content py-1 ">
                                            <div class="modal-body pb-0">
                                                <form>

                                                    <p class="mb-1">
                                                        {{trans('site.what_rate_forService')}}
                                                    </p>

                                                    <div class="text-lg-right  pb-1 rating-stars">


                                                        <ul id='service-stars'>

                                                            @if(!$branch->is_user_rate_branch)

                                                                <li class='star' title='1' data-value='1'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='2' data-value='2'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='3' data-value='3'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='4' data-value='4'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='5' data-value='5'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>

                                                            @else



                                                                @php
                                                                    $count = 0;
                                                                @endphp

                                                                @for($i = 1; $i <= (int)$branch->user_service_rate; $i++)
                                                                    <li class='star' title='{{ $i }}' data-value='{{ $i }}'>
                                                                        <img src="{{ url("/assets/site/img/-e-rating-icon.svg") }}"
                                                                             class="img-fluid d-inline mx-auto">
                                                                    </li>

                                                                    @php
                                                                        $count++
                                                                    @endphp
                                                                @endfor

                                                                @if($count < 5)
                                                                    @for($i = $count+1; $i <= 5; $i++)
                                                                        <li class='star' title="{{ $i }}" data-value='{{ $i }}'>
                                                                            <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                                 class="img-fluid d-inline mx-auto">
                                                                        </li>
                                                                    @endfor
                                                                @endif


                                                            @endif
                                                        </ul>

                                                    </div>

                                                    <p class="mb-1">
                                                       {{trans('site.what_rate_forCleaning')}}
                                                    </p>

                                                    <div class="text-lg-right  pb-1 rating-stars">


                                                        <ul id='cleanliness-stars'>

                                                            @if(!$branch->is_user_rate_branch)

                                                                <li class='star' title='1' data-value='1'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='2' data-value='2'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='3' data-value='3'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='4' data-value='4'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='5' data-value='5'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>

                                                            @else



                                                                @php
                                                                    $count = 0;
                                                                @endphp

                                                                @for($i = 1; $i <= (int)$branch->user_cleanliness_rate; $i++)
                                                                    <li class='star' title='{{ $i }}' data-value='{{ $i }}'>
                                                                        <img src="{{ url("/assets/site/img/-e-rating-icon.svg") }}"
                                                                             class="img-fluid d-inline mx-auto">
                                                                    </li>

                                                                    @php
                                                                        $count++
                                                                    @endphp
                                                                @endfor

                                                                @if($count < 5)
                                                                    @for($i = $count+1; $i <= 5; $i++)
                                                                        <li class='star' title="{{ $i }}" data-value='{{ $i }}'>
                                                                            <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                                 class="img-fluid d-inline mx-auto">
                                                                        </li>
                                                                    @endfor
                                                                @endif


                                                            @endif
                                                        </ul>

                                                    </div>

                                                    <p class="mb-1">
                                                       {{trans('site.what_rate_forvalue')}}
                                                    </p>

                                                    <div class="text-lg-right  pb-1 rating-stars">


                                                        <ul id='quality-stars'>

                                                            @if(!$branch->is_user_rate_branch)

                                                                <li class='star' title='1' data-value='1'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='2' data-value='2'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='3' data-value='3'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='4' data-value='4'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='5' data-value='5'>
                                                                    <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>

                                                            @else



                                                                @php
                                                                    $count = 0;
                                                                @endphp

                                                                @for($i = 1; $i <= (int)$branch->user_quality_rate; $i++)
                                                                    <li class='star' title='{{ $i }}' data-value='{{ $i }}'>
                                                                        <img src="{{ url("/assets/site/img/-e-rating-icon.svg") }}"
                                                                             class="img-fluid d-inline mx-auto">
                                                                    </li>

                                                                    @php
                                                                        $count++
                                                                    @endphp
                                                                @endfor

                                                                @if($count < 5)
                                                                    @for($i = $count+1; $i <= 5; $i++)
                                                                        <li class='star' title="{{ $i }}" data-value='{{ $i }}'>
                                                                            <img src="{{ url("/assets/site/img/-e-rating-icon-ncolor.svg") }}"
                                                                                 class="img-fluid d-inline mx-auto">
                                                                        </li>
                                                                    @endfor
                                                                @endif


                                                            @endif
                                                        </ul>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label"> {{trans('site.add_comment')}}</label>
                                                        <input type="hidden" id="branch_id" value="{{ $branch->id }}" />
                                                        <input type="hidden" id="is_user_rate" value="{{ $branch->is_user_rate_branch }}" />
                                                        <input type="hidden" id="is_user_can_rate" value="{{ $branch->is_user_can_rate }}" />
                                                        <input type="hidden" id="user_comment_url" value="{{ url("/user/add-comment") }}" />
                                                        <textarea id="comment-text" required class="form-control" id="message-text" cols="8" rows="5"></textarea>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer border-0  pt-0">
                                                <button type="submit" id="add-comment-btn" class="btn btn-primary btn btn-primary px-4 px-sm-5 font-weight-bold">{{trans('site.add')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="comment-cell hidden-element">

                                    <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">
                                        <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                            <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                                 src="{{ \App\Http\Controllers\User\ProfileController::get_image() }}"
                                                 draggable="false"
                                                 style="width:90px;height:90px"
                                                 alt="Generic placeholder image">

                                            <div class="media-body">

                                                <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-body-md font-size-base">
                                                    {{ auth('web')->user()->name }}
                                                </h5>

                                                <p class="text-gray font-body-md pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                                            <span class="comment-cell-text d-block">
                                                                <!-- comment text -->
                                                            </span>
                                                </p>
                                            </div><!-- .media-body -->
                                        </div><!-- .media -->
                                    </div>

                                </div>
                            @endif
                            @if(count($comments) > 0)
                                <div class="comment-container">
                                    @foreach($comments as $comment)
                                        <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">
                                            <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                                <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                                     src="{{ ($comment->user_image_url == null) ? url('/storage/app/public/users/avatar.png') : $comment->user_image_url }}"
                                                     draggable="false"
                                                     style="width:90px;height:90px"
                                                     alt="Generic placeholder image">

                                                <div class="media-body">

                                                    <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-body-md font-size-base">
                                                        {{ $comment->username }}
                                                    </h5>

                                                    <p class="text-gray font-body-md pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                                            <span class="d-block">
                                                                {{ $comment->comment }}
                                                            </span>
                                                    </p>
                                                </div><!-- .media-body -->
                                            </div><!-- .media -->
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class='mt-4'>{{trans('site.no_comments')}}</p>
                            @endif

                        </div><!-- .tab-pane -->

                    </div><!-- .tab-content -->

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection

@section("script")

   
    <script>
        
      

    var baseUrl = $('meta[name="base-url"]').attr('content');
    var rateStare = baseUrl + "/assets/site/img/-e-rating-icon.svg";
    var rateNoColor = baseUrl + "/assets/site/img/-e-rating-icon-ncolor.svg"

    var service = 0;
    var quality = 0;
    var cleanliness =0;
    /* 1. Visualizing things on Hover - See next part for action on click */

  

    /* 2. Action to perform on click */
    $('#cleanliness-stars li, #service-stars li, #quality-stars li').on('click', function(){

        var rate = $("#is_user_rate").val();
        var canRate = $("#is_user_can_rate").val();
        if(canRate == false) {
            return false;
        }

        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        if($(this).parent().attr("id") == "cleanliness-stars"){
            cleanliness = onStar;
        }

        if($(this).parent().attr("id") == "service-stars"){
            service = onStar;
        }

        if($(this).parent().attr("id") == "quality-stars"){
            quality = onStar;
        }


        for (i = 0; i < stars.length; i++) {
            $(stars[i]).find(".img-fluid").attr("src", rateNoColor);//removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).find(".img-fluid").attr("src", rateStare);//.addClass('selected');
        }

    });

    $("#add-comment-btn").on("click", function(){

        var comment = $("#comment-text").val();
        var branch_id = $("#branch_id").val();
        if(comment == ""){
            notif({
                msg: "برجاء كتابة نص التعليق",
                type: "warning"
            });
            return false;
        }

        var data = new FormData();

        data.append("cleanliness", cleanliness);
        data.append("service", service);
        data.append("quality", quality);
        data.append("id", branch_id);
        data.append("comment", comment);
        // send request
        var url = $("#user_comment_url").val();

        request(url, "POST", data, function(){}, function(data){

            $(".comment-cell").find(".comment-cell-text").html(comment);
            $(".comment-container").prepend($(".comment-cell").html());
            $("#comment-text").val("");
            $("#comment-text").blur();
            notif({
                msg: "تمت العملية بنجاح",
                type: "success"
            });

        },function (error) {

        })
    });

 
    var map, infoWindow , marker;
    var messagewindow;
    var markers = [];

 
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseFloat($("#latitude").val()), lng: parseFloat($("#longitude").val())},
            zoom: 10
        });

        infoWindow = new google.maps.InfoWindow;

        addMarker( "(" + parseFloat($('#latitude').val()) + "," + parseFloat($('#longitude').val()) +")");

        function addMarker(location) {
            // var marker = new google.maps.Marker({
            //     position: location,
            //     map: map
            // });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( parseFloat($("#latitude").val()),parseFloat($("#longitude").val())),
                map: map,
                title: $("#branch_name").val()
            });

            var contentString = '<div id="content" style="width: 200px; height: 200px;"><h1>Overlay</h1></div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);

        }




    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function request(url,type,data,beforeSend,success,error){
        $.ajax({
            url: url,
            type:type,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            processData: false,
            contentType: false,
            beforeSend: beforeSend,
            success: success,
            error:error
        });
    }
    
  
    
         
    </script>
    
       <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&callback=initMap">
    </script>
    

@endsection