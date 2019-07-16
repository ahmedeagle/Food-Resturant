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
         <li class="breadcrumb-item"><a href="{{ url('admin/comments/list') }}" style="line-height: 2.5">{{ $title }}</a>
         </li>
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
                     <th>التعليق</th>
                     <th>المطعم</th>
                     <th>المستخدم</th>
                     <th>تاريخ التعليق</th>
                     <th>حالة التعليق</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($comments as $key => $comment)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->provider_name }}</td>
                        <td>{{ $comment->user_name }}</td>
                        <td>{{ $comment->created_at }}</td>
                        <td>{{ ($comment->stopped == "1") ? 'غير مفعل' : 'مفعل' }}</td>
                        <td>

                            @if($comment->stopped == "0")

                                <a href="{{ url("/admin/branches/comments/stop/" . $comment->id) }}" class="btn btn-danger">إيقاف</a>

                            @else

                                <a href="{{ url("/admin/branches/comments/play/" . $comment->id) }}" class="btn btn-success">
                                    تفعيل
                                </a>

                            @endif
                        </td>
                    </tr>
                  @endforeach

            </table>
         </div>
      </div>
   </div>
</div>



@endsection