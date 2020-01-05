@extends('admin_panel.blank')
@section('title')
    - {{ $title  }}
@endsection

@section('style')
  <style>
      
       .hidden-element2{
           
           display:none;
       }
       
  </style>
  
@stop

@section('content')
    <!-- Page-header start -->
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">أضافة وجبة </h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="{{ url("/admin/dashboard") }}">الرئيسية</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ url("/admin/meals") }}">الوجبات</a>
                </li>
                <li class="breadcrumb-item"><a> أضافة </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="page-body">
        <!-- Basic Form Inputs card start -->

        @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success') }}</div>
        @endif

        @if(Session::has("error_no_file"))
            <div class="alert alert-danger top-margin">
                {{ Session::get("error_no_file") }}
            </div>
        @endif

        @if(Session::has("error"))
            <div class="alert alert-danger top-margin">
                {{ Session::get("error") }}
            </div>
        @endif


        <div class="card">
            <div class="card-header">
                <h5> أضافة الوجبة </h5>
            </div>
            <div class="card-block">
                <form   data-action="{{ url("/admin/meals/store") }}"   method="POST" id="add-meal-from"  enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <p> {{trans('site.meal_photo')}} <span
                                    class="text-gray font-body-md">{{trans('site.photo_note')}}</span></p>
                        <div class="custom-file h-auto">
                            <input type="file" name="file" class="add-meal-image custom-file-input" id="restaurant-logo"
                                   hidden>
                            <label style="border-style: dotted" class=" mb-0 cursor" for="restaurant-logo">
                                        <span class="d-inline-block border-gray rounded p-4">
                                            <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>
                                        </span>
                            </label>
                            <p id="meal-images-error"
                               class="hidden-element alert alert-danger top-margin">{{trans('site.choose_meal_photo')}}</p>
                        </div>
                    </div><!-- .form-group logo -->
                    <br>
                    <div class="top-margin add-meal-images row"></div>
                    <br> <br>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">أختر المطعم </label>
                        <div class="col-sm-10">
                            <select class="form-control" id="providers" name="provider_id">
                                <option value="">برجاء اختيار المطعم</option>
                                @if(isset($providers) && count($providers) > 0)
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}"
                                        >{{ $provider->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has("provider_id"))
                                {{ $errors->first("provider_id") }}
                            @endif
                        </div>
                    </div>


                    <div class="appendbrnaches"></div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الوجبة باللغة العربية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ar_name" value="{{ old("ar_name") }}"
                                   placeholder="من فضلك ادخل الاسم باللغة العربية">
                            @if($errors->has("ar_name"))
                                {{ $errors->first("ar_name") }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الوجبة باللغة الانجليزية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="en_name" value="{{ old("en_name" ) }}"
                                   placeholder="من فضلك ادخل الاسم باللغة الانجليزية">
                            @if($errors->has("en_name"))
                                {{ $errors->first("en_name") }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">السعرات الحرارية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="calories" value="{{ old("calories") }}"
                                   placeholder="السعرات الحرارية">
                            <div id="meal-calorie-error" class="top-margin hidden-element alert alert-danger"></div>
                        </div>
                    </div>

                    <div class="appendFootListCategories"></div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="available">متوفر جميع الاوقات</label>
                        <div class="col-sm-10">
                            <select class="form-control"
                                    id="available" name="available" required>
                                <option value="">يرجى تحديد الحالة</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                        </div>

                    </div><!-- .form-group available -->


                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label" for="input-tags">
                            {{trans('site.ingredientsAR')}}
                            <span class="text-gray font-body-md">
                                        ({{trans('site.ingredients_note')}})
                                    </span>
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text"
                                   name="ar_component"
                                   id="input-tags" required>
                        </div>
                    </div><!-- .form-group tags -->




                    <div class="form-group row">
                        <label  class="col-sm-2 col-form-label" for="input-tags">
                            {{trans('site.ingredientsEN')}}
                            <span class="text-gray font-body-md">
                                        ({{trans('site.ingredients_note')}})
                                    </span>
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text"
                                   name="en_component"
                                   id="input-tags" required>
                        </div>
                    </div><!-- .form-group tags -->


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="spicy">حار</label>

                        <div class="col-sm-10">
                            <select class="form-control"
                                    id="spicy" name="spicy" required>
                                <option value="">يرجى تحديد القيمة</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                            @if($errors->has("spicy"))
                                {{ $errors->first("spicy") }}
                            @endif
                        </div>
                    </div><!-- .form-group spicy -->

                    <div class="form-group spicyDiv row">
                        <label class="col-sm-2 col-form-label" for="spicy-degree">درجة حرارة الصنف</label>

                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control border-gray font-body-md"
                                   name="spicy-degree"
                                   value="{{ old("spicy-degree") }}"
                                   placeholder="برجاء ادخال قيمة من 1 الى 5"
                                   id="spicy-degree">
                            @if($errors->has("spicy_degree"))
                                {{ $errors->first("spicy_degree") }}
                            @endif
                        </div><!-- .form-group name -->
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="vegetable">مناسب للنباتيين</label>

                        <div class="col-sm-10">
                            <select class="form-control"
                                    id="vegetable" name="vegetable" required>
                                <option value="">يرجى تحديد القيمة</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>

                            @if($errors->has("vegetable"))
                                {{ $errors->first("vegetable") }}
                            @endif

                        </div>
                    </div><!-- .form-group vegetable -->

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="gluten">خالي من الجلوتين </label>
                        <div class="col-sm-10">
                            <select class="form-control"
                                    id="gluten" name="gluten" required>
                                <option value="">يرجى تحديد القيمة</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>

                            @if($errors->has("gluten"))
                                {{ $errors->first("gluten") }}
                            @endif


                        </div>
                    </div><!-- .form-group gluten -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="calorie">
                            عدد السعرات الحرارية
                            <span class="text-gray font-body-md">السعرات الكلية للطلب متوسط الحجم</span>
                        </label>
                        <div class="col-sm-10">
                            <input type="text"
                                   class="form-control border-gray font-body-md"
                                   id="calorie"
                                   value="{{ old("calorie") }}"
                                   name="calorie" required>


                            @if($errors->has("calories"))
                                {{ $errors->first("calories") }}
                            @endif

                        </div>

                    </div><!-- .form-group calorie -->

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="details"> الوصف باللغة العربية <span
                                    class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                        <div class="col-sm-10">
                            <input class="ar-details form-control font-body-md border-gray"
                                   name="ar_description"
                                   value="{{ old("ar_description") }}">
                            <p id="ar-details-error" class="hidden-element alert alert-danger top-margin"> {{trans('site.min_5_words')}} </p>
                        </div>
                    </div><!-- .form-group details -->


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="details"> الوصف باللغة الانجليزية <span
                                    class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                        <div class="col-sm-10">
                            <input class="en-details form-control en-details font-body-md border-gray"
                                   id="details"
                                   name="en_description"
                                   value="{{ old("en_description") }}"
                                   required>
                            <p id="en-details-error" class="hidden-element alert alert-danger top-margin"> {{trans('site.min_5_words')}}</p>

                        </div>
                    </div><!-- .form-group details -->

                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <p>{{trans('site.sizesinarabic')}}</p>
                            <div class="form-group">
                                <input type="text"
                                       id="size1"
                                       name="size1"
                                       class="form-control font-body-md border-gray"
                                       placeholder="مثال: كبير"
                                       required>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size2"
                                       name="size2"
                                       class="form-control font-body-md border-gray"
                                >
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size3"
                                       name="size3"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size4"
                                       name="size4"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size5"
                                       name="size5"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                        </div><!-- .col -->

                        <div class="col-sm-3 col-6">
                            <p>{{trans('site.sizesinenglish')}}</p>
                            <div class="form-group">
                                <input type="text"
                                       id="size1_en"
                                       name="size1_en"
                                       class="form-control font-body-md border-gray"
                                       placeholder="ex:big"
                                       required>
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size2_en"
                                       name="size2_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size3_en"
                                       name="size3_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size4_en"
                                       name="size4_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="size5_en"
                                       name="size5_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                        </div><!-- .col -->
                        <div class="col-sm-6 col-12">

                            <p>{{trans('site.price')}}</p>

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="price1"
                                       name="price1"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon" required>
                                <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white  font-body-md text-gray">{{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="price2"
                                       name="price2"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="price3"
                                       name="price3"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->

                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="price4"
                                       name="price4"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="price5"
                                       pattern="^[0-9]+$"
                                       name="price5"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->
                        </div><!-- .col -->
                    </div>


                    <div class="row">
                        <div class="col-sm-3 col-6">
                            <p> {{trans('site.optionsinarabic')}} </p>
                            <div class="form-group">
                                <input type="text"
                                       id="add1"
                                       name="add1"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add2"
                                       name="add2"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add3"
                                       name="add3"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add4"
                                       name="add4"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add5"
                                       name="add5"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                        </div><!-- .col -->
                        <div class="col-sm-3 col-6">
                            <p> {{trans('site.optionsinenglish')}} </p>
                            <div class="form-group">
                                <input type="text"
                                       id="add1_en"
                                       name="add1_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add2_en"
                                       name="add2_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add3_en"
                                       name="add3_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add4_en"
                                       name="add4_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="add5_en"
                                       name="add5_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                        </div><!-- .col -->
                        <div class="col-sm-6 col-12">

                            <p>{{trans('site.added_price')}}</p>

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="add-price1"
                                       name="add-price1"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> <p>{{trans('site.riyal')}}</p>
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="add-pric2"
                                       name="add-price2"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="add-price3"
                                       name="add-price3"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->

                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="add-price4"
                                       name="add-price4"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="add-price5"
                                       pattern="^[0-9]+$"
                                       name="add-price5"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                        </div><!-- .col -->
                    </div>


                    <div class="row">
                        <div class="col-sm-3 col-12">
                            <p> {{trans('site.addsinarabic')}}</p>
                            <div class="form-group">
                                <input type="text"
                                       id="option1"
                                       name="option1"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option2"
                                       name="option2"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option3"
                                       name="option3"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option4"
                                       name="option4"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option5"
                                       name="option5"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                        </div><!-- .col -->
                        <div class="col-sm-3 col-12">
                            <p> {{trans('site.addsinenglish')}}</p>
                            <div class="form-group">
                                <input type="text"
                                       id="option1_en"
                                       name="option1_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option2_en"
                                       name="option2_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option3_en"
                                       name="option3_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option4_en"
                                       name="option4_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                            <div class="form-group">
                                <input type="text"
                                       id="option5_en"
                                       name="option5_en"
                                       class="form-control font-body-md border-gray">
                            </div><!-- .form-group -->
                        </div><!-- .col -->
                        <div class="col-sm-6 col-12">

                            <p>{{trans('site.added_price')}}</p>

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="option-price1"
                                       name="option-price1"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="option-pric2"
                                       name="option-price2"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="option-price3"
                                       name="option-price3"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->

                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="option-price4"
                                       name="option-price4"
                                       pattern="^[0-9]+$"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                <input type="text"
                                       id="option-price5"
                                       pattern="^[0-9]+$"
                                       name="option-price5"
                                       class="form-control  font-body-md rounded-0"
                                       aria-describedby="price-addon">
                                <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white  font-body-md text-gray"> {{trans('site.riyal')}}
                                        </span>
                                </div><!-- .input-group-prepend -->
                            </div><!-- .input-group -->

                        </div><!-- .col -->
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="recommended">ينصح به من قبل المطعم </label>

                        <div class="col-sm-10">
                            <select name="recommended" class="form-control"
                                    required>
                                <option value="">برجاء اختيار الحالة</option>
                                <option value="1">نعم</option>
                                <option value="0">لا</option>
                            </select>
                            @if($errors->has("recommended"))
                                {{ $errors->first("recommended") }}
                            @endif
                        </div>
                    </div><!-- .form-group gluten -->

                    <button type="submit" id="add-meal-btn" class="btn   btn-md btn-success"><i class="icofont icofont-check"></i> حفظ
                    </button>
                    <a href="{{ url("/admin/meals") }}" class="btn btn-md btn-danger"><i
                                class="icofont icofont-close"></i> رجوع </a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset("/assets/site/js/add-meal.js") }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //get provider branches
        $(document).on('change', '#providers', function (e) {
            e.preventDefault();
            $.ajax({

                type: 'post',
                url: "{{Route('admin.meals.providerbranches')}}",
                data: {
                    'parent_id': $(this).val(),
                    //'_token'   :   $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    $('.appendbrnaches').empty().append(data.branches);
                    $('.appendFootListCategories').empty().append(data.appendFootListCategories);

                }
            });
        });


        $(document).on('change', '#spicy', function () {
            if ($(this).val() == "0") {
                $('.spicyDiv').hide();
            } else {
                $('.spicyDiv').show();
            }
        });
    </script>
@stop