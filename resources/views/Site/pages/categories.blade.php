@extends('Site.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')
    <main class="page-content py-5">

        <header class="page-header mt-2 text-center">
            <h1 class="page-title h2 font-body-bold">التصنيفات</h1>
        </header>

        <div class=" categories section-content mt-5">
            <div class="container">
                <div class="row">

                    @foreach($cats as $key => $cat)
                        <a href="{{ url("/cat-restaurants/". $cat->cat_id) }}">
                            <div class="col-md-3 col-sm-6 col-12 @if($key != 0) @if($key == 1) mt-4 mt-sm-0 @elseif($key == 2) mt-4 mt-md-0 @elseif($key == 3) mt-4 mt-md-0 @else mt-4 @endif @endif">
                                <div class="cat-item position-relative rounded-lg overflow-hidden">
                                    <div class="overlay position-absolute w-100 h-100"></div>
                                    <a href="{{ url("/cat-restaurants/". $cat->cat_id) }}">
                                        <figure class="cat-figure mb-0">
                                            <img src="{{ $cat->image_url }}"
                                                 class="img-fluid d-block mx-auto w-100"
                                                 style="width:270px;height:380px"
                                                 alt="Category image">
                                            <figcaption class="cat-figcaption position-absolute px-3">
                                                <h3 class="cat-title font-body-md position-relative">
                                                    <a href="{{ url("/cat-restaurants/". $cat->cat_id) }}" class="text-white no-decoration">
                                                        {{ $cat->ar_name }}
                                                    </a>
                                                </h3>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </a>
                    @endforeach

                </div><!-- .row -->
            </div><!-- .container -->
        </div>

        {{ $cats->links("Pagination.pagination") }}

    </main><!-- .page-content -->
@endsection