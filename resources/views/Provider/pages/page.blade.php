@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection

@section('class')
    {{ $class }}
@endsection

@section("content")
    <main class="page-content py-5">
        <div class="container">

            <div class="row">

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">{{ $page->ar_title }}</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4 mb-5">
                        <h5 class="sub-title font-size-base mb-3">{{ $page->ar_title }}</h5>
                        <div class="page-content font-body-md text-gray">

                                {!! $page->ar_content !!}

                        </div>
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection