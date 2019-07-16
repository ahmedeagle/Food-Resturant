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

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">إتصل بنا</h4>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mt-4">
                            <div class="rounded-lg shadow-around bg-white text-center py-4 pt-3 font-body-bold">

                                <a href="{{ url("/user/tickets/open-new-ticket") }}"
                                   class="text-center no-decoration text-secondary p-4 d-block">
                                    <img src="{{ url("/assets/site/img/callus-menu/-e-new-ticket-icon.svg") }}"
                                         class="img-fluid d-block mx-auto"
                                         alt="">
                                    <h5 class="item-tile font-size-base font-body-bold open-ticket pt-4 mb-1">
                                        فتح تذكرة
                                    </h5>
                                </a>

                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mt-4">
                            <div class="rounded-lg shadow-around bg-white text-center py-3 font-body-bold">

                                <a href="{{ url("/user/tickets/tickets/list") }}"
                                   class="text-center no-decoration text-secondary p-4 d-block">
                                    <img src="{{ url("/assets/site/img/callus-menu/-e-ticket-icon.svg") }}"
                                         class="img-fluid d-block mx-auto"
                                         alt="">
                                    <h5 class="item-tile font-size-base font-body-bold pt-3 mb-1">
                                        تذاكري السابقة
                                    </h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



