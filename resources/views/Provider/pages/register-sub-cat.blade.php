@extends('Provider.layouts.master')
@section('title')
     {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')

    <main class="page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">متابعة ادخال البيانات</h1>
            <p class="description text-gray font-body-md mt-3">برجاء اختيار تصنيف المطعم</p>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">

                    <form id="register-food-form" action="{{ url("/restaurant/complete-profile/cat") }}" method="POST" class="mt-4 font-body-md " data-toggle="buttons">

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
                                            <label class="btn btn-primary f-food">
                                                <input data-id = "{{ $cat->id }}" class="form-check-input{{ $key }}" type="checkbox" />
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
                            <button type="submit" id="register-food-btn" class="btn btn-primary px-5 mx-auto text-center">متابعة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main><!-- .page-content -->

@endsection