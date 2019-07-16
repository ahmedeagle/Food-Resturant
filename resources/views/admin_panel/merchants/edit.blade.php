@extends('admin_panel.blank')
@section('title')
   - {{ $title  }} - {{$provider -> ar_name}}
@endsection


@section('style') 
  <style>
      
       .hidden-element{
           
           
           display:none;
       }
       
  </style>
@stop

@section('content')

<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">التجار</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?= url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?= url('admin_panel/providers/all')?>"> التجار</a>
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
            <h5>        تعديل بيانات التاجر {{$provider -> ar_name}} </h5>
         </div>
         <div class="card-block">
                 
                   
                         <form id="provider-register-form" method="POST" class="register-form mt-4" action="{{ url("admin/providers/update".'/'.$provider -> provider_id)}}">
                             
                             {{csrf_field()}}

                       <div class="top-margin form-group">
                            <a style="color: blue;text-decoration: underline" href="{{url('admin/providers/profile/change_meal_type'.'/'.$provider -> provider_id)}}">تغيير نوع الطعام المقدم</a>
                        </div>
                        
                           @if(Session::has("success"))
                            <div class="alert alert-success">
                                {{ Session::get("success") }}
                            </div>
                        @endif
                        
                          <div class="form-group">
                            <p>شعار المطعم</p>
                            <div class="custom-file h-auto">
                                <input type="file" class="edit-logo-file custom-file-input" id="restaurant-logo" hidden>
                                <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                    <img src="{{ $provider->provider_image_url }}"
                                         class="d-inline-block rounded-circle"
                                         width="86"
                                         height="86"
                                         id="edit-logo-image"
                                         alt="Restaurant Logo">
                                    <span class="font-body-md mr-2 text-primary">
                                        تغيير شعار المطعم
                                    </span>
                                </label>
                            </div>
                        </div><!-- .form-group logo -->
                        
                        <br><br><br>
                        
                        <button type="button" data-action="{{ url("admin/providers/profile/edit-image".'/'.$provider -> provider_id) }}" id="edit-logo-btn" class="hidden-element btn btn-primary py-2 px-5">تغيير</button>
                        
                                <br>

                                <div class="form-group">
                                    <label for="restaurant-ar-name">إسم المطعم باللغة العربية</label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                            value="{{ old("ar_name", $provider->ar_name) }}"
                                            name="ar_name"
                                       
                                           id="restaurant-ar-name" required>
                                           
                                             @if($errors->has("ar_name"))
                                                <div class="top-margin alert alert-danger">
                                                    {{ $errors->first('ar_name') }}
                                                </div>
                                              @endif

                                </div><!-- .form-group ar name -->
                                

                                <div class="form-group">
                                    <label for="restaurant-en-name">إسم المطعم باللغة الانجليزية</label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                            name="en_name"
                                            value="{{ old("en_name", $provider->en_name) }}"
                                       
                                           id="restaurant-en-name" required>
                                           
                                             @if($errors->has("en_name"))
                                                <div class="top-margin alert alert-danger">
                                                    {{ $errors->first('en_name') }}
                                                </div>
                                              @endif
                                </div><!-- .form-group en name -->

 
 
