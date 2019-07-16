@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الصفحات</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
            <li class="breadcrumb-item"><a href="{{ url('admin/pages') }}">الصفحات الفرعية</a>
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
            <h5>تعديل الصفحة الفرعية</h5>
         </div>
         <div class="card-block">
            <form action="{{ url('admin/pages/update/' . $page->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان الصفحة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_title" value="{{ old("ar_title" , $page->ar_title) }}" placeholder="من فضلك ادخل عنوان الصفحه بالعربية">
                      @if($errors->has("ar_title"))
                          {{ $errors->first("ar_title") }}
                      @endif
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">عنوان الصفحة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_title" value="{{ old("en_title" , $page->en_title) }}" placeholder="من فضلك ادخل عنوان الصفحه باللعة الانجليزية">
                        @if($errors->has("en_title"))
                            {{ $errors->first("en_title") }}
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">حالة الصفحة</label>
                    <div class="col-sm-10">
                        <select style="height: 40px;" name="active" class="form-control">
                            <option value="">من فضلك قم باختيار حالة الصفحة</option>
                            <option value="1" @if(old('active') != '' || $errors->has('active')) @if(old('active') != '' && old('active') == 1) selected @endif @else @if($page->active == 1) selected @endif @endif>مفعل</option>
                            <option value="0" @if(old('active') != '' || $errors->has('active')) @if(old('active') != '' && old('active') == 0) selected @endif @else @if($page->active == 0) selected @endif @endif>غير مفعل</option>
                        </select>
                        @if($errors->has("active"))
                            {{ $errors->first("active") }}
                        @endif
                    </div>
                </div>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">محتوى الصفحة باللغة العربية</label>
                  <div class="col-sm-10">
                     <textarea name="ar_content">
                        {{ old('ar_content' , $page->ar_content) }}
                     </textarea>
                      @if($errors->has("ar_content"))
                          {{ $errors->first("ar_content") }}
                      @endif
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">محتوى الصفحة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                     <textarea name="en_content">
                        {{ old('en_content' , $page->en_content) }}
                     </textarea>
                        @if($errors->has("en_content"))
                            {{ $errors->first("en_content") }}
                        @endif
                    </div>
                </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="{{ url('admin/pages') }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
@endsection
