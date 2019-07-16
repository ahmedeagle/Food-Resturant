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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">الطلب</h4>
                    </div>

                    <div class="py-4 rounded-lg shadow-around my-4 bg-white">

                        <div class="text-center ">
                            <img src="{{ url("/assets/site/img/Sign-Error-icon.png") }}"
                                 style="width:149px;height:149px"
                                 class="img-fluid d-inline mx-auto my-2">
                            <p class="font-body-md">
                                لم نتمكن من ارسال الطلب, برجاء مراجعة بيانات الدفع واجراء المحاولة مرة اخرى
                            </p>
                        </div>

                    </div>

                    <a href="{{ url("/user/dashboard") }}" class="btn btn-primary px-5">العودة</a>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection




