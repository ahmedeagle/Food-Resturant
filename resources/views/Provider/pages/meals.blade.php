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
                        <h4 class="page-title font-body-bold"> {{trans('site.all_meals')}}</h4>
                    </div>

                    @if(Session::has("success"))
                        <div class="alert alert-success top-margin">
                            {{ Session::get("success") }}
                        </div>
                    @endif

                    @if(Session::has("error"))
                        <div class="alert alert-danger top-margin">
                            {{ Session::get("error") }}
                        </div>
                    @endif

                    @if(count($meals) > 0)

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <div class="table-responsive bg-light">
                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">{{trans('site.meal_name')}}</th>
                                     <th scope="col">{{trans('site.branch')}}</th>
                                    <th scope="col"> {{trans('site.category')}}</th>
                                    <th scope="col">{{trans('site.control')}}</th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                    @foreach($meals as $meal)
                                        <tr>
                                            <th scope="row" class="font-body-md text-nowrap">{{ $meal->meal_name }}</th>
                                             <th scope="row" class="font-body-md text-nowrap">{{ $meal->branch_name }}</th>
                                            <td class="text-nowrap">{{ $meal->cat_name }}</td>
                                            <td class="text-nowrap">

                                                @if($meal->published == "1")
                                                    <a href="{{ url("/restaurant/food-menu/stop/". $meal->meal_id) }}">
                                                        <i class="fa fa-pause fa-fw text-primary cursor"
                                                           aria-hidden="true"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ url("/restaurant/food-menu/activate/". $meal->meal_id) }}">
                                                        <i class="fa fa-play fa-fw text-primary cursor"
                                                           aria-hidden="true"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ url("/restaurant/food-menu/edit/" . $meal->meal_id) }}">
                                                <i class="fa fa-pencil-alt fa-fw text-primary cursor"
                                                   aria-hidden="true"></i>
                                                </a>


                                                <i class="fa fa-trash-alt fa-fw text-primary cursor"
                                                   data-toggle="modal"
                                                   data-target="#confirm-delete"
                                                   id = "{{ $meal->meal_id }}"
                                                   onclick="deletefn(this.id)"
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
                                                    id="yes"
                                                    class="btn btn-primary px-4 px-sm-5 font-weight-bold">{{trans('site.yes')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    @else
                        <div class="mt-4">
                            {{ trans("provider.empty-meals") }}
                        </div>
                    @endif

                    {{ $meals->links("Pagination.pagination") }}

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection

@section("script")
    <script>

        function deletefn(val){
            var a = document.getElementById('yes');
            a.href = "{{ url('restaurant/food-menu/delete') }}" + "/" +val;

        }

    </script>
@endsection