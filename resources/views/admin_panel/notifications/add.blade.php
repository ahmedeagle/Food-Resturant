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
         <li class="breadcrumb-item"><a href="{{ url('admin/notifications/list/' . $type) }}">الاشعارات</a>
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
            <h5>اضافة اشعار جديد </h5>
         </div>
         <div class="card-block">
            <form id="notificatins-form" base_url = {{ url("/") }} action="{{ url('admin/notifications/store') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               <input type="hidden" id="rec_type" name="type" value="{{ $type }}" />
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان الاشعار</label>
                  <div class="col-sm-10">
                     <input type="text" class="title form-control" name="title" value="{{ old("title") }}" placeholder="من فضلك ادخل عنوان الاشعار">
                     <span style="display: none" class="title-error"></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">محتوى الاشعار</label>
                  <div class="col-sm-10">
                      <input type="text" class="content form-control" name="content"  value="{{ old('content') }}" placeholder="من فضلك ادخل محتوى الاشعار">
                      <span style="display: none" class="content-error"></span>
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">نوع الارسال</label>
                    <div class="col-sm-10">
                        <select id="select-notify-type" name="notify-type" class="form-control">
                            <option value="0">برجاء اختيار نوع الارسال</option>
                            <option value="1">ارسال الى الكل</option>
                            <option value="2">تحديد الارسال</option>
                        </select>
                        <span style="display: none;" class="type-error"></span>
                    </div>
                </div>
                <div style="display: none" id="choose-users-container" class="form-group row">
                    <label class="col-sm-2 col-form-label">مستقبلى الاشعار</label>
                    <div class="col-sm-10">
                        <button type="button" data-toggle="modal" data-target="#default-Modal" class="btn btn-default"><i class="fa fa-plus-circle"></i> اختيار من القائمة</button>
                    </div>
                </div>
                <div style="display: none;" id="users-list" class="form-group row">
                    <label class="col-sm-2 col-form-label">تفاصيل الارسال</label>
                    <div class="noti-numbers col-sm-10">
                        <!-- list of users will append here -->
                        <p>لم يتم اختيار مستقبلى الاشعار</p>
                        <span style="display: none;" class="number-error"></span>
                    </div>
                </div>
                <button class="send-notify-btn btn btn-md btn-success"><i class="icofont icofont-check"></i>  ارسال </button>    <a href="{{ url('admin/notifications/list/' . $type) }}" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
      </div>
</div>


<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">اختيار مستقبلى الاشعار</h4>
            </div>
            <div class="modal-body">

                <input type="text" class="form-control" name="search" id="search" placeholder="بحث" />

                <div id="notification-container" style="overflow-y: auto;max-height: 371px;" class="user-box assign-user taskboard-right-users">
                    @foreach($receivers as $receiver)
                        <div id = "refre{{ $receiver->id }}" selectItem = "0" style="margin-bottom: 10px;" class="notification-cell list-cell media">
                            <input type="hidden" name="r_id[]" id="r_id" value="{{ $receiver->id }}" />
                            <div class="media-left media-middle photo-table">
                                <a>
                                    <img class="media-object img-radius" src="{{  ($receiver->user_image_url != "") ? $receiver->user_image_url : url("/storage/app/public/users/avatar.png") }}" alt="Generic placeholder image">
                                </a>
                            </div>
                            <div style="margin-right: 15px;" class="media-body">
                                <h6 id="notification_name">{{ $receiver->name }}</h6>
                                @if($type == "users")
                                    <p> عدد الطلبات : {{ $receiver->number_of_orders }}
                                @else
                                    <p> عدد الفروع : {{ $receiver->number_of_branches }}
                                @endif
                            </div>
                            <input name="check-user-btn" class="check-user-btn" style="margin-top: 20px;margin-left: 24px;" type="checkbox">
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="modal-footer">
                <button style="margin-left: 10px;" class="add-btn-list btn btn-success">اضافة الى القائمة</button>
                <button type="button" aria-label="Close" class="list-back btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="success-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div style="overflow-y: auto;max-height: 371px;" class="user-box assign-user taskboard-right-users">
                    تمت عملية الارسال بنجاح
                </div>

            </div>
            <div class="modal-footer">
                <button style="margin-left: 10px;" class="back-to-notification btn btn-success">عودة الى القائمة</button>
                <button type="button" aria-label="Close" class="clear-btn btn btn-primary waves-effect waves-light ">ارسال اشعار اخر</button>
            </div>
        </div>
    </div>
</div>


@endsection