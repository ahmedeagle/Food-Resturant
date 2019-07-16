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
            <h1 class="page-title h2 font-body-bold">إستعادة كلمة المرور</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5 pb-5">
                    <form method="POST" action="{{ url("/restaurant/password-recovery") }}" class="login-form mt-5">
                        {{ csrf_field() }}

                        @if(Session::has("error"))

                            <div class="alert alert-warning">
                                {{ Session::get("error") }}
                            </div>

                        @endif
                        <div class="form-group">
                            <label for="code-number">قم بإدخال رقم التأكيد الذي وصلك</label>
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="guard" value="{{ $guard }}">
                            
                            <input type="text" name="code" class="form-control border-gray" id="code-number">
                            @if($errors->has("code"))
                                <div class="alert alert-danger top-margin">
                                    {{ $errors->first("code") }}
                                </div>
                            @endif
                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-primary px-5">تفعيل</button>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection