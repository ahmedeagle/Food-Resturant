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
            <a href="{{ url('admin_panel/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/withdraws') }}" style="line-height: 2.5"><?=$title?></a>
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
         <h5><?=$title?></h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>  
                     <th>اسم التاجر</th>
                     <th>الكمية المراد سحبها</th>
                     <th>تاريخ الانشاء</th>
                     <th>الحالة</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($requests as $key => $request)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $request->username }}</td>
                        <td>{{ $request->withdrawn_amount }} ريال</td>
                        <td>{{ $request->created_at }}</td>
                        <td>{{ ($request->is_finished == 0)?'بانتظار الموافقة':'تمت الموافقة عليه' }}</td>
                        <td>
                            @if($request->is_finished == 0)
                          <a href="{{ url('admin/withdraws/accept/'.$request->id) }}" class="btn btn-success ">موافقة</a>
                        @endif</td>
                    </tr>
                @endforeach
            </table>
         </div>
      </div>
   </div>
</div>
@endsection