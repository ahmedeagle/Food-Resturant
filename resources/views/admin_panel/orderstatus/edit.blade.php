@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">حالات الحجز</h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ url('admin/orderstatus') }}">حالات الطلب</a>
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
                <h5>تعديل النوع</h5>
            </div>
            <div class="card-block">
                <form action="{{ url("/admin/orderstatus/update/" . $type->id) }}" method="POST">
                    {{ csrf_field()}}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الحالة باللغة العربية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ar_name" value="{{ old("ar_name" , $type->ar_name) }}" placeholder="اسم الحالة باللغة العربية">
                            @if($errors->has("ar_name"))
                                {{ $errors->first("ar_name") }}
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الحالة باللغة الانجليزية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="en_name" value="{{ old("en_name" , $type->en_name) }}" placeholder="اسم الحالة باللغة الانجليزية">
                            @if($errors->has("en_name"))
                                {{ $errors->first("en_name") }}
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="{{ url('admin/orderstatus') }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
                </form>
            </div>
        </div>
@endsection
