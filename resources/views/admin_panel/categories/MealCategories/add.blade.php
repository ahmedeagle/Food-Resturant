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
                <li class="breadcrumb-item"><a href="{{ url('admin/mealCategories') }}">تصنيفات قائمة الطعام</a>
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
                <h5>{{ $title }}</h5>
            </div>
            <div class="card-block">
                <form action="{{ url("/admin/mealCategories/store") }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">أختر المطعم لاضافه تصنيف لقائمه الطعام </label>
                        <div class="col-sm-10">
                            <select class="form-control" name="provider_id">
                                @if(!empty($providers))
                                    @foreach($providers as $id => $name)
                                        <option style="height: 48px;" value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($errors->has("provider_id"))
                                {{ $errors->first("provider_id") }}
                            @endif
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">عنوان التصنيف باللغة العربية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ar_name" value="{{ old("ar_name") }}"
                                   placeholder="من فضلك ادخل عنوان التصنيف بالعربية">
                            @if($errors->has("ar_name"))
                                {{ $errors->first("ar_name") }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">عنوان التصنيف باللغة الانجليزية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="en_name" value="{{ old("en_name") }}"
                                   placeholder="من فضلك ادخل عنوان التصنيف بالانجليزية">
                            @if($errors->has("en_name"))
                                {{ $errors->first("en_name") }}
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i> اضافة
                    </button>
                    <a href="{{ url('admin/mealCategories') }}" class="btn btn-md btn-danger"><i
                                class="icofont icofont-close"></i> رجوع </a>
                </form>
            </div>
        </div>
@endsection
