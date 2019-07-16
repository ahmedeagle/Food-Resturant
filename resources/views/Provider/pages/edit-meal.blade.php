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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">تعديل الصنف</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <form data-action="{{ url("/restaurant/food-menu/edit") }}" id="edit-meal-from" class="new-kind-form multi-forms">

                            <div class="form-group">
                                <p> صور الصنف <span class="text-gray font-body-md">امتداد الصور المسموح بها هو jpg-jpeg-png</span></p>
                                <div class="custom-file h-auto">
                                    <input type="file" name="file" class="add-meal-image custom-file-input" id="restaurant-logo" hidden>
                                    <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <span class="d-inline-block border-gray rounded p-4">
                                            <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>
                                        </span>
                                    </label>
                                    <p id="meal-images-error" class="hidden-element alert alert-danger top-margin">برجاء اختيار صور الوجبة</p>
                                </div>
                            </div><!-- .form-group logo -->

                            <div class="top-margin add-meal-images row">

                                @foreach($images as $img)
                                    <div>
                                        <input class="image_id" type="hidden" value="{{ $img->image_id }}" />
                                        <i class='delete-img fa fa-times' aria-hidden='true'></i>
                                        <img class='io' src='{{ $img->meal_image_url }}' />
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="kind-name">الإسم باللغة العربية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="ar_name"
                                       value="{{ old("ar_name", $meal->ar_name) }}"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="kind-name">الإسم باللغة الانجليزية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="en_name"
                                       value="{{ old("en_name", $meal->en_name) }}"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="categorie">تصنيف الوجية</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="categorie" name="category" required>
                                    <option value="">يرجى تحديد التصنيف</option>
                                    @foreach($cats as $cat)

                                        <option value="{{ $cat->id }}" @if($meal->mealCategory_id == $cat->id) selected @endif>{{ $cat->name }}</option>

                                    @endforeach
                                </select>
                            </div><!-- .form-group available -->


                            <div class="form-group">
                                <label for="categorie">الفروع المتوفر بها التصنيف</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="branch" name="branch" required>
                                    <option value="">يرجى تحديد الفرع</option>

                                    @foreach($branches as $branch)

                                        <option value="{{ $branch->id }}" @if($meal->branch_id == $branch->id) selected @endif>{{ $branch->name }}</option>

                                    @endforeach
                                </select>
                            </div><!-- .form-group available -->

                            <div class="form-group">
                                <label for="input-tags">
                                    المكونات
                                    <span class="text-gray font-body-md">
                                        (يرجى وضع فاصلة بين كل مكون والآخر)
                                    </span>
                                </label>
                                <input type="text"
                                       name="component"
                                       value="{{ $component }}"
                                       id="input-tags" required>
                            </div><!-- .form-group tags -->

                            <div class="form-group">
                                <label for="available">متوفر جميع الاوقات</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="available" name="available" required>
                                    <option value="">يرجى تحديد الحالة</option>
                                    <option value="1" @if($meal->available == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->available == "0") selected @endif>لا</option>
                                </select>
                            </div><!-- .form-group available -->

                            <div class="form-group">
                                <label for="spicy">حار</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="spicy" name="spicy" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" @if($meal->spicy == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->spicy == "0") selected @endif>لا</option>
                                </select>
                            </div><!-- .form-group spicy -->

                            <div class="spicy-degree-container form-group @if($meal->spicy == "0") hidden-element @endif">
                                <label for="spicy-degree">درجة حرارة الصنف</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="spicy-degree"
                                       value="{{ old("spicy-degree", $meal->spicy_degree) }}"
                                       placeholder="برجاء ادخال قيمة من 1 الى 5"
                                       id="spicy-degree">
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="vegetable">مناسب للنباتيين</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="vegetable" name="vegetable" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" @if($meal->vegetable == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->vegetable == "0") selected @endif>لا</option>
                                </select>
                            </div><!-- .form-group vegetable -->

                            <div class="form-group">
                                <label for="gluten">خالي من الجلوتين </label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="gluten" name="gluten" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" @if($meal->gluten == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->gluten == "0") selected @endif>لا</option>
                                </select>
                            </div><!-- .form-group gluten -->

                            <div class="form-group">
                                <label for="calorie">
                                    عدد السعرات الحرارية
                                    <span class="text-gray font-body-md">السعرات الكلية للطلب متوسط الحجم</span>
                                </label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       id="calorie"
                                       value="{{ old("calorie", $meal->calories) }}"
                                       name="calorie" required>
                                <div id="meal-calorie-error" class="top-margin hidden-element alert alert-danger"></div>
                            </div><!-- .form-group calorie -->

                            <div class="form-group">
                                <label for="details"> الوصف باللغة العربية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                <textarea class="form-control ar-details font-body-md border-gray"
                                          id="details"
                                          name="ar_description"
                                          rows="6" required>{{ old("ar_description", $meal->ar_description) }}</textarea>
                            </div><!-- .form-group details -->


                            <div class="form-group">
                                <label for="details"> الوصف باللغة الانجليزية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                <textarea class="form-control en-details font-body-md border-gray"
                                          id="details"
                                          name="en_description"
                                          rows="6" required>{{ old("en_description", $meal->en_description) }}</textarea>
                            </div><!-- .form-group details -->

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>الأحجام</p>

                                    @foreach($sizes as $key => $s)
                                        <div class="form-group">
                                            <input type="text"
                                                   id="size{{ $key + 1 }}"
                                                   name="size{{ $key + 1 }}"
                                                   value="{{ old("size". ($key + 1) ."", $s->size_name) }}"
                                                   class="form-control font-body-md border-gray" @if($key == 0) required @endif>
                                        </div><!-- .form-group -->

                                    @endforeach
                                    @if(count($sizes) <= 5)
                                        @for($i=0; $i <= (5- count($sizes)) - 1; $i++)
                                            <div class="form-group">
                                                <input type="text"
                                                       id="size{{ count($sizes) + $i + 1}}"
                                                       name="size{{ count($sizes) + $i + 1 }}"
                                                       value="{{ old("size". (count($sizes) + $i + 1) ."") }}"
                                                       class="form-control font-body-md border-gray">
                                            </div><!-- .form-group -->
                                        @endfor
                                    @endif
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p>السعر</p>
                                    @foreach($sizes as $key => $s)
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="price{{ $key + 1 }}"
                                                   name="price{{ $key + 1 }}"
                                                   pattern="^[0-9]+$"
                                                   value="{{ old("price". ($key + 1) ."", $s->price) }}"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon" @if($key == 0) required @endif>
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                    @endforeach

                                    @if(count($sizes) <= 5)
                                        @for($i=0; $i<= (5- count($sizes)) -1 ; $i++)

                                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                                <input type="text"
                                                       id="price{{ count($sizes) + $i +1 }}"
                                                       name="price{{ count($sizes) + $i +1 }}"
                                                       pattern="^[0-9]+$"
                                                       value="{{ old("price". (count($sizes) + $i + 1) ."") }}"
                                                       class="form-control border-0 font-body-md rounded-0"
                                                       aria-describedby="price-addon">
                                                <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        @endfor
                                    @endif


                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>الاضافات</p>

                                    @foreach($adds as $key => $s)
                                        <div class="form-group">
                                            <input type="text"
                                                   id="add{{ $key + 1 }}"
                                                   name="add{{ $key + 1 }}"
                                                   value="{{ old("add". ($key + 1) ."", $s->name) }}"
                                                   class="form-control font-body-md border-gray">
                                        </div><!-- .form-group -->

                                    @endforeach
                                    @if(count($adds) <= 5)
                                        @for($i=0; $i <= (5- count($adds)) - 1; $i++)
                                            <div class="form-group">
                                                <input type="text"
                                                       id="add{{ count($adds) + $i + 1}}"
                                                       name="add{{ count($adds) + $i + 1 }}"
                                                       value="{{ old("add". (count($adds) + $i + 1) ."") }}"
                                                       class="form-control font-body-md border-gray">
                                            </div><!-- .form-group -->
                                        @endfor
                                    @endif
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p>السعر المضاف</p>
                                    @foreach($adds as $key => $s)
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="add-price{{ $key + 1 }}"
                                                   name="add-price{{ $key + 1 }}"
                                                   pattern="^[0-9]+$"
                                                   value="{{ old("add-price". ($key + 1) ."", $s->price) }}"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon">
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                    @endforeach

                                    @if(count($adds) <= 5)
                                        @for($i=0; $i<= (5- count($adds)) -1 ; $i++)

                                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                                <input type="text"
                                                       id="add-price{{ count($adds) + $i +1 }}"
                                                       name="add-price{{ count($adds) + $i +1 }}"
                                                       pattern="^[0-9]+$"
                                                       value="{{ old("add-price". (count($adds) + $i + 1) ."") }}"
                                                       class="form-control border-0 font-body-md rounded-0"
                                                       aria-describedby="price-addon">
                                                <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        @endfor
                                    @endif


                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>التفضيلات</p>

                                    @foreach($options as $key => $s)
                                        <div class="form-group">
                                            <input type="text"
                                                   id="option{{ $key + 1 }}"
                                                   name="option{{ $key + 1 }}"
                                                   value="{{ old("option". ($key + 1) ."", $s->name) }}"
                                                   class="form-control font-body-md border-gray">
                                        </div><!-- .form-group -->

                                    @endforeach
                                    @if(count($options) <= 5)
                                        @for($i=0; $i <= (5- count($options)) - 1; $i++)
                                            <div class="form-group">
                                                <input type="text"
                                                       id="option{{ count($options) + $i + 1}}"
                                                       name="option{{ count($options) + $i + 1 }}"
                                                       value="{{ old("option". (count($options) + $i + 1) ."") }}"
                                                       class="form-control font-body-md border-gray">
                                            </div><!-- .form-group -->
                                        @endfor
                                    @endif
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p>السعر المضاف</p>
                                    @foreach($options as $key => $s)
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="option-price{{ $key + 1 }}"
                                                   name="option-price{{ $key + 1 }}"
                                                   pattern="^[0-9]+$"
                                                   value="{{ old("option-price". ($key + 1) ."", $s->price) }}"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon">
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                    @endforeach

                                    @if(count($options) <= 5)
                                        @for($i=0; $i<= (5- count($options)) -1 ; $i++)

                                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                                <input type="text"
                                                       id="option-price{{ count($options) + $i +1 }}"
                                                       name="option-price{{ count($options) + $i +1 }}"
                                                       pattern="^[0-9]+$"
                                                       value="{{ old("option-price". (count($options) + $i + 1) ."") }}"
                                                       class="form-control border-0 font-body-md rounded-0"
                                                       aria-describedby="price-addon">
                                                <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        @endfor
                                    @endif


                                </div><!-- .col -->
                            </div>


                            <div class="form-group">
                                <label for="recommended">ينصح به من قبل المطعم </label>
                                <select name="recommended" class="custom-select text-gray font-body-md border-gray" required>
                                    <option value="">برجاء اختيار الحالة</option>
                                    <option value="1" @if($meal->recommend == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->recommend == "0") selected @endif>لا</option>
                                </select>
                            </div><!-- .form-group gluten -->

                            <input type="hidden" name="meal_id" value="{{ $meal->id }}" />
                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5">تعديل</button>
                        </form><!-- .new-kind-form -->
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
@endsection

@section("script")
    <script src="{{ asset("/assets/site/js/add-meal.js") }}"></script>
@endsection