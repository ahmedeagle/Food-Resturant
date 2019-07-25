@extends("Site.layouts.master")

@section('title')
    {{ $title }}
@endsection

@section('class')
    {{ $class }}
@endsection

@section("content")

    <main class="page-content py-5 mt-4">

        <header class="page-header mt-5 text-center">
            <h1 class="page-title h2 font-body-bold">{{trans('site.password_reset')}}</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5 pb-5">
                    <form action="{{ url("/restaurant/change-password") }}" method="POST" class="login-form mt-5">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="new-password">{{trans('site.new_password')}}</label>
                            <input type="password" class="form-control border-gray" name="password" id="password">
                            @if($errors->has("password"))
                                <div class="alert alert-danger top-margin">
                                    {{ $errors->first("password") }}
                                </div>
                            @endif
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="confirm-password">{{trans('site.confirm_password')}}</label>
                            <input type="hidden" name="token" value="{{ $token }}" />
                            <input type="hidden" name="guard" value="{{ $guard }}" />
                            
                            <input type="password" class="form-control border-gray" name="password_confirmation" id="password_confirmation">
                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-primary px-5">{{trans('site.change')}}</button>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection