@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section("content")
   <div class="page-header card">
      <div class="card-block">
         <h5 class="m-b-10">المستخدمين</h5>
         <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
               <a href="{{ url("/admin/dashboard") }}">الرئيسية</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ url("/admin/admins") }}">المستخدمين</a>
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
            <h5>تعديل المدير</h5>
         </div>
         <div class="card-block">
            <form action="{{ url("/admin/admins/update/" . $admin->id) }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الاسم</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="name" value="{{ old('name' , $admin->name) }}"
                            placeholder="الاسم">
                     @if($errors->has('name'))
                        {{ $errors->first('name') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="phone" value="{{ old("phone" , $admin->phone) }}"
                            placeholder="رقم الجوال">
                     @if($errors->has('phone'))
                        {{ $errors->first('phone') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكترونى</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="email" value="{{ old("email", $admin->email) }}"
                            placeholder="البريد الالكترونى">
                     @if($errors->has('email'))
                        {{ $errors->first('email') }}
                     @endif
                  </div>
               </div>
               
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">كلمة المرور  </label>
                  <div class="col-sm-10">
                     <input type="password" class="form-control" name="password"
                            placeholder="كلمه المرور  ">
                     @if($errors->has('password'))
                        {{ $errors->first('password') }}
                     @endif
                  </div>
               </div>
               
               
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">تاكيد كلمه المرور  </label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="password_confirmation"
                            placeholder="تاكيد كلمه المرور ">
                     @if($errors->has('password_confirmation'))
                        {{ $errors->first('password_confirmation') }}
                     @endif
                  </div>
               </div>
               


                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label">الصلاحيات</label>
                     <div class="col-sm-10">
                        @if($admin->id != 1)
                        <fieldset class="group">
                           <ul class="checkbox">
                              <li><input type="checkbox" name="all" id="all" /><label for="cb1">كل الصلاحيات</label></li><br /><hr />
                              <li><input type="checkbox" name="credit" @if($permissions->credit == "1") checked @endif /><label for="cb1">الرصيد</label></li>
                              <li><input type="checkbox" name="profile" @if($permissions->profile == "1") checked @endif /><label for="cb2">تعديل الملف الشخصى</label></li>
                              <li><input type="checkbox" name="settings" @if($permissions->settings == "1") checked @endif /><label for="cb3">الاعدادات</label></li>
                              <li><input type="checkbox" name="dashboard" @if($permissions->dashboard == "1") checked @endif /><label for="cb3">الاحصائيات</label></li>
                              <li><input type="checkbox" name="countries" @if($permissions->countries == "1") checked @endif /><label for="cb3">الدول</label></li>
                              <li><input type="checkbox" name="cities" @if($permissions->cities == "1") checked @endif /><label for="cb3">المدن</label></li>
                              <li><input type="checkbox" name="pages" @if($permissions->pages == "1") checked @endif /><label for="cb3">الصفحات</label></li>
                              <li><input type="checkbox" name="categories" @if($permissions->categories == "1") checked @endif /><label for="cb3">التصنيفات</label></li>
                              <li><input type="checkbox" name="ticket_types" @if($permissions->ticket_types == "1") checked @endif /><label for="cb3">انواع التذاكر</label></li>
                              <li><input type="checkbox" name="order_status" @if($permissions->order_status == "1") checked @endif /><label for="cb3">حالات الطلب</label></li>
                              <li><input type="checkbox" name="booking_status" @if($permissions->booking_status == "1") checked @endif /><label for="cb3">حالات الحجز</label></li>
                              <li><input type="checkbox" name="crowd" @if($permissions->crowd == "1") checked @endif /><label for="cb3">حالات الازدحام</label></li>
                              <li><input type="checkbox" name="meals" @if($permissions->meals == "1") checked @endif /><label for="cb3">الوجبات</label></li>
                              <li><input type="checkbox" name="offers" @if($permissions->offers == "1") checked @endif /><label for="cb3">العروض</label></li>
                              <li><input type="checkbox" name="orders" @if($permissions->orders == "1") checked @endif /><label for="cb3">الطلبات</label></li>
                              <li><input type="checkbox" name="reservations" @if($permissions->reservations == "1") checked @endif /><label for="cb3">الحجوزات</label></li>
                              <li><input type="checkbox" name="tickets" @if($permissions->tickets == "1") checked @endif /><label for="cb3">التذاكر</label></li>
                              <li><input type="checkbox" name="notifications" @if($permissions->notifications == "1") checked @endif /><label for="cb3">الاشعارات</label></li>
                              <li><input type="checkbox" name="comments" @if($permissions->comments == "1") checked @endif /><label for="cb3">التعليقات</label></li>
                              <li><input type="checkbox" name="providers" @if($permissions->providers == "1") checked @endif /><label for="cb3">المطاعم</label></li>
                              <li><input type="checkbox" name="users" @if($permissions->users == "1") checked @endif /><label for="cb3">المستخدمين</label></li>
                              <li><input type="checkbox" name="withdraws" @if($permissions->withdraws == "1") checked @endif /><label for="cb3">طلبات سحب الرصيد</label></li>
                              <li><input type="checkbox" name="admins" @if($permissions->admins == "1") checked @endif /><label for="cb3">التحكم بأعضاء لوحة التحكم</label></li>
                           </ul>
                        </fieldset>
                        @else
                           <p>كل الصلاحيات</p>
                        @endif
                     </div>
                  </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="{{ url("admin/admins") }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
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