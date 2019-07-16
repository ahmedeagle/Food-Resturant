@extends("User.layouts.master")

@section("title")
    {{ $title }}
@endsection

@section("class")
    {{ $class }}
@endsection

@section("content")

    <main class="page-content py-5 mt-4">

        <header class="page-header mt-5 text-center">
            <h1 class="page-title h2 font-body-bold">تأكيد رقم الهاتف</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5 pb-5">
                    <form action="{{ url("/user/activate-phone") }}" method="POST" class="login-form mt-5">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="phone-number">قم بإدخال رقم التأكيد الذي وصلك على رقم الهاتف</label>
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
                        <button type="submit" class="btn btn-primary px-5">تفعيل</button>
                        <br />
                        <a href="{{ url("/user/resend-activation-code") }}" class="top-margin btn btn-info px-5">إعادة ارسال رقم التأكيد</a>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



