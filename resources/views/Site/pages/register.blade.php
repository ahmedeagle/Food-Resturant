@extends('Site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')

    <main class="page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">{{trans('site.register')}}</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5">

                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-md-column flex-sm-column flex-column bg-white">
                        <ul class="nav nav-tabs border-0 px-lg-2 pr-0 text-center justify-content-around"
                            id="new-branch-tabs"
                            role="tablist">

                            <li class="nav-item">
                                <a class="nav-link pb-3 h3 mb-0 pt-3 font-body-bold active"
                                   id="user-tab"
                                   data-toggle="tab"
                                   href="#user"
                                   role="tab"
                                   aria-controls="user"
                                   aria-selected="true">
                                     {{trans('site.as_user')}}
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 h3 mb-0 pt-3 font-body-bold"
                                   id="restaurant-tab"
                                   data-toggle="tab"
                                   href="#restaurant"
                                   role="tab"
                                   aria-controls="restaurant"
                                   aria-selected="false">
                                {{trans('site.as_provider')}}
                                </a>
                            </li><!-- .nav-item -->
                        </ul><!-- .nav-tabs -->
                    </div>


                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="user"
                             role="tabpanel"
                             aria-describedby="user-tab">

                            <form action="{{ url('/user/register') }}" method="POST" class="register-form mt-5">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="user-name"> {{trans('site.name')}} </label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                           name="user-name"
                                           value="{{ old('user-name') }}"
                                           id="user-name" required>
                                    @if($errors->has("user-name"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-name") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group name -->

                                <div class="form-group">
                                    <label for="country">{{trans('site.country')}}</label>
                                    <select class="country-ajax-request custom-select text-gray font-body-md" data-action="{{ url('/restaurant/cities') }}" name="user-country" id="user-country" required>
                                        <option value="">{{trans('site.choose_country')}}</option>
                                        @foreach($countries as $c)
                                            <option value="{{ $c->id }}" @if(old('user-country') == $c->id) selected @endif>{{ $c->ar_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if($errors->has("user-country"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-country") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group country -->


                                <div class="form-group">
                                    <label for="city">{{trans('site.city')}}</label>
                                    <select class="city-ajax-request custom-select text-gray font-body-md" id="user-city" name="user-city" required>
                                        @if(old("user-country"))
                                            <option value="">{{trans('site.choose_city')}}</option>
                                            @foreach(\App\Http\Controllers\User\HelperController::get_cities(old("user-country")) as $city)
                                                <option value="{{ $city->id }}" @if(old('user-city') == $city->id) selected @endif>{{ $city->ar_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">{{trans('site.choose_city')}}</option>
                                        @endif

                                    </select>
                                    
                                    @if($errors->has("user-city"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-city") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group city -->

                                <div class="form-group">
                                    <label for="user-sax">{{trans('site.gender')}}</label>
                                    <select class="custom-select text-gray font-body-md" name="user-gender" id="user-sax" required>
                                        <option value="">{{trans('site.choose_gender')}}</option>
                                        <option value="1" @if(old('user-gender') == 1) selected @endif>{{trans('site.male')}}</option>
                                        <option value="2" @if(old('user-gender') == 2) selected @endif>{{trans('site.female')}}</option>
                                    </select>
                                    
                                    @if($errors->has("user-gender"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-gender") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group service provider -->



                                <div class="form-group">
                                    <label for="phone-number">{{trans('site.birth_date')}}</label>
                                    <input type="date" class="form-control border-gray font-body-md" value="{{ old('user-age') }}" id="user-age" name="user-age" required>
                                    @if($errors->has("user-age"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-age") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group phone -->

                                <div class="form-group">
                                    <label for="phone-number">{{trans('site.phone')}}</label>
                                    <input type="tel" class="form-control border-gray font-body-md" value="{{ old('user-phone') }}" name="user-phone" id="user-phone-number" placeholder="05xxxxxxxx" required>
                                    
                                    @if($errors->has("user-phone"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-phone") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group phone -->

                                <div class="form-group">
                                    <label for="email">{{trans('site.email')}}</label>
                                    <input type="email"
                                           class="form-control border-gray font-body-md"
                                           id="user-email" required
                                           value="{{ old('user-email') }}"
                                           name="user-email">
                                    
                                    @if($errors->has("user-email"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-email") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group email -->

                                <div class="form-group">
                                    <label for="password">{{trans('site.password')}}</label>
                                    <input type="password"
                                           class="form-control border-gray font-body-md"
                                           minlength= 6
                                           id="user-password" required
                                           name="user-password">

                                    @if($errors->has("user-password"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-password") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group password -->


                                <div class="form-group">
                                    <div class="custom-control custom-checkbox pl-0 pr-4 text-gray">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               name="usage"
                                               id="customCheck6" required>
                                        <label class="custom-control-label font-body-md"
                                               for="customCheck6">
                                            {{trans('site.you_approved_on')}}<a href="{{ url('/page/1') }}" class="no-decoration text-primary">{{trans('site.usage')}}</a>
                                        </label>
                                        @if($errors->has("usage"))
                                            <div class="alert alert-danger top-margin">
                                                {{ $errors->first("usage") }}
                                            </div>
                                        @endif
                                    </div><!-- .custom-control -->
                                </div><!-- .form-group agreement -->

                                <button type="submit" class="btn btn-primary py-2 px-5">{{trans('site.register')}}</button>
                            </form><!-- .register-form -->

                        </div><!-- .tab-pane -->



                        <div class="tab-pane fade"
                             id="restaurant"
                             role="tabpanel"
                             aria-labelledby="restaurant-tab">


                            <form id="provider-register-form" class="register-form mt-4" data-action="{{ url('/restaurant/register') }}">

                                <div class="form-group">
                                    <p>{{trans('site.restaurant_logo')}}</p>
                                    <div class="custom-file h-auto">
                                        <input type="file" name="image" class="custom-file-input" id="restaurant-logo" hidden>
                                        <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                            <img class="provider-uploaded-logo hidden-element" src="" />
                                            <span id="provider-logo-content" class="d-inline-block border border-gray rounded-circle p-4">

                                                <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>

                                            </span>

                                            <span class="font-body-md mr-2 text-gray">
                                        {{trans('site.add_restaurant_logo')}}
                                            </span>
                                            <p id="provider-logo-error" class="alert alert-danger hidden-element top-margin logo-error">{{trans('site.add_restaurant_logo')}}</p>
                                        </label>
                                    </div>
                                </div><!-- .form-group logo -->

                                <div class="form-group">
                                    <label for="restaurant-ar-name">{{trans('site.res_name_ar')}}</label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                           name="restaurant-ar-name"
                                           id="restaurant-ar-name" >
                                           
                                           <span id="restaurant-ar-name_error" style="color:red" class="help-block"></span>
                                </div><!-- .form-group ar name -->

                                <div class="form-group">
                                    <label for="restaurant-en-name">{{trans('site.res_name_en')}}</label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                           name="restaurant-en-name"
                                           id="restaurant-en-name" required>
                                           
                                           <span id="restaurant-en-name_error" style="color:red" class="help-block"></span>
                                </div><!-- .form-group en name -->

                                <div class="form-group">
                                    <label for="service-provider">{{trans('site.provider_type')}}</label>
                                    <select class="custom-select text-gray font-body-md" name="service-provider" id="service-provider">
                                        <option value="">{{trans('site.choose_provider_type')}}</option>
                                        @foreach($cats as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->ar_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                     <span id="service-provider_error" style="color:red" class="help-block"></span>
                                     
                                </div><!-- .form-group service provider -->

                                <div class="form-group">
                                    <p>{{trans('site.services')}}</p>
                                    <div class="row pr-4 text-gray font-body-md">

                                        <div class="custom-control custom-checkbox pl-0 col-md-6 col-12 mb-2">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="automatic-list"
                                                   id="automatic-list">
                                            <label class="custom-control-label font-body-md"
                                                   for="automatic-list">{{trans('site.elect_list')}}</label>
                                        </div><!-- .custom-control -->

                                        <div class="custom-control custom-checkbox pl-0 col-md-6 col-12">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="accept-online-payment"
                                                   id="accept-online-payment">
                                            <label class="custom-control-label font-body-md"
                                                   for="accept-online-payment">{{trans('site.elect_payment')}}</label>
                                        </div><!-- .custom-control -->
                                        
                                        <div class="custom-control custom-checkbox pl-0 col-md-6 col-12">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="accept-order"
                                                   id="accept-order">
                                            <label class="custom-control-label font-body-md"
                                                   for="accept-order">{{trans('site.recieve_orders')}}</label>
                                        </div><!-- .custom-control -->

                                    </div>
                                </div><!-- .form-group service -->

                                <div class="form-group">
                                    <label for="country">{{trans('site.country')}}</label>
                                    <select class="country-ajax-request custom-select text-gray font-body-md" data-action="{{ url("/restaurant/cities") }}" name="country" id="country" required>
                                        <option value="">{{trans('site.choose_country')}}</option>
                                        @foreach($countries as $c)
                                            <option value="{{ $c->id }}">{{ $c->ar_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <span id="country_error" style="color:red" class="help-block"></span>
                                </div><!-- .form-group country -->

                                <div class="form-group">
                                    <label for="city">{{trans('site.city')}}</label>
                                    <select class="city-ajax-request custom-select text-gray font-body-md" name="city" id="city" required>
                                        <option value="">{{trans('site.choose_city')}}</option>
                                    </select>
                                    <span id="city_error" style="color:red" class="help-block"></span>
                                </div><!-- .form-group city -->

                                <div class="form-group">
                                    <label for="phone-number">{{trans('site.phone')}}</label>
                                    <input type="text" class="form-control border-gray font-body-md" name="phone-number" id="phone-number" placeholder="05XXXXXXXX" required>
                                    <div id="phone-error" class="top-margin alert alert-danger hidden-element"></div>
                                    
                                    <span id="phone-number_error" style="color:red" class="help-block"></span>
                                    
                                </div><!-- .form-group phone -->

                                <div class="form-group">
                                    <label for="email"> {{trans('site.email')}}</label>
                                    <input type="email"
                                           class="form-control border-gray font-body-md"
                                           name="email"
                                           id="email" required>
                                    <div id="email-error" class="top-margin alert alert-danger hidden-element"></div>
                                    
                                    <span id="email_error" style="color:red" class="help-block"></span>
                                    
                                </div><!-- .form-group email -->

                                <div class="form-group">
                                    <label for="password"> {{trans('site.password')}}</label>
                                    <input type="password"
                                           class="form-control border-gray font-body-md"
                                           minlength= 6
                                           name="password"
                                           id="password" required>
                                           
                                           <span id="password_error" style="color:red" class="help-block"></span>
                                           
                                </div><!-- .form-group password -->

                                <div class="form-group">
                                    <label for="provider-ar-details">{{trans('site.abbrev_services_ar')}}</label>
                                    <textarea class="form-control font-body-md"
                                              id="provider-ar-details"
                                              name="provider-ar-details"
                                              rows="6" required></textarea>
                                              <span id="provider-ar-details_error" style="color:red" class="help-block"></span>
                                </div><!-- .form-group ar details -->

                                <div class="form-group">
                                    <label for="provider-en-details">{{trans('site.abbrev_services_en')}}</label>
                                    <textarea class="form-control font-body-md"
                                              id="provider-en-details"
                                              name="provider-en-details"
                                              rows="6" required></textarea>
                                              
                                               <span id="provider-en-details_error" style="color:red" class="help-block"></span>
                                </div><!-- .form-group en details -->

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox pl-0 pr-4 text-gray">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               name="custom-control-input"
                                               name="accept-policy"
                                               id="accept-policy" required>
                                        <label class="custom-control-label font-body-md"
                                               for="accept-policy">
                                            {{trans('site.you_approved_on')}} <a href="{{ url('/page/1') }}" class="no-decoration text-primary"> {{trans('site.usage')}}</a>
                                        </label>
                                    </div><!-- .custom-control -->
                                </div><!-- .form-group agreement -->

                                <button type="submit" class="btn btn-primary py-2 px-5">{{trans('site.register')}}</button>
                            </form><!-- .register-form -->
                        </div>
                    </div>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->



@endsection