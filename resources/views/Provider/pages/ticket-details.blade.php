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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{ $ticket->ticket_title }}</h4>
                    </div>
                    <div class="chat-container">
                        @foreach($replies as $reply)

                            <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">

                                <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                    <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                         src="{{ ($ticket->provider_image_url == null) ? url("/storage/app/public/users/avatar.png") : $ticket->provider_image_url }}"
                                         style="width:90px;height:90px"
                                         draggable="false"
                                         alt="Generic placeholder image">

                                    <div class="media-body">

                                        <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-size-base">
                                            @if($reply->FromUser == "1") {{ $ticket->provider_name }} @else {{ trans("site.support-name") }} @endif
                                        </h5>
                                        <p class="text-lg-right text-center pb-1 text-gray mb-0">{{ $reply->created_date }}</p>

                                        <p class="text-gray  pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                            <span class="d-block">
                                                {{ $reply->reply }}
                                            </span>
                                        </p>
                                    </div><!-- .media-body -->
                                </div><!-- .media -->
                            </div>
                        @endforeach
                    </div>

                    <div class="reply-cell hidden-element">
                        <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">

                            <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                     src="{{ ($ticket->provider_image_url == null) ? url("/storage/app/public/users/avatar.png") : $ticket->provider_image_url }}"
                                     style="width:90px;height:90px"
                                     draggable="false"
                                     alt="Generic placeholder image">

                                <div class="media-body">

                                    <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-size-base">
                                        {{ $ticket->provider_name }}
                                    </h5>
                                    <p class="time text-lg-right text-center pb-1 text-gray mb-0"></p>

                                    <p class="text-gray  pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                        <span class="reply-text d-block">

                                        </span>
                                    </p>
                                </div><!-- .media-body -->
                            </div><!-- .media -->
                        </div>
                    </div>

                    <div class="p-3 rounded-lg shadow-around bg-white py-2 font-body-bold my-3">
                        <form id="add-reply-form" data-action="{{ url("/restaurant/contact-us/ticket/add-reply") }}" class="edit-form">
                            <div class="form-group">
                                <label for="provider-details">{{trans('site.reply')}}</label>
                                <input type="hidden" name="ticker_id" class="ticker_id" value="{{ $ticket->ticket_id }}" />
                                <textarea class="form-control font-body-md"
                                          id="provider-details"
                                          rows="6"></textarea>
                                <p id= "reply-error" class="alert alert-danger top-margin hidden-element"></p>
                            </div><!-- .form-group details -->
                            <button type="submit" id="add-reply-btn" class="btn btn-primary py-2 px-5 mt-1 mb-1">{{trans('site.send')}}</button>
                        </form>
                    </div>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection
@section("script")
    <script src="{{ url("/assets/site/js/tickets.js") }}"></script>
@endsection