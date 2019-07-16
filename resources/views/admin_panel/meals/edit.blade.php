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
        <h5 class="m-b-10">تصنيفات المنتجات</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="{{ url("/admin/dashboard") }}">الرئيسية</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ url("/admin/meals") }}">الوجبات</a>
            </li>
            <li class="breadcrumb-item"><a>تعديل</a>
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    <!-- Basic Form Inputs card start -->
    <div class="card">
        <div class="card-header">
            <h5>تعديل الوجبة </h5>
        </div>
        <div class="card-block">
            <form action="{{ url("/admin/meals/edit") }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $meal->id }}" />
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">اسم الوجبة باللغة العربية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ar_name" value="{{ old("ar_name", $meal->ar_name) }}" placeholder="من فضلك ادخل الاسم باللغة العربية">
                        @if($errors->has("ar_name"))
                            {{ $errors->first("ar_name") }}
                        @endif
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">اسم الوجبة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_name" value="{{ old("en_name", $meal->en_name) }}" placeholder="من فضلك ادخل الاسم باللغة الانجليزية">
                        @if($errors->has("en_name"))
                            {{ $errors->first("en_name") }}
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">السعرات الحرارية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="calories" value="{{ old("calories", $meal->calories) }}" placeholder="السعرات الحرارية">
                        @if($errors->has("calories"))
                            {{ $errors->first("calories") }}
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">تصنيف الوجبة</label>
                    <div class="col-sm-10">

                        <select class="form-control" name="cat">
                            <option value="">برجاء اختيار تصنيف الوجبة</option>
                            @foreach($cats as $cat)
                                <option value="{{ $cat->id }}" @if($cat->id == $meal->cat_id) selected @endif>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has("cat"))
                            {{ $errors->first("cat") }}
                        @endif
                    </div>
                    
                </div>
                
                   <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="available">متوفر جميع الاوقات</label>
                             <div class="col-sm-10">    
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="available" name="available" required>
                                    <option value="">يرجى تحديد الحالة</option>
                                    <option value="1" @if($meal->available == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->available == "0") selected @endif>لا</option>
                                </select>
                             </div>
                             
                            </div><!-- .form-group available -->

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="spicy">حار</label>
                                
                              <div class="col-sm-10">        
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="spicy" name="spicy" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" @if($meal->spicy == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->spicy == "0") selected @endif>لا</option>
                                </select>
                                
                                 @if($errors->has("spicy"))
                            {{ $errors->first("spicy") }}
                        @endif
                             </div>    
                            </div><!-- .form-group spicy -->



                        <div class="form-group spicyDiv row  @if($meal->spicy == "0" ) hidden-element2 @endif">       
                                 <label  class="col-sm-2 col-form-label" for="spicy-degree">درجة حرارة الصنف</label>
                                
                                <div class="col-sm-10">        
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="spicy-degree"
                                       value="{{ old("spicy-degree", $meal->spicy_degree) }}"
                                       placeholder="برجاء ادخال قيمة من 1 الى 5"
                                       id="spicy-degree">
                                       
                                       
                       @if($errors->has("spicy_degree"))
                            {{ $errors->first("spicy_degree") }}
                        @endif
                             </div><!-- .form-group name -->
                        </div>    
                            
                            
                            

                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label" for="vegetable">مناسب للنباتيين</label>
                                 
                                  <div class="col-sm-10">        
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="vegetable" name="vegetable" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" @if($meal->vegetable == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->vegetable == "0") selected @endif>لا</option>
                                </select>
                                
                                  @if($errors->has("vegetable"))
                            {{ $errors->first("vegetable") }}
                        @endif
                        
                                </div>
                            </div><!-- .form-group vegetable -->

                            <div class="form-group row">
                                
                                <label class="col-sm-2 col-form-label" for="gluten">خالي من الجلوتين </label>
                                <div class="col-sm-10">        
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="gluten" name="gluten" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" @if($meal->gluten == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->gluten == "0") selected @endif>لا</option>
                                </select>
                                
                                  @if($errors->has("gluten"))
                            {{ $errors->first("gluten") }}
                        @endif
                        
                        
                                </div>
                            </div><!-- .form-group gluten -->

                            <div class="form-group row">
                                <label   class="col-sm-2 col-form-label" for="calorie">
                                    عدد السعرات الحرارية
                                    <span class="text-gray font-body-md">السعرات الكلية للطلب متوسط الحجم</span>
                                </label>
                                <div class="col-sm-10">        
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       id="calorie"
                                       value="{{ old("calorie", $meal->calories) }}"
                                       name="calorie" required>
                                       
                                        
                                 @if($errors->has("calories"))
                            {{ $errors->first("calories") }}
                        @endif
                        
                                     </div>  
                                
                            </div><!-- .form-group calorie -->

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="details"> الوصف باللغة العربية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                
                                <div class="col-sm-10">        
                                <textarea class="form-control ar-details font-body-md border-gray"
                                          id="details"
                                          name="ar_description"
                                          rows="6" >{{ old("ar_description", $meal->ar_description) }}</textarea>
                                          
                                          
                                          @if($errors->has("ar_description"))
                            {{ $errors->first("ar_description") }}
                        @endif
                        
                        
                                    </div>      
                            </div><!-- .form-group details -->


                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label" for="details"> الوصف باللغة الانجليزية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                
                                <div class="col-sm-10">        
                                <textarea class="form-control en-details font-body-md border-gray"
                                          id="details"
                                          name="en_description"
                                          rows="6" required>{{ old("en_description", $meal->en_description) }}</textarea>
                                          
                                             @if($errors->has("en_description"))
                            {{ $errors->first("en_description") }}
                        @endif
                        
                                </div>          
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
                                                   
                                                   
                                                   
                                             @if($errors->has("size1"))
                            {{ $errors->first("size1") }}
                        @endif
                        
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
                                                   
                                                            
                                             @if($errors->has("price1"))
                            {{ $errors->first("price1") }}
                        @endif
                        
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


                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label" for="recommended">ينصح به من قبل المطعم </label>
                                
                                <div class="col-sm-10">
                                <select name="recommended" class="custom-select text-gray font-body-md border-gray" required>
                                    <option value="">برجاء اختيار الحالة</option>
                                    <option value="1" @if($meal->recommend == "1") selected @endif>نعم</option>
                                    <option value="0" @if($meal->recommend == "0") selected @endif>لا</option>
                                </select>
                                
                                                
                                             @if($errors->has("recommended"))
                            {{ $errors->first("recommended") }}
                        @endif
                                </div>
                            </div><!-- .form-group gluten -->

 
 
                        <input type="hidden" name="meal_id" value="{{ $meal->id }}" />
  

                <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="{{ url("/admin/meals") }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')

 <script>
     
     $(document).on('change','#spicy',function(){
    
         if($(this).val() == "0")
         {
             
               $('.spicyDiv').hide();
             
         }else{
             
             $('.spicyDiv').show();
         }
            
         
     });
 </script>
@stop