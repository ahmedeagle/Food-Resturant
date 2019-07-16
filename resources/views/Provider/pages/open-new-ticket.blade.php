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
                        <h4 class="page-title font-body-bold">تذكرة جديدة</h4>
                    </div>

                    <form action="{{ url("/restaurant/contact-us/open-new-ticket") }}" method="POST">
                        {{ csrf_field() }}
                    <div class="p-3 rounded-lg shadow-around font-body-bold mt-4 bg-white">

                            <div class="form-group my-2">
                                <label for="messaging-type">نوع المراسلة</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="messaging-type"
                                        name="type">
                                    <option selected value="يرجى تحديد نوع المراسلة">يرجى تحديد نوع المراسلة</option>

                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('type'))
                                    <p class="alert alert-danger top-margin">
                                        {{ $errors->first('type') }}
                                    </p>
                                @endif
                            </div>


                            <div class="form-group my-2">
                                <label for="address">العنوان</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="address"
                                       name="title"
                                       value="{{ old("title") }}"
                                       placeholder=""
                                >
                                @if ($errors->has('title'))
                                    <p class="alert alert-danger top-margin">
                                        {{ $errors->first('title') }}
                                    </p>
                                @endif
                            </div>

                            <div class="form-group mb-1">
                                <label for="subject">الموضوع</label>
                                <textarea class="form-control font-body-md"
                                          id="subject"
                                          name="subject"
                                          rows="6">{{ old("subject") }}</textarea>
                                @if ($errors->has('subject'))
                                    <p class="alert alert-danger top-margin">
                                        {{ $errors->first('subject') }}
                                    </p>
                                @endif
                            </div>



                    </div>


                    <button type="submit" class="btn btn-primary py-2 px-5 mt-3">إرسال</button>
                    </form>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection