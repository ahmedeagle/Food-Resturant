@extends('admin_panel.blank')
@section('title')
   - {{ $title  }} - {{$user -> name}}
@endsection

@section('content')

<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">العملاء</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?= url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?= url('admin_panel/customers/all')?>"> العملاء</a>
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
            <h5>        تعديل بيانات  العميل {{$user -> name}} </h5>
         </div>
         <div class="card-block">
                 <form action="{{url('admin/customers/update').'/'.$user -> id}}" method="POST" enctype="multipart/form-data">
                     <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">الملف الشخصي</h4>

                    </div><!-- .section-header -->

                     

                            {{ csrf_field() }}
                          
                            @if(Session::has("success"))

                                <div class="alert alert-success top-margin">
                                    {{ Session::get("success") }}
                                </div>

                            @endif

                            @if(Session::has("errors") )

                                <div class="alert alert-danger top-margin">
                                    {{ Session::get("errors") }}
                                </div>

                            @endif

                         <br>

                            <div class="form-group">
                                <label for="user-name">الإسم الكامل</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="name"
                                       name="name"
                                       value="{{ old("name", $user ->name) }}"
                                       placeholder="محمد عبد الله"
                                       required
                                >

                                @if($errors->has("name"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("name") }}
                                    </div>

                                @endif

                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="country">الدولة</label>
                                <select class="country-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="country" name="country" data-action="{{ url("/restaurant/cities") }}" required>
                                    <option value="">يرجى تحديد الدولة</option>

                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" @if( old("country") )  @if(old("country") == $country->id) selected @endif @else @if($country->id == $user ->country_id) selected @endif @endif>{{ $country->ar_name }}</option>
                                    @endforeach
                                </select>

                                @if($errors->has("country"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("country") }}
                                    </div>

                                @endif

                            </div><!-- .form-group country -->

                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <select class="city-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="city" name="city" required>


                                    @if(old("country") != null)
                                        @if(old("country") != "")
                                            <option value="">برجاء اختيار المدينة</option>
                                            @foreach(\App\Http\Controllers\User\HelperController::get_cities(old("country")) as $city)
                                                <option value="{{ $city->id }}" @if(old("city")) @if(old("city") == $city->id) selected @endif @else @if($city->id == $user ->city_id) selected @endif @endif>{{ $city->ar_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">برجاء تحديد الدولة اولا</option>
                                        @endif
                                    @elseif(old("country") != "")


                                    @else
                                        <option value="">برجاء اختيار المدينة</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" @if(old("city")) @if(old("city") == $city->id) selected @endif @else @if($city->id == $user -> city_id) selected @endif @endif>{{ $city->ar_name }}</option>
                                        @endforeach

                                    @endif

                                </select>

                                @if($errors->has("city"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("city") }}
                                    </div>

                                @endif

                            </div><!-- .form-group city -->


                            <div class="form-group">
                                <label for="user-sax">الجنس</label>
                                <select class="custom-select text-gray font-body-md" name="gender" id="user-sax" required>
                                    <option value="">يرجى تحديد الجنس</option>
                                    <option value="1"  @if(old('gender')) @if(old('gender') == '1') selected @endif  @else @if($user ->gender == 'male') selected @endif @endif>ذكر</option>
                                    <option value="2" @if(old('gender'))  @if(old('gender') == '2') selected @endif  @else @if($user -> gender == 'female') selected @endif @endif>أنثى</option>
                                </select>

                                @if($errors->has("gender"))
                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("gender") }}
                                    </div>
                                @endif

                            </div><!-- .form-group service provider -->


                            <div class="form-group">
                                <label for="user-sax">الحالة</label>
                                <select class="custom-select text-gray font-body-md" name="gender" id="user-sax" required>
                                    <option value="">يرجى تحديد  الحاله</option>
                                    <option value="0"  @if(old('blocked')) @if(old('blocked') == '0') selected @endif  @else @if($user ->blocked == '0') selected @endif @endif> مفعل </option>
                                    <option value="1" @if(old('blocked'))  @if(old('blocked') == '1') selected @endif  @else @if($user -> blocked == '1') selected @endif @endif> محظور </option>
                                </select>

                                @if($errors->has("blocked"))
                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("blocked") }}
                                    </div>
                                @endif

                            </div><!-- .form-group service provider -->

 

                            <div class="form-group">
                                <label for="phone-number">العمر</label>
                                <input type="date" class="form-control border-gray font-body-md" value="{{ old('date_of_birth', $user -> date_of_birth) }}" id="user-age" name="date_of_birth" required>
                                @if($errors->has("date_of_birth"))
                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("date_of_birth") }}
                                    </div>
                                @endif
                            </div><!-- .form-group phone -->


                            <div class="form-group">
                                <label for="phone-number">رقم الجوال</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="{{ old("phone", $user ->phone) }}"
                                       id="phone-number"
                                       name="phone"
                                       placeholder="966-553-6556556+"
                                       required
                                >

                                @if($errors->has("phone"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("phone") }}
                                    </div>

                                @endif   

                            </div><!-- .form-group phone -->

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="{{ old("email", $user->email) }}"
                                       id="email"
                                       name="email"
                                       placeholder="your@mail.com"
                                       required
                                >

                                @if($errors->has("email"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("email") }}
                                    </div>

                                @endif

                            </div><!-- .form-group email -->


                            <button type="submit" class="btn btn-primary py-2 px-5 mt-2">تغيير</button>
                            
                       </div>        

                        </form>
                        
                        <br><br>
                 <form action="{{ url('/admin/customers/change-password/'.$user  -> id) }}" id="change-password-form" method="POST">
                            
                              <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">                            
                            {{ csrf_field() }}

                            <hr class="bg-gray my-4">


                            @if(Session::has("edit-password-success"))

                                <div class="alert alert-success top-margin">
                                    {{ Session::get("edit-password-success") }}
                                </div>

                            @endif

                            @if(Session::has("edit-password-error"))

                                <div class="alert alert-danger top-margin">
                                    {{ Session::get("edit-password-error") }}
                                </div>

                            @endif

                          

                            <div class="form-group">
                                <label for="new-password">كلمة المرور الجديدة</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="new-password"
                                       name="password"
                                       minlength="6"
                                       required
                                >
                                @if($errors->has("password"))

                                    <div class="alert alert-danger top-margin">
                                        {{ $errors->first("password") }}
                                    </div>

                                @endif
                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="confirm-password">تأكيد كلمة المرور</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="confirm-password"
                                       name="password_confirmation"
                                       required
                                >
                            </div><!-- .form-group password -->

                            <button type="submit" class="btn btn-primary py-2 px-5">تغيير</button>

                 
              </div>
            </form>
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