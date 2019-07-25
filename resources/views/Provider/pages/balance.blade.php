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

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{trans('site.balance')}}</h4>
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

                    <div class="py-2 rounded-lg shadow-around mt-4 bg-white">
                        <div class="row">

                            <div class="col-lg-8 col-12 text-center font-body-bold py-2">
                                <h2 class="balance">{{ $balance }}<span>{{trans('site.riyal')}}</span></h2>
                                <h4 class="mt-3">{{trans('site.available_balance')}}</h4>
                            </div>

                            <div class="col-lg-4 col-12 text-left">
                                <div class="d-flex justify-content-center my-4">
                                    <a href="{{ url("/restaurant/balance/withdraw") }}" class="btn btn-primary px-4"> {{trans('site.withdraw')}}</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden bg-white" >

                        <div class="table-responsive bg-light ">

                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">{{trans('site.operation_type')}}</th>
                                    <th scope="col">{{trans('site.operation_num')}}</th>
                                    <th scope="col">{{trans('site.value')}}</th>
                                    <th scope="col">{{trans('site.date')}}</th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                @foreach($logs as $log)
                                    <tr>
                                        <th scope="row" class="font-body-md text-nowrap">{{ ($log->balance_action == "order") ? trans("provider.order_meal") : trans("provider.withdraw_request") }}</th>
                                        <td class="text-nowrap">{{ $log->code }}</td>
                                        <td class="text-nowrap">{{ $log->value }}{{ ($log->value_type == "increase") ? "+" : "-" }}  {{trans('site.riyal')}}</td>
                                        <td class="text-nowrap">{{ $log->created_at }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>


                    {{ $logs->links("Pagination.pagination") }}

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection