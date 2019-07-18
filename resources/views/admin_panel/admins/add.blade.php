@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
   <!-- Page-header start -->
   <div class="page-header card">
      <div class="card-block">
         <h5 class="m-b-10">المستخدمين</h5>
         <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
               <a href="{{ url('/admin/dashboard') }}">الرئيسية</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/admins') }}">المستخدمين</a>
            </li>
            <li class="breadcrumb-item"><a>اضافة</a>
            </li>
         </ul>
      </div>
   </div>
   <!-- Page-header end -->
   <div class="page-body">
      <!-- Basic Form Inputs card start -->
      <div class="card">
         <div class="card-header">
            <h5>اضافة مستخدم جديدة </h5>
         </div>
         <div class="card-block">
            <form action="{{ url("/admin/admins/store") }}" method="POST" >
               {{ csrf_field() }}

               @if(Session::has('error'))
                  <div class="alert alert-danger">
                     {{ Session::get("error") }}
                  </div>
               @endif
               @if(Session::has('success'))
                  <div class="alert alert-success">
                     {{ Session::get("success") }}
                  </div>
               @endif

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الاسم</label>
                  <div class="col-sm-10">
                     <input type="text"
                            class="form-control"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="الاسم">
                     @if($errors->has('name'))
                        {{ $errors->first('name') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text"
                            class="form-control"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="رقم الجوال">
                     @if($errors->has('phone'))
                        {{ $errors->first('phone') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكترونى</label>
                  <div class="col-sm-10">
                     <input type="text"
                            class="form-control"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="البريد الالكترونى">
                     @if($errors->has('email'))
                        {{ $errors->first('email') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الرقم السرى</label>
                  <div class="col-sm-10">
                     <input type="password"
                            class="form-control"
                            name="password"
                            placeholder="الرقم السرى">
                     @if($errors->has('password'))
                        {{ $errors->first('password') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                <label class="col-sm-2 col-form-label"> الصلاحيات</label>
                   <div class="col-sm-10">
                                 <select class="city-ajax-request custom-select text-gray font-body-md border-gray form-control " id="city" name="role_id" required="">                                         
                                         <option value="" selected=""> اختر صلاحيه </option>
                                       @if(isset($roles) && $roles -> count() > 0)
                                        @foreach($roles as $role)
                                              <option value="{{$role -> id }}"> {{$role -> name }}</option>                                          
                                        @endforeach
                                       @endif       
                                  
                                </select>
                   </div>
               </div>
               <button type="submit" class="btn btn-md btn-success">
                <i class="icofont icofont-check"></i>  اضافة </button>    
            </form>
         </div>
      </div>
   </div>
@endsection
@section('style')
   <style>
      fieldset.group  {
      margin: 0;
      margin-bottom: 1.25em;
      padding: .125em;
      }

      fieldset.group legend {
      margin: 0;
      padding: 0;
      font-weight: bold;
      margin-left: 20px;
      font-size: 100%;
      color: black;
      }


      ul.checkbox  {
      padding: 0;
      margin-right: 20px;
      list-style: none;
      }

      ul.checkbox li input {
      margin-right: .25em;
      }

      ul.checkbox li {
      float: right;
      min-width: 200px;
      }

      ul.checkbox li label {
      margin-right: 10px;
      }

   </style>
@endsection
@section('script')
   <script>
      var all = 0;
      $("#all").on("click", function () {
          if(all == 0){
              $( 'input[type="checkbox"]').prop("checked", true);
              all = 1;
          }else{
              $( 'input[type="checkbox"]' ).prop("checked", false);
              all = 0;
          }

      });
   </script>
@endsection