<br>                                

                                <div class="form-group">
                                    <label for="country">الدولة</label>
                                    <select class="country-ajax-request form-control country-ajax-request custom-select text-gray font-body-md" data-action="{{ url("/restaurant/cities") }}" name="country" id="country" required>
                                        <option value="">يرجى تحديد الدولة</option>
                                        @foreach($countries as $c)
                                            <option value="{{ $c->id }}"  @if($provider->country_id == $c->id) selected @endif>{{ $c->ar_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    
                                @if($errors->has("country"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('country') }}
                                    </div>
                                @endif
                                
                                </div><!-- .form-group country -->
                                
                                
                                
                                
                                 <!-- .form-group city -->

                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <select class="city-ajax-request form-control custom-select text-gray font-body-md border-gray"
                                        id="city" name="city">
                                    <option>يرجى تحديد المدينة</option>
                                    @foreach($cities as $c)
                                        <option value="{{ $c->id }}" @if($provider->city_id == $c->id) selected @endif>{{ $c->ar_name }}</option>
                                    @endforeach
                                </select>

                                @if($errors->has("city"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('city') }}
                                    </div>
                                @endif
                            </div><!-- .form-group city -->
                                
                                <div class="form-group">
                                <label for="accept_order"> تفعيل استلام الطلبات </label>
                                <select class="form-control custom-select text-gray font-body-md border-gray"
                                        id="accept_order" name="accept_order">
                                    <option value="0">يرجى  اختيار حالة </option>
                                    
                                        <option value="1" @if($provider->order_status == 1) selected @endif>مفعل</option>
                                        <option value="2" @if($provider->order_status ==0) selected @endif>غير مفعل </option>
                                   
                                </select>

                                @if($errors->has("accept_order"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('accept_order') }}
                                    </div>
                                @endif
                            </div><!-- .form-group recieve orders -->
                            
                            


                                <div class="form-group">
                                <label for="phone-number">رقم التواصل</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="phone-number"
                                       name="phone-number"
                                       placeholder="966-553-6556556+"
                                       value="{{ old("phone", $provider->phone) }}">

                                @if($errors->has("phone-number"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('phone-number') }}
                                    </div>
                                @endif

                            </div><!-- .form-group phone -->

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="email"
                                       name="email"
                                       value="{{ old("email", $provider->email) }}">

                                @if($errors->has("email"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif

                            </div><!-- .form-group email -->

                            <div class="form-group">
                                <label for="provider-details">نبذة عن الخدمة المقدمة باللغة العربية</label>
                                <textarea class="form-control font-body-md"
                                           name="ar_description"
                                          rows="6">{{ old("ar_description", $provider->ar_description) }}</textarea>

                                @if($errors->has("ar_description"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('ar_description') }}
                                    </div>
                                @endif

                            </div><!-- .form-group details -->
                            <div class="form-group">
                                <label for="provider-details">نبذة عن الخدمة المقدمة باللغة الانجليزية</label>
                                <textarea class="form-control font-body-md"
                                           name="en_description"
                                          rows="6">{{ old("en_description", $provider->en_description) }}</textarea>

                                @if($errors->has("en_description"))
                                    <div class="top-margin alert alert-danger">
                                        {{ $errors->first('en_description') }}
                                    </div>
                                @endif

                            </div><!-- .form-group details -->

                            <button type="submit" class="btn btn-primary py-2 px-5">تغيير</button>

                            </form><!-- .register-form -->
                            
                            
                            
                 
                 
         </div>
</div>

@endsection


@section('script')
   
   <script>
       
       
        // Request Function
    function request(url,type,data,beforeSend,success,error){
        $.ajax({
            url: url,
            type:type,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            processData: false,
            contentType: false,
            beforeSend: beforeSend,
            success: success,
            error:error
        });
    }
    
    
        /*
        *   Get the Cities List from the server
        * */
        
        
        

    $(".country-ajax-request").on('change', function(){
        
        var id = $(this).find(":selected").val();
        
         
       if( id == "") {
           $(".city-ajax-request").html("<option value=''>برجاء تحديد الدولة اولا</option>");
           $(".city-ajax-request").focus();
           return false;
       }

       var url = $(this).attr("data-action");

       var data = new FormData();
       data.append("country", id);

       request(url, "POST", data,function(){}, function(data){
           
           $(".city-ajax-request").html("<option value=''>يرجى تحديد المدينة</option>");
            $.each(data.cities, function(k,v){
               $(".city-ajax-request").append("<option value='"+ v.id +"'>"+ v.name +"</option>");
                $(".city-ajax-request").focus();
           })

       },function(error){

       });
    });
    
    
     // upload image function
    function  readURL(input, handler) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var data = e.target.result;
                var check = data.substr(0, data.indexOf(';')).slice(5).split("/");
                if(check[0] != "image") return false;
                handler(e);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
  // Display Provider logo function after upload from device
    function displayProviderLogo(e){

        $(".rounded-circle").attr('src', e.target.result);
        $("#provider-logo-content").addClass("hidden-element");
        $(".provider-uploaded-logo").removeClass("hidden-element");
    }
    
    
     $("#restaurant-logo").on('change', function(event){
        providerRegisterLogo = event.target.files;
        readURL(this, function (e) {
            displayProviderLogo(e);
        });
    });


  /*
    *
    *
    * *********************
    * *******************
    *   Profile page
    * *******************
    * *********************
    * */
    var editLogo = "";
    $(".edit-logo-file").on("change", function (event) {
        editLogo = event.target.files;
        readURL(this, function (e) {
            $("#edit-logo-image").attr('src', e.target.result);
            $("#edit-logo-btn").removeClass("hidden-element");
        });
    });

    $("#edit-logo-btn").on("click", function () {
       var url = $(this).attr("data-action");

       var imageData = new FormData();
        $.each(editLogo, function(k,v){
            imageData.append("image", v);
        });

       request(url, "POST", imageData, function(){}, function (data) {
           // success
           if(data.status == true){
               $("#edit-logo-btn").addClass("hidden-element");
               notif({
                   msg: "تم تعديل الصورة بنجاح",
                   type: "success"
               });
           }

       }, function (error) {
           // error
       })
    });
    
   </script>
@stop