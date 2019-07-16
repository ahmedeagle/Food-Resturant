@extends("Site.layouts.master")

@section("title")
    {{ $title }}
@endsection

@section("class")
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
                    <form action="{{ url("/user/forget-password") }}" method="POST" class="login-form mt-5">
                        {{ csrf_field() }}

                        @if(Session::has("error"))

                            <div class="alert alert-warning top-margin">
                                {{ Session::get("error") }}
                            </div>

                        @endif

                        <div class="form-group">
                            <label for="phone-number">يرجى إدخال رقم الهاتف الخاص بك</label>
                            <input type="tel" name="phone" class="form-control border-gray" id="phone-number">
                            @if($errors->has("phone"))

                                <div class="alert alert-danger top-margin">
                                    {{ $errors->first("phone") }}
                                </div>

                            @endif
                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-primary px-5">إرسال</button>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



