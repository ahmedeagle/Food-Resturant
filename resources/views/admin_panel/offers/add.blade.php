@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">{{ $title }}</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/offers/list/all') }}">العروض</a>
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
            <h5>اضافة عرض جديد </h5>
         </div>
         <div class="card-block">
            <form action="{{ url('admin/offers/store') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان العرض بالعربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_title" value="{{ old("ar_title") }}" placeholder="من فضلك ادخل عنوان العرض بالعربية">
                     @if($errors->has("ar_title"))
                        {{ $errors->first("ar_title") }}
                     @endif
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان العرض بالانجليزية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="en_title" value="{{ old("en_title") }}" placeholder="من فضلك ادخل عنوان العرض بالانجليزية">
                     @if($errors->has("en_title"))
                        {{ $errors->first("en_title") }}
                     @endif
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">حالة العرض</label>
                    <div class="col-sm-10">
                        <select style="height: 40px;" name="approved" class="form-control">
                            <option value="">من فضلك قم باختيار حالة العرض</option>
                            <option value="1" @if(old('approved') != '') @if(old('approved') == 1) selected @endif @endif>مفعل</option>
                            <option value="0" @if(old('approved') != '') @if(old('approved') == 0) selected @endif @endif>غير مفعل</option>
                        </select>
                        @if($errors->has("approved"))
                            {{ $errors->first("approved") }}
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">المطعم</label>
                    <div class="col-sm-10">
                        <select style="height: 40px;" name="provider_id" class="form-control">
                            <option value="">من فضلك قم باختيار المطعم</option>
                            @foreach ($providers as $p)
                                <option value="{{ $p->id }}" @if(old('provider_id') == $p->id) selected @endif>{{ $p->ar_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has("provider_id"))
                            {{ $errors->first("provider_id") }}
                        @endif
                    </div>
                </div>
               
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">صورة العرض</label>
                  <div class="col-sm-10">
                      <input type="file" name="image" value="{{ old("image") }}" class="form-control">
                     @if($errors->has("image"))
                        {{ $errors->first("image") }}
                     @endif
                  </div>
              </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="{{ url('admin/offers/list/all') }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
@endsection