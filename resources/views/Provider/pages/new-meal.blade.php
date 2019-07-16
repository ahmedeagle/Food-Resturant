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
                        <h4 class="page-title">صنف جديد</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <form data-action="{{ url("/restaurant/food-menu/add-new-meal") }}" id="add-meal-from" class="new-kind-form multi-forms">
                            {{ csrf_field() }}
                            <div class="form-group">
                                 
                             <a  href="{{ url("/restaurant/download-rules") }}">     
                                <label class="border-0 mb-0 cursor" >
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl_iQ9tX59-heOF1cAF4BB5ndB8TUxJT_jtD6JUkdoV2WjEfRv" class="d-inline-block rounded-circle" width="86" height="86" >
                                    <span class="font-body-md mr-2 text-primary">
                                    
                                      تحميل ضوابط معلومات قوائم الطعام والوجبات 
                                        
                                      </span>
                                </label>
                                
                                </a>
                                
                            </div>
                            
                            <hr>
                            
                            <div class="form-group">
                                <p> صور الصنف  <span class="text-gray font-body-md">امتداد الصور المسموح بها هو jpg-jpeg-png</span></p>
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

                            </div>

                            <div class="form-group">
                                <label for="kind-name">الإسم باللغة العربية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="ar_name"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="kind-name">الإسم باللغة الانجليزية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="en_name"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="categorie">تصنيف الوجية</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="categorie" name="category" required>
                                    <option value="">يرجى تحديد التصنيف</option>
                                    @foreach($cats as $cat)

                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>

                                    @endforeach
                                </select>
                            </div><!-- .form-group available -->


                            <div class="form-group">
                                <label for="categorie">الفروع المتوفر بها التصنيف</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="branch" name="branch" required>
                                    <option value="">يرجى تحديد الفرع</option>
                                    <option value="0">يوجد بجميع الفروع</option>
                                    @foreach($branches as $branch)

                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>

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
                                       id="input-tags" required>
                            </div><!-- .form-group tags -->

                            <div class="form-group">
                                <label for="available">متوفر جميع الاوقات</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="available" name="available" required>
                                    <option value="">يرجى تحديد الحالة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div><!-- .form-group available -->

                            <div class="form-group">
                                <label for="spicy">حار</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="spicy" name="spicy" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div><!-- .form-group spicy -->

                            <div class="spicy-degree-container form-group hidden-element">
                                <label for="spicy-degree">درجة حرارة الصنف</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="spicy-degree"
                                       placeholder="برجاء ادخال قيمة من 1 الى 5"
                                       id="spicy-degree">
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="vegetable">مناسب للنباتيين</label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="vegetable" name="vegetable" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div><!-- .form-group vegetable -->

                            <div class="form-group">
                                <label for="gluten">خالي من الجلوتين </label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="gluten" name="gluten" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
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
                                       name="calorie" required>
                                <div id="meal-calorie-error" class="top-margin hidden-element alert alert-danger"></div>
                            </div><!-- .form-group calorie -->

                            <div class="form-group">
                                <label for="details"> الوصف باللغة العربية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                <textarea class="ar-details form-control font-body-md border-gray"
                                          id="details"
                                          name="ar_description"
                                          rows="6" required></textarea>
                                          
                                          <p id="ar-details-error" class="hidden-element alert alert-danger top-margin">يجب ان يكون الوصف علي الاقل 5 كلمات  </p>

                            </div><!-- .form-group details -->


                            <div class="form-group">
                                <label for="details"> الوصف باللغة الانجليزية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                <textarea class="en-details form-control font-body-md border-gray"
                                          id="details"
                                          name="en_description"
                                          rows="6" required></textarea>
                                          
                                           <p id="ثى-details-error" class="hidden-element alert alert-danger top-margin">يجب ان يكون الوصف علي الاقل 5 كلمات  </p>
                            </div><!-- .form-group details -->

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>الأحجام</p>
                                    <div class="form-group">
                                        <input type="text"
                                               id="size1"
                                               name="size1"
                                               class="form-control font-body-md border-gray" required>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="size2"
                                               name="size2"
                                               class="form-control font-body-md border-gray">
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
                                <div class="col-sm-6 col-12">

                                    <p>السعر</p>

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price1"
                                               name="price1"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon" required>
                                        <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price2"
                                               name="price2"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price3"
                                               name="price3"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->

                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price4"
                                               name="price4"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price5"
                                               pattern="^[0-9]+$"
                                               name="proice5"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>الإضافات</p>
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
                                <div class="col-sm-6 col-12">

                                    <p>السعر المضاف</p>

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price1"
                                               name="add-price1"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-pric2"
                                               name="add-price2"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price3"
                                               name="add-price3"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->

                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price4"
                                               name="add-price4"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price5"
                                               pattern="^[0-9]+$"
                                               name="add-price5"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>التفضيلات</p>
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
                                <div class="col-sm-6 col-12">

                                    <p>السعر المضاف</p>

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price1"
                                               name="option-price1"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-pric2"
                                               name="option-price2"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price3"
                                               name="option-price3"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->

                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price4"
                                               name="option-price4"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price5"
                                               pattern="^[0-9]+$"
                                               name="option-price5"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                </div><!-- .col -->
                            </div>


                            <div class="form-group">
                                <label for="recommended"> ينصح به من قبل المطعم <span class="text-gray font-body-md">اختيار فقط 3 من كل تصنيف</span> </label>
                                <select name="recommended" class="custom-select text-gray font-body-md border-gray" required>
                                    <option value="">برجاء اختيار الحالة</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div><!-- .form-group gluten -->

                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5">إضافة</button>
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