@extends("Provider.layouts.master")

@section("title")
    {{ $title }}
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
                            {{ csrf_field() }}<!---->
                             <div class="form-group">
                                  <label for="congestion-status">حالة الازدحام </label>
                                        <select class="custom-select text-gray font-body-md border-gray" id="congestion-status" name="congestion-status" required="">
                                               <option value="">{{trans('site.choose_congestion_status')}} </option>
                                                @foreach($congestion as $c)
                                                    <option value="{{ $c->id }}" @if($c->id == $branch->congestion_settings_id) selected @endif>{{ $c->name }}</option>
                                                @endforeach
                                      </select>
                             </div>
                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5">{{trans('site.confirm')}}</button>
                        </form><!-- .new-kind-form -->
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection