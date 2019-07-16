@extends("Provider.layouts.master")

@section('title')
    {{ $title }}
@endsection

@section('class')
    {{ $class }}
@endsection

@section("content")
    <main class="page-content py-5 mb-4">
        <div class="container">
            <div class="row">

                @include("Provider.pages.menu")

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">تغيير نوع الطعام</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        @if(Session::has("success"))
                            <div class="alert alert-success">
                                {{ Session::get("success") }}
                            </div>
                        @endif

                            <form id="register-food-form" action="{{ url("/restaurant/profile/change-meal-type") }}" method="POST" class="mt-4 font-body-md " data-toggle="buttons">
                                
                                {{csrf_field()}}

                                @php
                                    $count = 1;
                                    $addParent = true;
                                @endphp

                                <input type="hidden" class="food-count" value="{{ count($cats) }}" />
                                @foreach($cats as $key => $cat)

                                    @if($addParent)
                                        <div class="row justify-content-center">
                                            @endif

                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food @if($cat->selected == "1") active @endif">
                                                        <input
                                                                data-id = "{{ $cat->id }}"
                                                                class="form-check-input{{ $key }}"
                                                                type="checkbox"
                                                                @if($cat->selected == "1") checked @endif
                                                        />
                                                        {{ $cat->name }}
                                                    </label>
                                                </div>
                                            </div>

                                            @if($count < 4)
                                                @php
                                                    $count = $count + 1;
                                                    $addParent = false;
                                                @endphp

                                                @if(count($cats) == ($key +1))
                                        </div>
                            @endif
                            @continue
                            @else
                                @php
                                    $count =  1;
                                    $addParent = true;
                                @endphp
                            @endif
                    </div>
                    @endforeach

                    <div class="text-center mt-4 text-center">
                        <button type="submit" id="register-food-btn" class="btn btn-primary px-5 mx-auto text-center">تغيير</button>
                    </div>
                    </form>

                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection