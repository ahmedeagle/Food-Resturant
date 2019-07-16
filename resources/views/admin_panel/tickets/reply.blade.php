@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url('admin_panel/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/tickets/' . $type) }}"><?=$title?></a>
         </li>
         <li class="breadcrumb-item"><a>عرض التذكرة</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    @if(Session::has('error'))
        <div class="alert alert-danger"> {{ Session::get('error') }}</div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success"> {{ Session::get('success') }}</div>
    @endif
   <div class="row">
      <div class="col-md-12">
         <div class="">
            <div class="row timeline-right p-t-35">
               <div class="col-12 col-sm-10 col-xl-11 p-l-5 p-b-35">
                  <div class="card">
                     <div class="card-block post-timelines">
                        <!-- <span class="dropdown-toggle addon-btn text-muted f-left service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                        <div class="dropdown-menu dropdown-menu-left b-none services-list">
                           <a class="dropdown-item" href="#">حذف التذكرة</a>
                           <a class="dropdown-item" href="#">رجوع</a>
                        </div> -->
                        <div class="chat-header f-w-600">{{ $username }}</div>
                        <div class="social-time text-muted">{{ $ticket->created_at }}</div>
                     </div>
                     <div class="card-block">
                        <div class="timeline-details">
                           <div class="chat-header">{{ $ticket->type_name }}</div>
                           <p class="text-muted">{{ $ticket->title }}</p>
                        </div>
                     </div>
                     <div class="card-block b-b-theme b-t-theme social-msg">
                        <a> <i class="icofont icofont-comment text-muted"></i> <span class="b-r-muted">الردود {{ count($ticket_replys) }}</span></a>
                     </div>
                     <div class="card-block user-box">
                        <div class="p-b-30"><span class="f-right">عرض جميع الردود</span></div>
                     @foreach ($ticket_replys as $reply)
                        <div class="media m-b-20">
                           <div class="media-body b-b-muted social-client-description" style="padding-right: 20px;">
                              <div class="chat-header">
                                  {{ ($reply->FromUser == "1") ? $username : 'ادارة الموقع' }}
                                  <span class="text-muted" style="padding-right: 5px;">{{ $reply->created_at }}</span>
                              </div>
                              <p class="text-muted">{{ $reply->reply }}</p>
                           </div>
                        </div>
                     @endforeach
                        <div class="media">
                           <div class="media-body" style="padding-right: 20px;">
                              <form action="{{ url("/admin/tickets/reply") }}" method="POST" >
                                  {{ csrf_field() }}
                                 <div class="">
                                    <input type="text" class="form-control" name="content" placeholder="اضافة رد"/>
                                     <input type="hidden" name="ticket_id" value="{{ $ticket->id }}" />
                                    <div class="text-right m-t-20"> <button style="width: 63px" type="submit" class="btn btn-md btn-success">رد</button>  <a href="{{ url('admin/tickets/' . $type) }}" class="btn btn-md btn-danger">رجوع</a></div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

