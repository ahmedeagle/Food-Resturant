@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الاعدادات</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/settings') }}">الاعدادات</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    @if(Session::has('error'))
        <div class="alert alert-danger"> {{ Session::get('error') }}</div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success"> {{ Session::get('success') }}</div>
    @endif
      <div class="card">
         <div class="card-header">
            <h5>الاعدادات</h5>
         </div>
         <div class="card-block">
            <form action="{{ url("admin/settings/store") }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم التطبيق بالعربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="app_ar_name" value="{{ old("app_ar_name" , $settings->app_ar_name) }}" placeholder="من فضلك ادخل اسم التطبيق بالعربية">
                      @if($errors->has("app_ar_name"))
                          {{ $errors->first("app_ar_name") }}
                      @endif
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">اسم التطبيق بالانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="app_en_name" value="{{ old("app_en_name" , $settings->app_en_name) }}" placeholder="من فضلك ادخل اسم التطبيق بالانجليزية">
                        @if($errors->has("app_en_name"))
                            {{ $errors->first("app_en_name") }}
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="phone" value="{{ old('phone' , $settings->phone) }}" placeholder="من فضلك ادخل رقم الجوال">
                      @if($errors->has("phone"))
                          {{ $errors->first("phone") }}
                      @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكتروني</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="email" value="{{ old("email" , $settings->email) }}" placeholder="من فضلك ادخل البريد الالكتروني">
                      @if($errors->has("email"))
                          {{ $errors->first("email") }}
                      @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">نسبة الضريبة</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="tax" value="{{ old('tax' , $settings->order_tax) }}" placeholder="من فضلك ادخل الضريبة ">
                      @if($errors->has("tax"))
                          {{ $errors->first("tax") }}
                      @endif
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">العنوان باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_address" value="{{ old("ar_address" , $settings->ar_address) }}" placeholder="من فضلك ادخل العنوان بالعربية">
                      @if($errors->has("ar_address"))
                          {{ $errors->first("ar_address") }}
                      @endif
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">العنوان باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_address" value="{{ old("en_address" , $settings->en_address) }}" placeholder="من فضلك ادخل العنوان بالانجليزية">
                        @if($errors->has("en_address"))
                            {{ $errors->first("en_address") }}
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">رابط تطبيق الاندرويد</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="android" value="{{ old("android" , $settings->android_app_url) }}" placeholder="من فضلك ادخل العنوان">
                        @if($errors->has("android"))
                            {{ $errors->first("android") }}
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">رابط تطبيق الايفون</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ios" value="{{ old("ios" , $settings->ios_app_url) }}" placeholder="من فضلك ادخل العنوان">
                        @if($errors->has("ios"))
                            {{ $errors->first("ios") }}
                        @endif
                    </div>
                </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>      <a href="{{ url('admin/dashboard') }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
@endsection