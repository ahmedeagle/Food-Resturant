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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">{{trans('site.profile')}}</h4>

                    </div><!-- .section-header -->

                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white font-body-bold">
                        <form class="edit-form" action="{{ url('/user/profile') }}" method="POST" novalidate>

                            {{ csrf_field() }}


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

                            <div class="form-group">
                                <p>{{trans('site.user_pic')}}</p>
                                <div class="custom-file h-auto">
                                    <input type="file" class="edit-logo-file custom-file-input" id="restaurant-logo" hidden>
                                    <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <img src="{{ $img }}"
                                             class="d-inline-block rounded-circle"
                                             style="width:86px;height:86px"
                                             id="edit-logo-image"
                                             alt="Restaurant Logo">
                                        <span class="font-body-md mr-2 text-primary">
                                            {{trans('site.change_pic')}}
                                        </span>
                                    </label>
                                </div>
                            </div><!-- .form-group logo -->

                            <button type="button" data-action="{{ url('/user/profile/edit-image') }}" id="edit-logo-btn" class="hidden-element btn btn-primary py-2 px-5">{{trans('site.change')}}</button>

                            <div class="form-group">
                                <label for="user-name">{{trans('site.name')}}</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="user-name"
                                       name="user-name"
                                       value="{{ old('user-name', auth('web')->user()->name) }}"
                                       placeholder="محمد عبد الله"
                                       required
                                >

                                @if($errors->has("user-name"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("user-name") }}
                                    </div>

                                @endif

                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="country">{{trans('site.country')}}</label>
                                <select class="country-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="country" name="user-country" data-action="{{ url('/restaurant/cities') }}" required>
                                    <option value="">{{trans('site.choose_country')}}</option>

                                    <?php $namee = LaravelLocalization::getCurrentLocale()."_name" ?>

                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" @if( old("user-country") )  @if(old("user-country") == $country->id) selected @endif @else @if($country->id == auth('web')->user()->country_id) selected @endif @endif>{{ $country-> $namee }}</option>
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
                                <select class="city-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="city" name="user-city" required>


                                    @if(old("user-country") != null)
                                        @if(old("user-country") != "")
                                            <option value="">{{trans('site.choose_city')}}</option>
                                            @foreach(\App\Http\Controllers\User\HelperController::get_cities(old("user-country")) as $city)
                                                <option value="{{ $city->id }}" @if(old('user-city')) @if(old('user-city') == $city->id) selected @endif @else @if($city->id == auth('web')->user()->city_id) selected @endif @endif>{{ $city-> $namee }}</option>
                                            @endforeach
                                        @else
                                            <option value="">{{trans('site.choose_country')}}</option>
                                        @endif
                                    @elseif(old("user-country") != "")


                                    @else
                                        <option value="">{{trans('choose_city')}}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" @if(old("user-city")) @if(old("user-city") == $city->id) selected @endif @else @if($city->id == auth('web')->user()->city_id) selected @endif @endif>{{ $city-> $namee }}</option>
                                        @endforeach

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
                                    <option value="1"  @if(old('user-gender')) @if(old('user-gender') == '1') selected @endif  @else @if(auth('web')->user()->gender == 'male') selected @endif @endif> {{trans('site.male')}}</option>
                                    <option value="2" @if(old('user-gender'))  @if(old('user-gender') == '2') selected @endif  @else @if(auth('web')->user()->gender == 'female') selected @endif @endif>{{trans('site.female')}}</option>
                                </select>

                                @if($errors->has("user-gender"))
                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("user-gender") }}
                                    </div>
                                @endif

                            </div><!-- .form-group service provider -->



                            <div class="form-group">
                                <label for="phone-number"> {{trans('site.age')}}</label>
                                <input type="tel" class="form-control border-gray font-body-md" value="{{ old('user-age', auth('web')->user()->age) }}" id="user-age" name="user-age" required>
                                @if($errors->has("user-age"))
                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("user-age") }}
                                    </div>
                                @endif
                            </div><!-- .form-group phone -->


                            <div class="form-group">
                                <label for="phone-number">{{trans('site.phone')}} </label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="{{ old('user-phone', auth('web')->user()->phone) }}"
                                       id="phone-number"
                                       name="user-phone"
                                       placeholder="05XXXXXXXX"
                                       required
                                >

                                @if($errors->has("user-phone"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("user-phone") }}
                                    </div>

                                @endif

                            </div><!-- .form-group phone -->

                            <div class="form-group">
                                <label for="email">{{trans('site.email')}}</label>
                                <input type="email"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="{{ old('user-email', auth('web')->user()->email) }}"
                                       id="email"
                                       name="user-email"
                                       placeholder="your@mail.com"
                                       required
                                >

                                @if($errors->has("user-email"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("user-email") }}
                                    </div>

                                @endif

                            </div><!-- .form-group email -->


                            <button type="submit" class="btn btn-primary py-2 px-5 mt-2"> {{trans('site.change')}}</button>

                        </form>
                        <form action="{{ url('/user/change-password') }}" id="change-password-form" method="POST">
                            {{ csrf_field() }}

                            <hr class="bg-gray my-4">


                            @if(Session::has("edit-password-success"))

                                <div class="alert alert-success top-margin">
                                    {{ Session::get("edit-password-success") }}
                                </div>

                            @endif

                            @if(Session::has("edit-password-error"))

                                <div class="alert alert-danger top-margin">
                                    {{ Session::get("edit-password-error") }}
                                </div>

                            @endif

                            <div class="form-group">
                                <label for="old-password">{{trans('site.old_password')}}</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="old-password"
                                       name="old-password"
                                       required
                                >
                                @if($errors->has("old-password"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("old-password") }}
                                    </div>

                                @endif
                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="new-password">{{trans('site.new_password')}}</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="new-password"
                                       name="password"
                                       minlength="6"
                                       required
                                >
                                @if($errors->has("password"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("password") }}
                                    </div>

                                @endif
                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="confirm-password">{{trans('site.confirm_password')}}</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="confirm-password"
                                       name="password_confirmation"
                                       required
                                >
                            </div><!-- .form-group password -->

                            <button type="submit" class="btn btn-primary py-2 px-5">{{trans('site.change')}}</button>

                        </form><!-- .login-form -->

                    </div>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



