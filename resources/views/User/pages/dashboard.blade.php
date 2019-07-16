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
                        <h4 class="page-title font-body-bold">العروض</h4>
                    </div>


                                     <div class="section-content mt-4 ">

                        <div id="offers-slider"
                             class="carousel offers-slider slide"
                             data-ride="carousel">

                            <div class="carousel-inner">

                    @foreach($offers as $key => $offer)
                        
                        @if ($key % 2 == 0)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <div class="row">
                        @endif
                        
                        
                                <div class="col-md-6 col-12">
                                    <figure class="item-content shadow-sm">
                                        <img class="d-block img-fluid mx-auto rounded-top-lg"
                                             src="{{ $offer->image_url }}"
                                             style="width:397px;height:193px"
                                             alt="First slide">
                                        <figcaption class="font-body-md p-3">
                                            <h4 class="item-title">
                                                <a href="{{ url("/restaurant-page/". $offer-> branch_id) }}" class="text-secondary no-decoration" title="{{ $offer-> title }}">
                                                    {{ str_limit($offer-> title, $limit = 35, $end = "..") }}
                                                </a>
                                            </h4>
                                            <p class="h5 address text-gray">
                                                <i class="fa fa-map-marker-alt text-primary ml-2"
                                                   aria-expanded="false"></i>
                                                {{ $offer->address }}
                                            </p>
                                        </figcaption>
                                    </figure>
                                </div>
                        
                        @if ($key % 2 != 0)
                            </div>
                                </div>
                        @endif
                    @endforeach

                            </div><!-- .carousel-inner -->
                            @if(count($offers) > 0)
                                <ol class="carousel-indicators position-relative mt-4 pr-0">
                                    @foreach($offers as $key => $offer)
                                        @if ($key % 2 == 0)
                                            <li data-target="#offers-slider"
                                                data-slide-to="{{ ($key == 0) ? $key : ($key - ($key - 1) ) }}"
                                                class="@if($key == 0) active @endif rounded-circle"></li>
                                        @endif
                                    @endforeach
                                </ol>
                            @else
                                <div class="position-relative mt-4 pr-0">
                                    <p>قائمة العروض فارغة</p>
                                <div>
                            @endif
                            
                        </div><!-- .offers-slider -->


                    </div><!-- .section-content -->

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">التصنيفات</h4>
                    </div>


                    <div class=" categories section-content mt-1">

                        <div class="row">


                            @foreach($cats as $key => $cat)

                                <div class="col-lg-4 col-md-6 col-12 mt-4">
                                    <div class="cat-item position-relative rounded-lg overflow-hidden">
                                        <div class="overlay position-absolute w-100 h-100"></div>

                                            <figure class="cat-figure mb-0">
                                                <a href="{{ url("/cat-restaurants/". $cat->id) }}">
                                                <img src="{{ $cat->image_url }}"
                                                     class="img-fluid d-block mx-auto w-100"
                                                     style="width:255px;height:358px"
                                                     alt="Category image"></a>
                                                <figcaption class="cat-figcaption position-absolute px-3">
                                                    <h3 class="cat-title font-body-md position-relative">
                                                        <a href="{{ url("/cat-restaurants/". $cat->id) }}" class="text-white no-decoration">
                                                            {{ $cat->ar_name }}
                                                        </a>
                                                    </h3>
                                                </figcaption>
                                            </figure>

                                    </div>
                                </div>



                            @endforeach


                        </div>


                    </div><!-- .section-content -->


                    {{ $cats->links("Pagination.pagination") }}

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection



