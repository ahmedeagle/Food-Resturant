@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">مميزات المطاعم  </h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ ('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/advantages') }}">مميزات المطاعم  </a>
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
            <h5>تعديل ميزة</h5>
         </div>
         <div class="card-block">
            <form action="{{ url("admin/advantages/update/" . $option->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان الميزة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_name" value="{{ old("ar_name" ,  $option ->ar_name) }}" placeholder="من فضلك ادخل عنوان الميزة باللغة العربية">
                      @if($errors->has("ar_name"))
                          {{ $errors->first("ar_name") }}
                      @endif
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">عنوان الميزة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_name" value="{{ old("en_name" ,  $option->en_name) }}" placeholder="من فضلك ادخل عنوان الميزة باللغة الانجليزية">
                        @if($errors->has("en_name"))
                            {{ $errors->first("en_name") }}
                        @endif
                    </div>
                </div>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">صورة الميزة</label>
                  <div class="col-sm-10">
                    <img style="width: 282px;height: 200px;" src="{{  $option -> option_image_url}}" />
                  </div>
              </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">تعديل الصورة</label>
                    <div class="col-sm-10">
                        <input type="file" name="image" value="{{ $option -> option_image_url}}" class="form-control">
                        @if($errors->has("image"))
                            {{ $errors->first("image") }}
                    @endif
                </div>
         </div>
                <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="{{ url('admin/advantages') }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
@endsection