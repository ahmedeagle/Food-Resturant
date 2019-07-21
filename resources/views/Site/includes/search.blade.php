<div class="search position-relative">
    <div class="search-bg position-absolute w-100 h-100"></div>

    <div class="container">
        <div class="py-3 py-md-4 py-lg-5">
            <form method = "POST" action="{{ url("/search") }}" class="search-form py-3 py-md-4 py-lg-5">
                {{ csrf_field() }}
                <div class="form-group py-3 py-md-4 py-lg-5">
                    <label for="search-field"
                           class="search-label h1 font-body-heavy d-block mb-4 text-center position-relative">
                         {{trans('site.search_for_resturant_to_try')}}
                    </label>
                    <div class="row">
                        <div class="col-xl-7 col-lg-9 col-md-11 col-sm-12 col-12 mx-auto">
                            <div class="input-group shadow-around rounded">
                                <input type="search"
                                       id="search-field"
                                       class="form-control py-2 py-sm-3 border-left-0 rounded-right border-medium"
                                       placeholder="{{trans('site.search_for_resturant')}}"
                                       aria-label="{{trans('site.search_for_resturant')}}"
                                       name = "query"
                                       aria-describedby="search-addon">

                                <div class="input-group-prepend">
                                        <span id="search-addon"
                                              class="input-group-text bg-white border-right-0 rounded-left border-medium">
                                            <button type="submit" class="btn border-0 bg-white p-0">
                                                <i class="fa fa-search text-primary fa-lg" aria-hidden="true"></i>
                                            </button>
                                        </span>
                                </div><!-- .input-group-prepend -->

                            </div><!-- .input-group -->
                        </div><!-- .col-* -->
                    </div><!-- .row -->
                     @if(Session::has('empty-query'))
                        <div class="row">
                        <div class="col-xl-7 col-lg-9 col-md-11 col-sm-12 col-12 mx-auto">
                        {{ Session::get('empty-query') }}
                        </div>
                        </div>
                    @endif
                </div><!-- .form-group -->
            </form><!-- search-form -->
        </div>
    </div>
</div><!-- .search -->
