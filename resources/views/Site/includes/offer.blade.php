<section id="offers" class="offers py-5">
    <header class="section-header">
        <h2 class="section-title text-center font-body-heavy">العروض</h2>
    </header><!-- .section-header -->
    <div class="section-content mt-5">

        <div class="container">

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
                                             style="width:570px;height:277px"
                                             alt="First slide">
                                        <figcaption class="font-body-md p-3">
                                            <h4 class="item-title">
                                                <a href="{{ url("/restaurant-page/". $offer->branch_id) }}" class="text-secondary no-decoration" title="{{ $offer->title }}">
                                                    {{ str_limit($offer->title, $limit = 35, $end = "..") }}
                                                </a>
                                            </h4>
                                            <p class="h5 address text-gray">
                                                <i class="fa fa-map-marker-alt text-primary ml-2"
                                                   aria-expanded="false"></i>
                                                {{ $offer-> address }}
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

        </div><!-- .container -->

    </div><!-- .section-content -->
</section><!-- .offers -->