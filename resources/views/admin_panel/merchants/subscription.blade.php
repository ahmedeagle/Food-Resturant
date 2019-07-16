@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10"><?=$title?></h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item" style="line-height: 2.5">
                    <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
                </li>
                <li class="breadcrumb-item" style="line-height: 2.5">
                    <a href="{{ url('admin/providers/all') }}">المطاعم</a>
                </li>
                <li class="breadcrumb-item"><a style="line-height: 2.5"><?=$title?></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="page-body">
        <!-- Basic Form Inputs card start -->
        <div class="card">
            <div class="card-header">
                <h5>تعديل الاشتراكات الشهرية</h5>
            </div>
            <div class="card-block">
                <form action="{{ url('admin/providers/change-subscription') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="id" value="{{ $provider->id }}" />
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">الاشتراك</label>
                        <div class="col-sm-10">
                            <select style="height: 40px;" name="sub" class="form-control">
                                <option value="">من فضلك قم باختيار الاشتراك</option>
                                <option value="1" @if(old('sub') != '') @if(old('sub') == 1) selected @endif @else @if($provider->has_subscriptions == 1 ) selected @endif @endif>يوجد اشتراك</option>
                                <option value="0" @if(old('sub') != '') @if(old('sub') == 0) selected @endif @else @if($provider->has_subscriptions == 0 ) selected @endif @endif>لا يوجد اشتراك</option>
                            </select>
                            @if($errors->has("sub"))
                                {{ $errors->first("sub") }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">مدة الاشتراك</label>
                        <div class="col-sm-10">
                            <select style="height: 40px;" name="period" class="form-control">
                                <option value="">من فضلك قم باختيار الاشتراك</option>
                                <option value="1" @if(old('period') != '') @if(old('period') == 1) selected @endif @else @if($provider->subscriptions_period == 1) selected @endif @endif>شهرى</option>
                                <option value="2" @if(old('period') != '') @if(old('period') == 2) selected @endif @else @if($provider->subscriptions_period == 2) selected @endif @endif>سنوى</option>
                            </select>
                            @if($errors->has("period"))
                                {{ $errors->first("period") }}
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">قيمة الاشتراك</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="amount" value="{{ old("amount", $provider->subscriptions_amount) }}" placeholder="قيمة الاشتراك">
                            @if($errors->has("amount"))
                                {{ $errors->first("amount") }}
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>تعديل</button>    <a href="{{ url('admin/providers/all') }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
                </form>
            </div>
        </div>
@endsection