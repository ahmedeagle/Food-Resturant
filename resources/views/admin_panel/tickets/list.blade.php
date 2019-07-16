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
         <li class="breadcrumb-item"><a href="{{ url('admin/tickets/' . $type) }}" style="line-height: 2.5"><?=$title?></a>
         </li>
         <!-- <a style="float: left; color: white" href="{{ url('admin/tickets/add') }}" class="btn btn-grd-primary">اضافة دولة جديده</a> -->
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
         <h5><?=$title?></h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>  
                     <th>نوع التذكرة</th>
                     <th>محتوى التذكرة</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($tickets as $key => $ticket)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $ticket->type_name }}</td>
                        <td>{{ str_limit($ticket->title, $limit = 30, $end = "....") }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td><a href="{{ url('admin/tickets/reply/'.$ticket->id) }}" class="btn btn-success ">رد</a></td>
                    </tr>
                @endforeach
            </table>
         </div>
      </div>
   </div>
</div>
@endsection