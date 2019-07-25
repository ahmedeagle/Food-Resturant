@extends("Provider.layouts.master")

@section("title")
    {{ $title }}
@endsection

@section("class")
    {{ $class }}
@endsection

@section("content")

    <main class="page-content py-5 mt-4">

        <header class="page-header mt-5 text-center">
            <h1 class="page-title h2 font-body-bold">{{trans('site.confirm_phone')}}</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5 pb-5">
                    <form action="{{ url("/restaurant/activate-phone") }}" method="POST" class="login-form mt-5">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="phone-number">{{trans('site.enter_confirm_code')}}</label>
                            <input type="text" name="code" class="form-control border-gray" id="phone-number">

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

                            @if($errors->has("code"))

                                <div class="alert alert-danger top-margin">
                                    {{ $errors->first("code") }}
                                </div>

                            @endif

                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-primary px-5">{{trans('site.activate')}}</button>
                        <br />
                        <a href="{{ url("/restaurant/resend-activation-code") }}" class="top-margin btn btn-info px-5"> {{trans('site.resend_code')}}</a>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



