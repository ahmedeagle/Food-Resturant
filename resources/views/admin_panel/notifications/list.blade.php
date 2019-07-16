@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
<style>
    .offer_ar_more , .offer_en_more{
        color: #3886de;
        text-decoration: underline;
    }
</style>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">{{ $title }}</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/notifications/list/' . $type) }}" style="line-height: 2.5">{{ $title }}</a>
         </li>
         <a style="float: left; color: white" href="{{ url('/admin/notifications/add/' . $type) }}" class="btn btn-grd-primary">ارسال اشعار جديد</a>
      </ul>
   </div>
</div>
<div class="page-body">
    @if(Session::has('error'))
        <div class="alert alert-danger"> {{ Session::get('error') }}</div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success"> {{ Session::get('success') }}</div>
    @endif
   <div class="card">
      <div class="card-header">
         <h5>{{ $title }}</h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                      <th>مسلسل</th>
                     <th>عنوان الاشعار</th>
                     <th>محتوى الاشعار</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($notifications as $key => $n)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $n->title }}</td>
                        <td>{{ $n->content }}</td>
                        <td>{{ $n->created_at }}</td>
                        <td>
                            <button value="{{ $n->notification_id }}" type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#default-Modal{{ $n->notification_id }}">عرض مستقبلى الاشعار</button>
                            <button value="{{ $n->notification_id }}" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="default-Modal{{ $n->notification_id }}" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">عرض مستقبلى الاشعار</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control search-notification" id="search-notification-2"  placeholder="بحث" />
                                    <div class="notification-container-2 user-box assign-user taskboard-right-users">
                                        @foreach($n->users as $user)
                                            <div class="media notification-cell-2">
                                                <div class="media-left media-middle photo-table">
                                                    <a>
                                                        <img class="media-object img-radius" src="{{  ($user->user_image_url != "") ? $user->user_image_url : url("/storage/app/public/users/avatar.png") }}" alt="Generic placeholder image">
                                                    </a>
                                                </div>
                                                <div style="margin-right: 15px;" class="media-body">
                                                    <h6 id="notification_name">{{ $user->user_name }}</h6>
                                                    <p> عدد الطلبات : {{ $user->number_of_orders }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                                </div>
                            </div>
                        </div>
                    </div>
                  @endforeach

            </table>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">حذف الاشعار</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذا الاشعار؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "{{ url('admin/notifications/delete') }}" + "/" + val ;

        }
</script>
@endsection