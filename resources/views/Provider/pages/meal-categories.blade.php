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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0">

                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title font-body-bold">{{trans('site.all_meals')}}</h4>
                    </div>

                    @if(Session::has("warning"))
                        <div class="alert alert-warning top-margin">
                            {{ Session::get("warning") }}
                        </div>
                    @endif

                    @if(Session::has("error"))
                        <div class="alert alert-danger top-margin">
                            {{ Session::get("error") }}
                        </div>
                    @endif

                    @if(Session::has("success"))
                        <div class="alert alert-success top-margin">
                            {{ Session::get("success") }}
                        </div>
                    @endif

                    @if(count($cats) > 0)
                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <div class="table-responsive bg-light">

                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">{{trans('site.category_name')}}</th>
                                    <th scope="col"> {{trans('site.meals_count')}}</th>
                                    <th scope="col">{{trans('site.control')}}</th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                @foreach($cats as $cat)
                                    <tr>
                                        <th scope="row"
                                            class="font-body-md text-nowrap">{{ $cat->name }}</th>
                                        <td class="text-nowrap">{{ $cat->count }}</td>
                                        <td class="text-nowrap">

                                            @if($cat->published == "1")
                                                <a href="{{ url("/restaurant/food-menu/cat/stop/" . $cat->cat_id) }}">
                                                    <i class="fa fa-pause fa-fw text-primary cursor"
                                                       aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a href="{{ url("/restaurant/food-menu/cat/activate/" . $cat->cat_id) }}">
                                                    <i class="fa fa-play fa-fw text-primary cursor"
                                                       aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            <a href="{{ url("/restaurant/food-menu/cat/edit/" . $cat->cat_id) }}">

                                                <i class="fa fa-pencil-alt fa-fw text-primary cursor"
                                                   aria-hidden="true"></i>

                                            </a>

                                            <i class="fa fa-trash-alt fa-fw text-primary cursor"
                                               data-toggle="modal"
                                               id = "{{ $cat->cat_id }}"
                                               onclick="deletefn(this.id)"
                                               data-target="#confirm-delete"
                                               aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="modal fade"
                                 id="confirm-delete"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content py-3">
                                        <p class="modal-body h4 font-weight-bold text-center mb-auto">
                                             {{trans('site.delete_message')}}
                                        </p>
                                        <div class="modal-footer d-flex justify-content-center pt-0">
                                            <button type="button"
                                                    class="btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                                    data-dismiss="modal">{{trans('site.cancel')}}</button>
                                            <a type="submit"
                                                    class="btn btn-primary px-4 px-sm-5 font-weight-bold"
                                                    id="yes">{{trans('site.yes')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    @else

                    <div class="mt-4">
                        {{ trans("provider.empty_meal_cats") }}
                    </div>

                    @endif
                    <div class="rounded-lg shadow-around mt-4">
                        <form action="{{ url("/restaurant/food-menu/new-cat") }}" id="add-meal-cat-form" method="POST" class="new-cat-form p-3">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="new-cat" class="font-body-bold">{{trans('site.add_new_category')}}</label>
                                <div class="d-flex justify-content-center flex-column flex-sm-row">
                                    <input type="text" name="ar_name" value="{{ old("ar_name") }}" class="form-control" id="new-cat" placeholder="الاسم باللغه العربيه "  style="margin: 3px;">
                                     <input type="text" name="en_name" value="{{ old("en_name") }}" class="form-control" id="new-cat2" placeholder="الاسم باللغه الانجليزية " style="margin: 3px;">
                                    <button class="btn btn-primary font-body-bold px-lg-5 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto"
                                            type="submit">{{trans('site.confirm')}}</button>

                                </div>
                                @if($errors->has("ar_name") or $errors->has("en_name"))
                                    <div class="alert top-margin">
                                        {{ $errors->first("ar_name") ? $errors->first("ar_name") : $errors->first("en_name")  }}
                                    </div>
                                @endif
                                  

                            </div>
                        </form>
                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection
@section("script")
    <script>

        function deletefn(val){
            var a = document.getElementById('yes');
            a.href = "{{ url('restaurant/food-menu/cat/delete') }}" + "/" +val;

        }

    </script>
@endsection