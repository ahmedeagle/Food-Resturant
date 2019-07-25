@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection

@section('class')
    {{ $class }}
@endsection

@section("content")
    <main class="main-content page-content py-5">
        <div class="container">

            <div class="row">

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0">

                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title font-body-bold"> {{trans('site.edit_branch')}}</h4>
                    </div>

                    @if(Session::has("warning"))
                        <div class="alert alert-warning top-margin">
                            {{ Session::get("warning") }}
                        </div>
                    @endif

                    @if(Session::has("error"))
                        <div class="alert alert-danger top-margin">
                            {{ Session::get("error") }}
                        </div>
                    @endif

                    @if(Session::has("success"))
                        <div class="alert alert-success top-margin">
                            {{ Session::get("success") }}
                        </div>
                    @endif

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <ul class="nav nav-tabs pr-lg-3 pr-0 flex-lg-row flex-md-column flex-sm-row flex-column text-center"
                            id="new-branch-tabs"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold active"
                                   id="info-tab"
                                   data-toggle="tab"
                                   href="#branch-info"
                                   role="tab"
                                   aria-controls="branch-info"
                                   aria-selected="true">
                                     {{trans('site.branch_info')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="work-tab"
                                   data-toggle="tab"
                                   href="#work"
                                   role="tab"
                                   aria-controls="work"
                                   aria-selected="false">
                                     {{trans('site.work_hours')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="cats-tab"
                                   data-toggle="tab"
                                   href="#category"
                                   role="tab"
                                   aria-controls="category"
                                   aria-selected="false">
                                    {{trans('site.existing_cats')}}
                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->

                        <div class="tab-content" id="new-branch-tabs-content">

                            <div class="tab-pane fade show active"
                                 id="branch-info"
                                 role="tabpanel"
                                 aria-labelledby="info-tab">
                                <form data-action="{{ url('/restaurant/branches/edit') }}" id="edit-branch-from" class="new-branch-form multi-forms p-3 font-body-bold">

                                    <div class="form-group">
                                        <p>{{trans('site.branch_photos')}}</p>
                                        <div class="custom-file h-auto">
                                            <input type="file" class="custom-file-input" id="restaurant-logo" hidden>
                                            <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <span class="d-inline-block border-gray rounded p-4">
                                            <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>
                                        </span>
                                            </label>
                                            <p id="branch-images-error" class="hidden-element alert alert-danger top-margin">{{trans('site.choose_branch_photos')}}</p>
                                        </div>
                                    </div><!-- .form-group logo -->

                                    <div class="top-margin add-meal-images row">
                                        @foreach($images as $img)
                                            <div>
                                                <input class="image_id" type="hidden" value="{{ $img->image_id }}" />
                                                <i class='delete-img fa fa-times' aria-hidden='true'></i>
                                                <img class='io' src='{{ $img->branch_image_url }}' />
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label for="branch-name">{{trans('site.branch_name_ar')}}</label>
                                        <input type="text"
                                               name="ar_name"
                                               value="{{ $branch->ar_name }}"
                                               class="form-control border-gray font-body-md"
                                               id="branch-name" required>
                                    </div><!-- .form-group name -->


                                    <div class="form-group">
                                        <label for="branch-name">{{trans('site.branch_name_en')}}</label>
                                        <input type="text"
                                               name="en_name"
                                               value="{{ $branch->en_name }}"
                                               class="form-control border-gray font-body-md"
                                               id="branch-name" required>
                                    </div><!-- .form-group name -->

                                    <div class="form-group">
                                        <label for="service-provider">{{trans('site.branch_type')}}</label>
                                        <select class="custom-select text-gray font-body-md" name="service-provider" id="service-provider" required>
                                            <option value="">{{trans('site.choose_branch_type')}}</option>
                                          @if(isset($cats) && $cats -> count() > 0 )
                                          <?php  $name = LaravelLocalization::getCurrentLocale()."_name"?>
                                            @foreach($cats as $cat)
                                                <option value="{{ $cat->id }}" @if($branch->category_id == $cat->id) selected @endif>{{ $cat-> $name }}</option>
                                            @endforeach
                                           @endif 
                                        </select>
                                    </div><!-- .form-group service provider -->

                                    <div class="form-group">
                                        <p>{{trans('site.services_available')}}</p>
                                        <div class="row pr-4 text-gray font-body-md">

                                            <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="has-booking"
                                                       name="has-booking" @if($branch->has_booking == "1") checked @endif>
                                                <label class="custom-control-label font-body-md"
                                                       for="has-booking">{{trans('site.accept_resservations')}}</label>
                                            </div><!-- .custom-control -->

                                            <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="has-delivery"
                                                       name="has-delivery" @if($branch->has_delivery == "1") checked @endif>
                                                <label class="custom-control-label font-body-md"
                                                       for="has-delivery">{{trans('site.delivery_orders')}}</label>
                                            </div><!-- .custom-control -->
                                            
                                            
                                             <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="has_payment"
                                                       name="has_payment" @if($branch->has_payment == "1") checked @endif>
                                                <label class="custom-control-label font-body-md"
                                                       for="has_payment">{{trans('site.elect_payment')}}</label>
                                            </div><!-- .custom-control -->


                                        </div>
                                    </div><!-- .form-group available service -->

                                    <div class="form-group">
                                        <label for="average-price">{{trans('site.delivery_price')}}</label>
                                        <div class="input-group rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="delivery-price"
                                                   name="delivery-price"
                                                   value="{{ $branch->delivery_price }}"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="average-price-addon">



                                            <div class="input-group-prepend">
                                        <span id="average-price-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->

                                        <p class="delivery-price-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group average-price -->

                                    <div class="form-group">
                                        <label for="booking-features">{{trans('site.booking_features')}}</label>
                                        <select class="custom-select text-gray font-body-md border-gray"
                                                id="booking-features" name="booking-features" required>
                                            <option value="">{{trans('site.choose_booking_features')}}</option>

                                            <option value="0" @if($branch->booking_status == "0") selected @endif>{{trans('site.persons')}}</option>
                                            <option value="1" @if($branch->booking_status == "1") selected @endif>{{trans('site.famlies')}}</option>
                                            <option value="2" @if($branch->booking_status == "2") selected @endif>{{trans('site.person_family')}}</option>
                                        </select>
                                    </div><!-- .form-group booking-features -->

                                    <div class="form-group">
                                        <label for="congestion-status">{{trans('site.congestion_status')}}</label>
                                        <select class="custom-select text-gray font-body-md border-gray"
                                                id="congestion-status" name="congestion-status" required>
                                            <option value="">{{trans('site.choose_congestion_status')}} </option>
                                            @foreach($congestion as $c)
                                                <option value="{{ $c->id }}" @if($c->id == $branch->congestion_settings_id) selected @endif>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><!-- .form-group congestion-status -->

                                    <div class="form-group">
                                        <label for="average-price">{{trans('site.average_price')}}</label>
                                        <div class="input-group rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="average-price"
                                                   name="average-price"
                                                   value="{{ $branch->average_price }}"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="average-price-addon" required>



                                            <div class="input-group-prepend">
                                        <span id="average-price-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                        <p class="average-price-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group average-price -->

                                    <div class="form-group">
                                        <p> {{trans('site.branch_properties')}}</p>
                                        <div class="row pr-4 text-gray font-body-md">

                                            <input type="hidden" name="options_count" value="{{ count($options) }}" />
                                            @foreach($options as $option)
                                                <div class="custom-control custom-checkbox pl-0 col-lg-4 col-12 mb-2">
                                                    <input type="checkbox"
                                                           class="options custom-control-input"
                                                           id="option_{{ $option->id }}"
                                                           data="{{ $option->id }}"
                                                           name="option_{{ $option->id }}" @if($option->selected == "1") checked @endif>
                                                    <label class="custom-control-label font-body-md"
                                                           for="option_{{ $option->id }}">{{ $option->name }}</label>
                                                </div><!-- .custom-control -->
                                            @endforeach
                                        </div><!-- .row -->
                                    </div><!-- .form-group branch-features -->


                                    <div class="form-group">
                                        <label for="address-text">
                                            {{trans('site.branch_address_text')}}
                                        </label>
                                        <input type="text"
                                               class="form-control border-gray font-body-md"
                                               id="address-text"
                                               value="{{ $branch->ar_address }}"
                                               name="address-text" required>
                                    </div><!-- .form-group address-text -->

                                    <div class="form-group">
                                        <label for="address-map"
                                               class="font-body-bold">{{trans('site.branch_on_map')}}</label>
                                        <div class="d-flex justify-content-center flex-column flex-sm-row">

                                          <?php $address = LaravelLocalization::getCurrentLocale().'_address' ?>
                                            <input type="text"
                                                   class="form-control border-gray"
                                                   id="address-map" value="{{ $branch-> $address }}" disabled>

                                            <input type="hidden"
                                                   name="latLng"
                                                   value="({{ $branch->latitude }},{{ $branch->longitude }})"
                                                   id="branch-latLng" />

                                            <input type="hidden"
                                                   name="lat"
                                                   value="{{ $branch->latitude }}"
                                                   id="branch-lat" />
                                            <input type="hidden"
                                                   name="lng"
                                                   value="{{ $branch->longitude }}"
                                                   id="branch-lng" />

                                            <button
                                                    type="button"
                                                    data-toggle="modal"
                                                    data-target="#confirm-location"
                                                    id="new-branch-map-btn"
                                                    class="btn btn-primary font-body-bold px-lg-5 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto">{{trans('site.go_to_map')}}</button>
                                        </div>
                                        <p class="branch-location-error alert alert-danger top-margin hidden-element"></p>
                                    </div><!-- .form-group address-map -->

                                    <div class="form-group">
                                        <label for="phone-number">
                                            {{trans('site.branch_phone')}}
                                            <span class="text-gray font-body-md">
                                                 ({{trans('site.used_for_login')}})
                                            </span>
                                        </label>
                                        <input type="text"
                                               class="form-control border-gray"
                                               id="phone-number" name="phone-number" value="{{ $branch->phone }}" required>
                                        <p class="phone-number-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group phone-number -->
                                    
                                    
                                      <div class="form-group">
                                        <label for="phone-number">
                                             {{trans('site.password')}}
                                            <span class="text-gray font-body-md">
                                                 
                                            </span>
                                        </label>
                                        
                                        <input type="text"
                                               class="form-control border-gray"
                                               id="password" name="password" placeholder="{{trans('site.password')}}"  >
                                        <p class="password-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group phone-number -->
                                    

                                    <input type="hidden" name="branch_id" value="{{ $branch->id }}" />
                                    <button type="submit" class="btn btn-primary py-2 px-5"> {{trans('site.edit')}} </button>
                                </form><!-- .new-kind-form -->
                            </div><!-- .tab-pane -->

                            <div class="tab-pane fade p-3 font-body-bold"
                                 id="work"
                                 role="tabpanel"
                                 aria-labelledby="work-tab">
                                <p id="working-hours-error" class="alert alert-danger top-margin hidden-element">{{trans('site.choose_work_hours')}} </p>
                                
                                
                                  @if(isset($branches) && $branches -> count() > 0 )
             
                 <div class="col-lg-6 col-12 mt-3 mt-lg-auto">
                    <div class="row">
                        <label for=""
                               class="col-form-label col-auto"> {{trans('site.get_times_from')}}:</label>
                        <div class="col pr-md-0">
                            <select id="autoCompeletTimes" class="working-hours custom-select text-gray font-body-md border-gray">
                                <option value="">{{trans('site.choose_branch')}}</option>
                                  
                                  <?php $br_name = LaravelLocalization::getCurrentLocale()."_name"?>
                                  @foreach($branches as $branch)
                                   <option value="{{$branch -> id}}"> {{$branch -> $br_name}} </option>
                                   @endforeach    
                                   
                             </select>
                        </div>
                    </div>
                </div>
             
            
        <br>
        
        {{ trans('site.or_manually')}}
        
        
        <br>
        
        @endif
        
        
                                <form class="work-times">


                                    @foreach($week_days as $key => $value)

                                        @php
                                            $start_time = $key . "_start_work";
                                            $end_time   = $key . "_end_work";
                                        @endphp
                                        @component('User.includes.working-time')

                                            @slot('en_name')
                                                {{ $key }}
                                            @endslot

                                            @slot('ar_name')
                                                {{ $value }}
                                            @endslot

                                            @slot("start_time")
                                                {{ $working_hours->$start_time }}
                                            @endslot
                                            @slot("end_time")
                                                {{ $working_hours->$end_time }}
                                            @endslot
                                        @endcomponent

                                    @endforeach
                                    {{--<div class="row saturday">--}}
                                        {{--<div class="col">--}}
                                            {{--<p>برجاء تحديد ساعات العمل</p>--}}
                                            {{--<div class="form-group row">--}}
                                                {{--<div class="col-lg-6 col-12">--}}
                                                    {{--<div class="row">--}}
                                                        {{--<label for="sat-open"--}}
                                                               {{--class="col-form-label col-auto">من:</label>--}}
                                                        {{--<div class="col pr-md-0">--}}
                                                            {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                                                    {{--id="start-working-hours-select" required>--}}
                                                                {{--<option value="">برجاء تحديد القيمة</option>--}}
                                                                {{--@include("Provider.includes.edit-start-working-hours-options")--}}
                                                            {{--</select>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                                    {{--<div class="row">--}}
                                                        {{--<label for="sat-close"--}}
                                                               {{--class="col-form-label col-auto">إلى:</label>--}}
                                                        {{--<div class="col pr-md-0">--}}
                                                            {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                                                    {{--id="end-working-hours-select">--}}
                                                                {{--<option value="">برجاء تحديد القيمة</option>--}}
                                                                {{--@include("Provider.includes.working-hours-options")--}}
                                                            {{--</select>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div><!-- .form-group booking-status -->--}}
                                        {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row saturday -->--}}

                                    {{--<div class="row saturday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>السبت</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="sat-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="sat-open" required>--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="sat-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="sat-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row saturday -->--}}

                                    {{--<div class="row sunday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>الأحد</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="sun-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="sun-open">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="sun-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="sun-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row sunday -->--}}

                                    {{--<div class="row monday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>الاثنين</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="mon-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="mon-open">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="mon-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="mon-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row monday -->--}}

                                    {{--<div class="row tuesday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>الثلاثاء</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="tue-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="tue-open">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="tue-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="tue-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row tuesday -->--}}

                                    {{--<div class="row wednesday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>الأربعاء</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="wed-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="wed-open">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="wed-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="wed-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row wednesday -->--}}

                                    {{--<div class="row thursday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>الخميس</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="thu-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="thu-open">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="thu-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="thu-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row thursday -->--}}

                                    {{--<div class="row friday">--}}
                                    {{--<div class="col">--}}
                                    {{--<p>الجمعة</p>--}}
                                    {{--<div class="form-group row">--}}
                                    {{--<div class="col-lg-6 col-12">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="fri-open"--}}
                                    {{--class="col-form-label col-auto">من:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="fri-open">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-lg-6 col-12 mt-3 mt-lg-auto">--}}
                                    {{--<div class="row">--}}
                                    {{--<label for="fri-close"--}}
                                    {{--class="col-form-label col-auto">إلى:</label>--}}
                                    {{--<div class="col pr-md-0">--}}
                                    {{--<select class="working-hours custom-select text-gray font-body-md border-gray"--}}
                                    {{--id="fri-close">--}}
                                    {{--<option value="">برجاء تحديد القيمة</option>--}}
                                    {{--@include("Provider.includes.working-hours-options")--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--</div><!-- .form-group booking-status -->--}}
                                    {{--</div><!-- .col -->--}}
                                    {{--</div><!-- .row friday -->--}}
                                    
                                    
                                    
                                    <button  type="submit" class="btn btn-primary py-2 px-5 submit_edit_form"> {{trans('site.edit')}} </button>
                                    
                                    

                                </form>

                            </div><!-- .tab-pane -->

                            <div class="tab-pane fade"
                                 id="category"
                                 role="tabpanel"
                                 aria-labelledby="cats-tab">
                                <div class="table-responsive bg-light">

                                    <table class="table">
                                        <thead class="font-body-bold">
                                        <tr>
                                            <th scope="col">{{trans('site.meal_name')}}</th>
                                            <th scope="col">{{trans('site.category')}}</th>
                                            <th scope="col">{{trans('site.control')}}</th>
                                        </tr>
                                        </thead>

                                        <tbody class="font-body-md text-gray border-bottom bg-white">

                                        @foreach($meals as $meal)
                                            <tr>
                                                <th scope="row" class="font-body-md text-nowrap">{{ $meal->meal_name }}</th>
                                                <td class="text-nowrap">{{ $meal->cat_name }}</td>
                                                <td class="text-nowrap">

                                                    <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                        <input type="checkbox"
                                                               class="branch-meal custom-control-input"
                                                               id="meal_{{ $meal->meal_id }}"
                                                               data="{{ $meal->meal_id }}"
                                                               name="meal_{{ $meal->meal_id }}" @if($meal->selected == "1") checked @endif>
                                                        <label class="custom-control-label font-body-md"
                                                               for="meal_{{ $meal->meal_id }}"> {{trans('site.add_to_the_branch')}} </label>
                                                    </div><!-- .custom-control -->

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                
                                <button   type="submit" class="btn btn-primary py-2 px-5 submit_edit_form">{{trans('site.edit')}} </button>
                                {{--<nav aria-label="Page navigation"--}}
                                {{--class="d-flex justify-content-center mt-3">--}}
                                {{--<ul class="pagination pr-0">--}}
                                {{--<li class="page-item active">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                {{--href="#">1</a>--}}
                                {{--</li>--}}
                                {{--<li class="page-item">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                {{--href="#">2</a>--}}
                                {{--</li>--}}
                                {{--<li class="page-item">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                {{--href="#">3</a>--}}
                                {{--</li>--}}
                                {{--<span>...</span>--}}
                                {{--<li class="page-item">--}}
                                {{--<a class="page-link rounded shadow-sm px-3 mx-2 font-body h5 mb-0"--}}
                                {{--href="#">التالي</a>--}}
                                {{--</li>--}}
                                {{--</ul>--}}
                                {{--</nav>--}}
                            </div><!-- .tab-pane -->

                        </div><!-- .tab-content -->


                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->

    </main><!-- .page-content -->

    <main id="map-content" class="hidden-element map-content page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">{{trans('site.dete_locations')}}</h1>
            <p class="description text-gray font-body-md mt-3">{{trans('site.branch_on_map')}}</p>
            {{--<p id="register-map-address" class="description text-gray font-body-md mt-3"></p>--}}
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">
                    <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                        <div id="map" class="embed-responsive-item"></div>

                    </div>

                    <Button type="button" id="confirm-branch-location" class="btn btn-primary px-5 no-decoration">{{trans('site.confirm')}}</Button>
                    <Button type="button" id="decline-branch-location" class="btn btn-default px-5 no-decoration">{{trans('site.back')}}</Button>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection

@section('script')

   

<!--    <script src="{{ asset("/assets/site/js/new-branch-location.js") }}"></script>   -->
    <script src="{{ asset("/assets/site/js/new-branch2.js") }}"></script>
    
     <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&language=ar&callback=initMap">
    </script>
    
 
    
    <script>
    
    
    
	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


   $(document).on('change','#autoCompeletTimes',function(){
       
       var branch_id = this.value;
        if(branch_id){
     
 
        $.ajax({
   	  	  
   	  	  url:  '/restaurant/branches/getTimeFromOtherBranch/'+branch_id,
   	  	  
   	  	  data:{

           'id'      : branch_id,
           'type'    : 'edit'
   	  	  } ,
           type: 'post',
   	  	  success:function(data){
                  
                $('.work-times').empty().append(data.content);
                
                if(data.content == null){
                    
                    
                     alert('الفرع غير موجود');
                }
                
 
   	  	  },
   	  	  error:function(reject){
   	  	      
   	  	      alert('فشل في جلب ساعات العمل الرجاء ادخال الاوقات يدويا ');
                
    	  	  }
         
        });

      
       
        }
   });
   
    $(document).on('click','.submit_edit_form',function(e){
        
        e.preventDefault();
        
          $('#edit-branch-from').submit(); 
    });
           
            
    var map, infoWindow , marker ,geocoder;
        
    var messagewindow;
    var markers = [];

    var prevlat;
    var prevLng

    var SelectedLatLng = "";
    var SelectedLocation = "";

    $("#new-branch-map-btn, #complete-order-location-btn").on("click", function () {
        $(".main-content").addClass("hidden-element");
        $(".map-content").removeClass("hidden-element");

        window.scrollTo(0,200);

        if($("#branch-latLng").val() !== ""){
            prevlat = $("#branch-lat").val();
            prevLng = $("#branch-lng").val();
        }else{
            prevlat = -34.397;
            prevLng = 150.6444;
        }

        initMap();

    });

    $("#decline-branch-location, #decline-user-location").on("click", function () {
        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }


    });

    $("#confirm-branch-location, #confirm-user-location").on("click", function () {

        if(SelectedLatLng === ""){
            notif({
                msg: "برجاء تحديد الموقع",
                type: "warning"
            });
            return false;
        }

        $("#branch-latLng").val(SelectedLatLng);
        splitLatLng(String(SelectedLatLng));

        $("#address-map").val(SelectedLocation);

        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }

    });
  

 

  function initMap() {
   

         var pos = {lat:   {{ $branch->latitude }} ,  lng: {{ $branch->longitude }} };  
         
         map = new google.maps.Map(document.getElementById('map'), {
             zoom: 15,
             center: pos
        });
        
          
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder();

   
              marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: $("input[name='ar_name']").val()
                
            });
            
            
             infoWindow.setContent($("input[name='ar_name']").val());
             infoWindow.open(map, marker);
    
         
        // Try HTML5 geolocation.

        if($("#branch-latLng").val() === ""){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    //infoWindow.setPosition(pos);
                   // infoWindow.setContent('Location found.');
                   // infoWindow.open(map);
                    map.setCenter(pos);
                    
                     var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(pos),
                              
                            map: map,
                            title: 'موقعك الحالي'
                        });
                         
                        
                        
                        
                        
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

         var geocoder = new google.maps.Geocoder();
 

            google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                        }
                    }
                });
            });

      
 
        function addMarkerRunTime(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function splitLatLng(latLng){

        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];

        $("#branch-lat").val(lat);
        $("#branch-lng").val(Lng);
    }
         
    </script>
    
    <script>
        $(".next-working-hours").on("click", function(){
            $("#work-tab").addClass("active show");
            $(".working-hours-content").addClass("active show");
            
            $("#info-tab").removeClass("active show");
            $(".info-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".prev-work").on("click", function(){
            $("#info-tab").addClass("active show");
            $(".info-content").addClass("active show");
            
            $("#work-tab").removeClass("active show");
            $(".working-hours-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".next-cats").on("click", function(){
            $("#cats-tab").addClass("active show");
            $(".cat-content").addClass("active show");
            
            $("#work-tab").removeClass("active show");
            $(".working-hours-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".prev-final-cat").on("click", function(){
            $("#cats-tab").removeClass("active show");
            $(".cat-content").removeClass("active show");
            
            $("#work-tab").addClass("active show");
            $(".working-hours-content").addClass("active show");
            
            window.scrollTo(0, 0);
        });
    </script>
@endsection