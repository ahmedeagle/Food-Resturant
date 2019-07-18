@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection
 

@section("content")
    <main class="page-content py-5">
        <div class="container">

            <div class="row">

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0">

                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title font-body-bold"> اشعارات الاداره </h4>
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

                    @if(isset($notifications) && $notifications -> count() > 0)

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <div class="table-responsive bg-light">
                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">الموضوع </th>
                                     <th scope="col"> المحتوي </th>
                                    <th scope="col"> التاريخ </th>
                                    <th scope="col">الحالة </th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                    @foreach($notifications as $notification)
                                        <tr>
                                            
                                            <td class="text-nowrap">{{ $notification -> title }}</td>
                                            <td class="text-nowrap">

                                                 {{ $notification -> content }}

                                            </td>

                                            <td class="text-nowrap">

                                                 {{ $notification -> created_at }}

                                            </td>

                                            <td class="text-nowrap">

                                                 {{ $notification -> seen ==  '1' ? ' مقرؤه ': 'جديده  ' }}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
 

                        </div>

                    </div>

                    
                     @else
                        <div class="mt-4">
                            لايوجد اشعارات 
                        </div>
                    @endif

                       {{ $notification->links("Pagination.pagination") }}

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection

 