@extends("Provider.layouts.master")

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

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{trans('site.edit_categories')}}</h4>
                    </div>






                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <form action="{{ url("/restaurant/food-menu/cat/edit") }}" method="POST" class="new-kind-form multi-forms">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="kind-name">{{trans('site.cat_name_ar')}}</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="ar_name" value="{{ old("ar_name", $cat->ar_name) }}">

                                @if($errors->has("ar_name"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first("ar_name") }}
                                    </div>
                                @endif
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="kind-name">{{trans('site.cat_name_en')}}</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="en_name" value="{{ old("en_name", $cat->en_name) }}">

                                @if($errors->has("en_name"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first("en_name") }}
                                    </div>
                                @endif

                            </div><!-- .form-group name -->

                            <input type="hidden" name="id" value="{{ $cat->id }}" />
                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5">{{trans('site.confirm')}}</button>
                        </form><!-- .new-kind-form -->
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection