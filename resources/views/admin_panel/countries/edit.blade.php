@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section("content")
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الدول</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url("/admin/dashboard") }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url("/admin/countries") }}">الدول</a>
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
            <h5>تعديل الدولة</h5>
         </div>
         <div class="card-block">
            <form action="{{ url("/admin/countries/update/" . $country->id) }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم الدولة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_name" value="{{ old('ar_name' , $country->ar_name) }}" placeholder="اسم الدولة باللغة العربية">
                     @if($errors->has('ar_name'))
                        {{ $errors->first('ar_name') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم الدولة باللغة الانجليزية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="en_name" value="{{ old("en_name" , $country->en_name) }}" placeholder="اسم الدولة باللغة الانجليزية">
                     @if($errors->has('en_name'))
                        {{ $errors->first('ar_name') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الدولة</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="code" value="{{ old("code", $country->country_code) }}" placeholder="رقم الدولة">
                     @if($errors->has('code'))
                        {{ $errors->first('code') }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الحالة</label>
                  <div class="col-sm-10">
                     <select style="height: 40px;" name="active" class="form-control">
                        <option value="">من فضلك قم باختيار الحالة</option>

                        <option value="1"  @if(old('active') || $errors->has('active')) @if(old('active') == '1') selected @endif @else @if($country->active == '1') selected @endif @endif>مفعل</option>
                        <option value="0"  @if(old('active') || $errors->has('active')) @if(old('active') == '0') selected @endif @else @if($country->active == '0') selected @endif @endif>غير مفعل</option>

                     </select>
                     @if($errors->has("active"))
                        {{ $errors->first("active") }}
                     @endif
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="{{ url("admin/countries") }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
@endsection