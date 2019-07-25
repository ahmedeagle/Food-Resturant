@extends("User.layouts.master")

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

                @include("User.includes.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{trans('site.reservations')}}</h4>
                    </div>

                    @if(Session::has("warning"))

                        <div class="alert alert-warning top-margin">
                            {{ Session::get("warning") }}
                        </div>

                    @endif

                    @if(Session::has("success"))

                        <div class="alert alert-success top-margin">
                            {{ Session::get("success") }}
                        </div>

                    @endif
                    
                    
                                  @if(Session::has('closed'))
                                  
                                    <div class="alert alert-danger top-margin">
                                           {{Session::get('closed')}} 
                                    </div>
                                 @endif
                                 
                                   @if(Session::has('outWork'))
                                  
                                    <div class="alert alert-danger top-margin">
                                           {{Session::get('outWork')}} 
                                    </div>
                                 @endif
                                 
                                  
                                  
                                  
                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white font-body-bold bg-white">

                        <form action="{{ url("/user/reservations/add-reservation") }}" method="POST">
                            {{ csrf_field() }}


                            <div class="form-group my-2">
                                <label for="people-count">{{trans('site.date')}}</label>
                                <input type="date" name="date" value="{{ old("date") }}" class="form-control border-gray">
                                @if($errors->has("date"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("date") }}
                                    </div>

                                @endif
                            </div>

                            <div class="form-group my-2">
                                <label for="people-count"> {{trans('site.time')}} </label>
                                <input type="time" id="time" name="time" value="{{ old("time") }}" class="form-control border-gray">
                                @if($errors->has("time"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("time") }}
                                    </div>

                                @endif
                            </div>

                            <div class="form-group my-2">
                                <label for="people-count"> {{trans('site.person_num')}}</label>
                                <input type="text" name="seats_number" value="{{ old("seats_number") }}" class="form-control border-gray">
                                @if($errors->has("seats_number"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("seats_number") }}
                                    </div>

                                @endif
                            </div>

                            <div class="form-group my-2">
                                <label for="special-event">{{trans('site.special_reservation')}}</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="special-event" name="special">
                                    <option value="">{{trans('site.reservation_note')}}</option>
                                    <option value="1" @if(old("special") == "1") selected @endif>{{trans('site.special')}}</option>
                                    <option value="0" @if(old("special") == "0") selected @endif>{{trans('site.not_special')}}</option>
                                </select>

                                @if($errors->has("special"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("special") }}
                                    </div>

                                @endif

                            </div>

                            <div class="event_desc_content form-group my-2 @if(old("special")) @if(old("special") != "1") hidden-element @endif @else hidden-element @endif">
                                <label for="people-count">{{trans('site.occasion_description')}}</label>
                                <textarea class="form-control font-body-md"
                                          name="occasion_description"
                                          value="{{ old("occasion_description") }}"
                                          rows="6"></textarea>
                                @if($errors->has("occasion_description"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("occasion_description") }}
                                    </div>

                                @endif
                            </div>

                            <input type="hidden" name="status" value="{{ $type }}" />
                            <input type="hidden" name="id" value="{{ $id }}" />

                            <button type="submit" class="btn btn-primary py-2 px-5 mt-3">{{trans('site.confirm')}}</button>


                            {{--<!--For Test--> <a href="user-booking-confirmation.html" class="btn btn-primary py-2 px-5 mt-3">{{trans('site.confirm')}}</a><!--For Test-->--}}

                        </form>

                    </div>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection

