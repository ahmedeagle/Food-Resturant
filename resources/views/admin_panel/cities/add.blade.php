@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">المدن</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url("/admin/dashboard") }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url("/admin/cities") }}">المدن</a>
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
            <h5>اضافة مدينة جديدة </h5>
         </div>
         <div class="card-block">
            <form action="{{ url("/admin/cities/store") }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم المدينة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_name" value="{{ old("ar_name") }}" placeholder="اسم المدينة باللغة العربية">
                     @if($errors->has("ar_name"))
                        {{ $errors->first("ar_name") }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم المدينة باللغة الانجليزية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="en_name" value="{{ old("en_name") }}" placeholder="اسم المدينة باللغة الانجليزية">
                     @if($errors->has("en_name"))
                        {{ $errors->first("en_name") }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الدوله</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="country_id" class="form-control">
                         <option value="">من فضلك قم باختيار الدولة</option>
                        @foreach ($countries as $country)
                          <option value="{{ $country->id }}" @if(old('country_id') == $country->id) selected @endif>{{ $country->ar_name }}</option>
                        @endforeach
                      </select>
                     @if($errors->has("country_id"))
                        {{ $errors->first("country_id") }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الحالة</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="active" class="form-control">
                         <option value="">من فضلك قم باختيار الحالة</option>
                         <option value="1" @if(old('active') == '1') selected @endif>مفعل</option>
                         <option value="0" @if(old('active') == '0') selected @endif>غير مفعل</option>

                      </select>
                     @if($errors->has("active"))
                        {{ $errors->first("active") }}
                     @endif
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="{{ url("/admin/cities") }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
@endsection