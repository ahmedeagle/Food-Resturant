@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">العروض</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ ('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">الصلاحيات </a>
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
            <h5>تعديل  صلاحية </h5>
         </div>
         <div class="card-block">
            <form action="{{ route('admin.roles.update',$role->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم الصلاحية </label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="name" value="{{  $role->name }}" placeholder="ادخل عنوان الصلاحية ">
                      @if($errors->has("name"))
                          {{ $errors->first("name") }}
                      @endif
                  </div>
               </div>
                
 
 
                  <div class="row">
                        <div class="form-group col-sm-12">
                            <label>القدرات*</label>
                             
                        </div>
                    </div>
                    <div class="row">
                        @foreach (config('global.permissions') as $name => $value)
                            <div class="form-group col-sm-4">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="chk-box" {{ in_array($name, $role->permissions)? 'checked' : '' }} name="permissions[]" value="{{ $name }}">  {{ $value }}
                                </label>
                            </div>
                        @endforeach
                    </div>

              
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>     
            </form>
         </div>
</div>
@endsection