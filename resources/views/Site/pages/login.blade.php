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
            <h1 class="page-title h2 font-body-bold">  {{trans('site.login')}}</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5">

                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-md-column flex-sm-column flex-column bg-white">
                        <ul class="nav nav-tabs border-0 px-lg-2 pr-0 text-center justify-content-around"
                            id="new-branch-tabs"
                            role="tablist">

                            <li class="nav-item">
                                <a class="nav-link pb-3 h3 mb-0 pt-3 font-body-bold @if(!$errors->has('provider-phone-number')  && !Session::has('provider-login-error') && !Session::has('provider-login-success')) active @endif"
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
                                <a class="nav-link pb-3 h3 mb-0 pt-3 font-body-bold @if($errors->has('provider-phone-number') || $errors->has('provider-password') || Session::has('provider-login-error') || Session::has('provider-login-success')) active @endif"
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

                          
                         @if(Session::has("blocked_message"))
                                    <div class="alert alert-warning top-margin">
                                        {{ Session::get("blocked_message") }}
                                    </div>
                                @endif 

                    <div class="tab-content">
                        <div class="tab-pane fade @if(!$errors->has('provider-phone-number') && !$errors->has('provider-password') && !Session::has('provider-login-error') && !Session::has('provider-login-success')) active show @endif"
                             id="user"
                             role="tabpanel"
                             aria-describedby="user-tab">

                            <form action="{{ url('/user/login') }}" method="POST" class="login-form mt-5">
                                {{ csrf_field() }}

                                @if(Session::has("user-error"))
                                    <div class="alert alert-warning top-margin">
                                        {{ Session::get("user-error") }}
                                    </div>
                                @endif

                                @if(Session::has("user-login-success"))
                                    <div class="alert alert-success top-margin">
                                        {{ Session::get("user-login-success") }}
                                    </div>
                                @endif



                                <div class="form-group">
                                    <label for="phone-number">{{trans('site.emailorphone')}}</label>
                                    <input type="text" class="form-control border-gray font-body-md" id="phone-number" value="{{ old('user-data') }}" name="user-data" placeholder="usermail@gmail.com">
                                    @if($errors->has("user-data"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-data") }}
                                        </div>
                                    @endif

                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <label for="password">{{trans('site.password')}}</label>
                                    <input type="password" class="form-control border-gray" id="password" name="user-password" placeholder="********">

                                    @if($errors->has("user-password"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-password") }}
                                        </div>
                                    @endif

                                </div><!-- .form-group -->
                                <button type="submit" class="btn btn-primary btn-block py-2 px-4"> {{trans('site.login')}}</button>
                                <p class="text-center text-gray my-3 font-body-md">{{trans('site.login_via')}}</p>
                                <div class="container">

                                    <div class="row">

                                        <div class="form-group col-md-6 col-12">

                                            <a href="{{ url('/login/facebook') }}" type="submit" class="btn col btn-primary py-2 px-4 facebook">

                                            <i class="fab fa-facebook-f ml-1"></i>
                                                     
                                                     {{trans('site.facebook')}}

                                            </a>

                                        </div>

                                        <div class="form-group col-md-6 col-12">

                                            <a href="{{ url('/login/twitter') }}" type="submit" class="btn col btn-primary py-2 px-4 twitter">

                                            <i class="fab fa-twitter ml-1"></i>
                                            {{trans('site.twitter')}}
                                            </a>

                                        </div>

                                    </div>


                                </div>
                            </form><!-- .login-form -->
                            <div class="lost-data">
                                <a href="{{ url('/user/forget-password') }}"
                                   class="no-decoration mt-3 d-inline-block text-primary">
                                    {{trans('site.forget_password')}}
                                </a>
                                <p>{{trans('site.not_have_account')}}
                                    <a href="{{ url('/register') }}" class="no-decoration text-primary d-inline-block mt-2">
                                        {{trans('site.new_account')}}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade @if($errors->has('provider-phone-number') || $errors->has('provider-password') || Session::has('provider-login-error') || Session::has('provider-login-success')) active show @endif"
                             id="restaurant"
                             role="tabpanel"
                             aria-labelledby="restaurant-tab">

                            <form action="{{ url('/restaurant/login') }}" method="POST" class="login-form mt-5">
                                {{ csrf_field() }}

                                @if(Session::has("provider-login-error"))

                                    <div class="alert alert-info">
                                        {{ Session::get("provider-login-error") }}
                                    </div>

                                @endif

                                @if(Session::has("provider-login-success"))

                                    <div class="alert alert-success">
                                        {{ Session::get("provider-login-success") }}
                                    </div>

                                @endif
                                
                            <div class="row justify-content-center">
    
                               <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food ">
                                                        <input data-id="1" name="guard" value="1" class="form-check-input0" type="radio">
                                                         {{trans('site.branch_account')}}
                                                    </label>
                                                </div>
                                           
                                </div>
                                  <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food ">
                                                        <input data-id="1"  name="guard" value="2" class="form-check-input0" type="radio" checked="">
                                                         {{trans('site.main_account')}}
                                                    </label>
                                                </div>
                                 </div>
                            </div>                
                                                

                                <div class="form-group">
                                    <label for="phone-number"> {{trans('site.phone')}} </label>
                                    <input type="text" name="provider-phone-number" value="{{ old('provider-phone-number') }}" class="form-control border-gray" id="phone-number">

                                    @if($errors->has("provider-phone-number"))
                                        <div class="top-margin alert alert-danger">
                                            {{ $errors->first('provider-phone-number') }}
                                        </div>
                                    @endif
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <label for="password">{{trans('site.password')}} </label>
                                    <input type="password" name="provider-password" class="form-control border-gray" id="password">

                                    @if($errors->has("provider-password"))
                                        <div class="top-margin alert alert-danger">
                                            {{ $errors->first('provider-password') }}
                                        </div>
                                    @endif

                                </div><!-- .form-group -->
                                <button type="submit" class="btn btn-primary py-2 px-4"> {{trans('site.login')}} </button>
                            </form><!-- .login-form -->
                            <div class="lost-data">
                                <a href="{{ url('/restaurant/forget-password') }}"
                                   class="no-decoration mt-3 d-inline-block">
                                     {{trans('site.forget_password')}}
                                </a>
                                <p>{{trans('site.not_have_account')}}
                                    <a href="{{ url('/register') }}" class="no-decoration text-primary d-inline-block mt-2">
                                        {{trans('site.new_account')}}
                                    </a>
                                </p>
                            </div>



                        </div>
                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection