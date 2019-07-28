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
                        <h4 class="page-title font-body-bold"> {{trans('site.my_previous_tickets')}}</h4>
                    </div>

                    @if(Session::has('success'))
                        <div class="alert alert-success top-margin">

                            {{ Session::get('success') }}

                        </div>
                    @endif

                    @if(count($tickets) > 0)
                    <div class="rounded-lg shadow-around mt-3 overflow-hidden">

                        <div class="table-responsive bg-white">
                            
                            <table class="table table-striped">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col-7">{{trans('site.subject')}}</th>
                                    <th scope="col-4">{{trans('site.date')}}</th>
                                </tr>

                                </thead>


                                <tbody class="font-body-md text-gray border-bottom bg-white">

                                @foreach($tickets as $ticket)
                                    <tr>
                                        <th scope="row" class="font-body-md text-nowrap "><a href="{{ url("/restaurant/contact-us/ticket/details/". $ticket->id) }}">{{ $ticket->title }}</a></th>
                                        <td class="text-nowrap">{{ $ticket->created_at }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            
                        </div>

                    </div>
                    @else
                        <div class="mt-4">{{trans('site.tickets_list_empty')}}</div>
                    @endif
                    {{ $tickets->links('Pagination.pagination') }}

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection