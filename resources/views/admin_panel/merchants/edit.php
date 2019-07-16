@extends('admin_panel.blank')
@section('title')
   - {{ $title  }} - {{$provider -> ar_name}}
@endsection

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
            <h5>        تعديل بيانات  التاجر {{$provider -> ar_name}} </h5>
         </div>
         <div class="card-block">
                 
                   
                                               <form action="{{ url("/user/register") }}" method="POST" class="register-form mt-5">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="user-name">الاسم كامل</label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                           name="user-name"
                                           value="{{ old("user-name") }}"
                                           id="user-name" required>
                                    @if($errors->has("user-name"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-name") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group name -->

                                <div class="form-group">
                                    <label for="country">الدولة</label>
                                    <select class="country-ajax-request custom-select text-gray font-body-md" data-action="{{ url("/restaurant/cities") }}" name="user-country" id="user-country" required>
                                        <option value="">يرجى تحديد الدولة</option>
                                        @foreach($countries as $c)
                                            <option value="{{ $c->id }}" @if(old('user-country') == $c->id) selected @endif>{{ $c->ar_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    @if($errors->has("user-country"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-country") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group country -->


                                <div class="form-group">
                                    <label for="city">المدينة</label>
                                    <select class="city-ajax-request custom-select text-gray font-body-md" id="user-city" name="user-city" required>
                                        @if(old("user-country"))
                                            <option value="">برجاء اختيار المدينة</option>
                                            @foreach(\App\Http\Controllers\User\HelperController::get_cities(old("user-country")) as $city)
                                                <option value="{{ $city->id }}" @if(old('user-city') == $city->id) selected @endif>{{ $city->ar_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">برجاء تحديد الدولة اولا</option>
                                        @endif

                                    </select>
                                    
                                    @if($errors->has("user-city"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-city") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group city -->

                                <div class="form-group">
                                    <label for="user-sax">الجنس</label>
                                    <select class="custom-select text-gray font-body-md" name="user-gender" id="user-sax" required>
                                        <option value="">يرجى تحديد الجنس</option>
                                        <option value="1" @if(old('user-gender') == 1) selected @endif>ذكر</option>
                                        <option value="2" @if(old('user-gender') == 2) selected @endif>أنثى</option>
                                    </select>
                                    
                                    @if($errors->has("user-gender"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-gender") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group service provider -->



                                <div class="form-group">
                                    <label for="phone-number">تاريخ الميلاد</label>
                                    <input type="date" class="form-control border-gray font-body-md" value="{{ old('user-age') }}" id="user-age" name="user-age" required>
                                    @if($errors->has("user-age"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-age") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group phone -->

                                <div class="form-group">
                                    <label for="phone-number">رقم الهاتف</label>
                                    <input type="tel" class="form-control border-gray font-body-md" value="{{ old('user-phone') }}" name="user-phone" id="user-phone-number" placeholder="966-553-6556556+" required>
                                    
                                    @if($errors->has("user-phone"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-phone") }}
                                        </div>
                                    @endif
                                    
                                </div><!-- .form-group phone -->

                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني</label>
                                    <input type="email"
                                           class="form-control border-gray font-body-md"
                                           id="user-email" required
                                           value="{{ old('user-email') }}"
                                           name="user-email">
                                    
                                    @if($errors->has("user-email"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-email") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group email -->

                                <div class="form-group">
                                    <label for="password">كلمة المرور</label>
                                    <input type="password"
                                           class="form-control border-gray font-body-md"
                                           minlength= 6
                                           id="user-password" required
                                           name="user-password">

                                    @if($errors->has("user-password"))
                                        <div class="alert alert-danger top-margin">
                                            {{ $errors->first("user-password") }}
                                        </div>
                                    @endif
                                </div><!-- .form-group password -->


                                <div class="form-group">
                                    <div class="custom-control custom-checkbox pl-0 pr-4 text-gray">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               name="usage"
                                               id="customCheck6" required>
                                        <label class="custom-control-label font-body-md"
                                               for="customCheck6">
                                            أنت توافق على <a href="{{ url("/page/1") }}" class="no-decoration text-primary">اتفاقية الإستخدام</a>
                                        </label>
                                        @if($errors->has("usage"))
                                            <div class="alert alert-danger top-margin">
                                                {{ $errors->first("usage") }}
                                            </div>
                                        @endif
                                    </div><!-- .custom-control -->
                                </div><!-- .form-group agreement -->

                                <button type="submit" class="btn btn-primary py-2 px-5">التسجيل</button>
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
    
   </script>
@stop