@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection
 

@section("content")

    <main class="page-content py-5">
        <div class="container">
            <div class="row">

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{trans('site.notifications')}}</h4>
                    </div>

                     @if(isset($notifications) && $notifications -> count() > 0)
                           @foreach($notifications as $n)
                                <div class="pr-3 rounded-lg shadow-around bg-white py-2 font-body-md my-3 mt-4">

                                    <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">

                                        <div class="media-body">

                                            <h5 class="mt-lg-2 mt-md-0 mt-xs-0 pt-2 pt-lg-0 text-lg-right text-center font-size-base">
                                                {{ $n->title }}
                                            </h5>
                                            <p class="text-lg-right text-center pb-1 text-gray mb-0">{{ $n->created_at }}</p>

                                            <p class="text-gray  pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">
                                                <span class="d-block">{{ $n->content }}</span>
                                            </p>

                                           <p class="text-lg-right text-center pb-1 text-gray mb-0">  {{ $n -> seen ==  '1' ? ' مقرؤه ': 'جديده  ' }}</p>

                                        </div><!-- .media-body -->
                                    </div><!-- .media -->
                                </div>
                            @endforeach

                    @else
                        <p class="mt-4">{{trans('site.no_notifications')}}</p>
                    @endif



                    {{ $notifications->links("Pagination.pagination") }}


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection



