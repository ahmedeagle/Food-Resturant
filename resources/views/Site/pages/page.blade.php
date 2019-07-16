@extends('Site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')
    <main class="page-content py-5">
        <div class="container">

            <div class="row">

                <div class="col-lg-12 col-md-12 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">{{ $page->title }}</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4 mb-5">

                        <div class="page-content font-body-md text-gray">
                          {!! $page->content !!}
                        </div>
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection