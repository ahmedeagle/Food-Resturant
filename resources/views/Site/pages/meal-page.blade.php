@extends('Site.layouts.master')

@section('title')
    {{ $title }}
@endsection
@section('class')
    {{ $class }}
@endsection
@section('content')

        <main class="page-content py-5 mb-4 ">
        <div class="container">
            <div class="row">
                
                @if(auth()->user())
                    @include("User.includes.menu")
                @endif
                <div class="@if(auth()->user()) col-lg-9 col-md-8 col-12 @else col-lg-12 col-md-11 col-12 @endif mt-4 mt-md-0 ">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">{{ $meal->ar_name }}</h4>
                    </div>

                    <div class="mael-pic mt-4 rounded-lg shadow-around bg-white">
                        
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                        
                            <ol class="carousel-indicators">
                                @foreach($meal->images as $key => $img)
                                    <li data-target="#carouselExampleControls" data-slide-to="{{ $key }}" class="@if($key == 0) active @endif"></li>
                                @endforeach
                            </ol>

                            <div class="carousel-inner">
                                
                                @foreach($meal->images as $key => $img)
                                    
                                    <div class="carousel-item @if($key == 0) active @endif">
                                        <img style="width:825px;height:331px" class="d-block w-100" src="{{ $img->meal_image_url }}" alt="First slide" draggable="false">
                                    </div>
                                    
                                @endforeach
               
                            </div>
                            
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>


                        <!-- <div class="d-flex justify-content-center flex-sm-row">
                            <p class="page-content font-body-md text-gray py-2 py-3 px-3">
                                    هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                            </p>
                            <span class="love mt-xs-5 ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mr-sm-3 mt-2 mb-auto mt-sm-auto rounded-lg shadow-around">
                                <i class="fa fa-heart fa-lg text-white cursor"></i>
                            </span>

                        </div> -->

                        <div class="d-flex justify-content-center flex-column flex-sm-row pb-3">
                            <p class="page-content font-body-md text-gray py-3 px-3 mb-0">
                                {{ $meal->ar_description }}      
                            </p>
                        </div>
                    
                    </div>
                    
                    
                     <div class="p-3 rounded-lg shadow-around mt-4 bg-white">

                        <div class="table-responsive">
                        <table class="table mb-0 tebel-meal">
                            <thead>
                                
                                
                              <tr class="">
                                <th scope="col" class="border-top-0 font-body-md">درجة حراره الصنف  </th>
                                <th scope="col" class="border-top-0 font-body-md"></th>
                                <th scope="col" class="border-top-0   font-body-md">  خواص </th>
                 
                              </tr>

                              
                              
                            </thead>


                            <tbody>
                              <tr>
                                <th scope="row" class="font-body-md">
                                    
                                    
                                      @if($meal->spicy     == "1")
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        
                                      @elseif($meal->spicy == "2")
                                      
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      
                                      @elseif($meal->spicy == "3")
                                      
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      
                                      @elseif($meal->spicy == "4")
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      @elseif($meal->spicy == "5")
                                       <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/thermometer-icon.png"/></span>
                                      @else
                                      
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="{{url('/')}}/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        
                                      @endif

                                  
 
                                       
                                </th>
                                 <td class="text-primary font-body-md small-price">
                                     </td>
                                 <td class="text-primary font-body-md small-price">
                                     
                                @if($meal->vegetable == "1")
                                   <span class="" title="الوجبة نباتية"><img src="{{url('/')}}/storage/app/public/icons/vegetarian-meals-icon.png"/></span>
                                @endif
                                
                                @if($meal->calories)
                                   <span class="" title="{{ $meal->calories }} سعره حرارية"><img src="{{url('/')}}/storage/app/public/icons/no-gluten-icon.png"/></span>
                                @endif   
                                </td>
                                
                                
                                
                               
                              </tr>
                             
                              
                            </tbody>
                          </table>
                        </div>
                    </div>
                    

                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white">

                        <div class="table-responsive">
                        <table class="table mb-0 tebel-meal">
                            <thead>
                              <tr class="">
                                <th scope="col" class="border-top-0 font-body-md">السعرات الحرارية</th>
                                <th scope="col" class="border-top-0 text-primary font-body-md">{{ $meal->calories }} سعره حرارية</th>
                                <th scope="col" class="border-top-0 text-gray font-body-md">السعرات الكلية للطلب متوسط الحجم</th>
                
                              </tr>

                              <tr>
                                  <th scope="col" class="border-top-0 font-body-md">ينصح بها من قبل المطعم</th>
                                  <th scope="col" class="border-top-0 text-primary font-body-md">{{ ( $meal->recommend == "1") ? 'نعم' : 'لا' }}</th>
                                  <th></th>
                              </tr>

                            

                                @if(count($meal->sizes) == 0)
                                    <tr>
                                        <th scope="col" class="border-top-0 font-body-md">السعر</th>
                                        <th scope="col" class="border-top-0 text-primary font-body-md">{{ $meal->price }}</th>
                                        <th></th>
                                    </tr>
                                @endif
                              
                            </thead>


                            <tbody>
                              <tr>
                                <th scope="row" class="font-body-md">الحجم</th>
                                @if(count($meal->sizes) > 0)
                                <td>
                                    <div class="mr-4">
                                        @foreach($meal->sizes as $key => $size)
                                            <div class="custom-control custom-radio">
                                                <input
                                                        type="radio"
                                                        id="size_customRadio{{ $key + 1 }}"
                                                        value="{{ $size->id }}"
                                                        name="size_customRadio"
                                                        class="size_select custom-control-input"
                                                        {{--@if(count($cartData) > 0) @if($cartData['size'] == $size->id) checked @endif @endif--}}
                                                >
                                                <label class="custom-control-label text-gray mb-2" for="size_customRadio{{ $key + 1 }}">{{ $size->ar_name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                </td>
                                <td class="text-primary font-body-md small-price">
                                    @foreach($meal->sizes as $size)
                                        <div class="mb-2">
                                            {{ $size->price }} ر.س
                                        </div>
                                    @endforeach
                                </td>
                                @else
            
                                    <td>لا توجد احجام لهذة الوجبة</td>         
                                    <td></td>
            
                                @endif
                              </tr>
                              <tr>
                                <th scope="row" class="font-body-md">الإضافات</th>
                                @if(count($meal->adds) > 0)
                                <td>
                                    <div class="mr-4">
                                        @foreach($meal->adds as $key => $add)
                                        
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                        type="checkbox"
                                                        class="adds_select custom-control-input"
                                                        value="{{ $add->id }}"
                                                        id="add_customCheck{{ $key + 1 }}"
                                                        {{--@if(count($cartData) > 0) @if(in_array($add->id, $cartData['adds'])) checked @endif @endif--}}
                                                >
                                                <label class="custom-control-label text-gray mb-2" for="add_customCheck{{ $key + 1 }}">{{ $add->ar_name }}</label>
                                            </div>
                                        
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-primary font-body-md ">
                                    
                                    @foreach($meal->adds as $add)
                                        <div class="mb-2">
                                            {{ $add->added_price }} ر.س
                                        </div> 
                                    @endforeach
                                </td>
                                @else
                                    <td>لا توجد اضافات لهذة الوجبة</td>
                                    <td></td>
                                @endif
                                
                              </tr>
                              
                              <tr>
                              <th scope="row" class="font-body-md">التفضيلات</th>
                                @if(count($meal->options) > 0)
                                <td>
                                    <div class="mr-4">
                                        @foreach($meal->options as $key => $option)
                                        
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                        type="checkbox"
                                                        class="options_select custom-control-input"
                                                        value="{{ $option->id }}"
                                                        id="option_customCheck{{ $key + 1 }}"
                                                        {{--@if(count($cartData) > 0) @if(in_array($option->id, $cartData['options'])) checked @endif @endif--}}
                                                >
                                                <label class="custom-control-label text-gray mb-2" for="option_customCheck{{ $key + 1 }}">{{ $option->ar_name }}</label>
                                            </div>
                                        
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-primary font-body-md ">
                                    
                                    @foreach($meal->options as $options)
                                        <div class="mb-2">
                                            {{ $options->added_price }} ر.س
                                        </div> 
                                    @endforeach
                                </td>
                                @else
                                    <td>لا يوجد تفضيلات لهذة الوجبة</td>
                                    <td></td>
                                @endif
                                
                              </tr>
                              
                            </tbody>
                          </table>
                        </div>
                    </div>

                    <div class="modal fade"
                         id="confirm-clear-cart"
                         tabindex="-1"
                         role="dialog"
                         aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content py-3">
                                <p class="modal-body h4 font-weight-bold text-center mb-auto">
                                    برجاء العلم ان جميع الوجبات بالسلة سوف يتم حذفها, حيث ان جميع الوجبات بالسلة يجب ان تكون تابعة لنفس المطعم
                                </p>
                                <div class="modal-footer d-flex justify-content-center pt-0">
                                    <button type="button"
                                            class="btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                            data-dismiss="modal">إلغاء</button>
                                    <a type="submit"
                                       onclick="decreaseValue()"
                                       class="btn btn-primary px-4 px-sm-5 font-weight-bold">حذف محتويات السلة</a>

                                    <a type="submit"
                                       onclick="{{ url("/user/cart") }}"
                                       class="btn btn-default px-4 px-sm-5 font-weight-bold">تصفح السلة</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user() && $meal->accept_order == "1")
                    <div class="p-3 rounded-lg shadow-around mt-4 d-flex bg-white justify-content-center flex-column flex-sm-row">
                        <label class="col-lg-6 co-md-4 col-xl-7 font-body-md">الكمية</label>
                        <span class="count-buttom d-inline-flex px-0">
                            <button onclick="decreaseValue()"  class="col min d-flex flex-column align-items-start"> - </button>
                            <span id="number" class="col counter d-flex flex-column align-items-center">
                                0
                                {{--@if(count($cartData) > 0) {{ $cartData['qty'] }} @else 0 @endif--}}
                            </span>
                            <button onclick="increaseValue()" class="col max d-flex flex-column align-items-end"> + </button>
                        </span>
                        <input type="hidden" value="{{ $meal->id }}" id="meal_id" />
                        <input type="hidden" value="{{ $clearing_cart_content_warning }}" id="clear_cart_alert" />
                        <input type="hidden" value="@if(count($meal->sizes) > 0) 1 @else 0 @endif" id="meal_has_sizes" />
                        <input type="hidden" value="{{ url("/user/cart/check-cart-content") }}" id="check_cart_content_url" />
                        <input type="hidden" value="{{ url("/user/cart/add") }}" id="add_cart_meal" />
                        <!-- <button type="submit" class="btn btn-primary font-body-bold px-lg-3 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto">
                                شراء (15 ر.س)
                        </button> -->

                        
                        <!--For test-->
                        <a href="{{ url("/user/cart") }}" class="btn btn-primary font-body-bold px-lg-3 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto">
                            شراء
                            (<span class="total_price_span">
                                {{--@if(count($cartData) >0) {{ $cartData['price'] }} @else 0 @endif --}}
                                0
                            </span>
                            ر.س)
                        </a><!--For test-->
                    </div>
                    @if($clearing_cart_content_warning == 1)

                        <div class="alert alert-warning">
                            برجاء العلم انة فى حالة وضع هذة الوجبة فى السلة فسوف يتم حذف جميع محتويات السلة حيث ان جميع وجبات السلة يجب ان تكون تابعة لنفس المطعم
                            <a style="color: blue;text-decoration: underline" href="{{ url("/user/cart") }}">تصفح محتويات السلة</a>
                        </div>

                    @endif
                    @endif

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection