@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">{{ $title }}</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/orders') }}" style="line-height: 2.5">{{ $title }}</a>
         </li>
      </ul>
   </div>
</div>
<div class="page-body">
   <div class="row">
      <div class="col-sm-12">
         <!-- Product list card start -->
         <div class="card">
            <div class="card-header">
               <h5>{{ $title }}</h5>
            </div>
            <div class="card-block">
               <div class="table-responsive">
                  <div class="table-content">
                     <div class="project-table">
                        <table id="order-table" class="table table-striped table-bordered nowrap">
                           <thead>
                              <tr>
                                 <th>رقم الطلب</th>
                                 <th>صاحب الطلب</th>
                                 <th>رقم الهاتف</th>
                                 <th>الايميل</th>
                                 <th>اسم المطعم</th>
                                 <th>الاجمالي</th>
                                 <th>تاريخ  الطلب</th>
                                 <th>العمليات</th>
                              </tr>
                           </thead>
                           <tbody>
                            @foreach ($orders as $order)
                              <tr>
                                 <td>
                                   {{ $order->id }}
                                 </td>
                                 <td>
                                    <h6>{{ $order->username }}</h6>
                                 </td>
                                 <td>
                                    <h6>{{ $order->user_phone }}</h6>
                                 </td>
                                 <td>
                                    <h6>{{ $order->user_email }}</h6>
                                 </td>
                                 <td>
                                    <h6>{{ $order->provider_name }}</h6>
                                 </td>
                                 <td>{{ $order->total_price }} ريال</td>
                                 <td>{{ $order->created_at }}</td>
                                 <td class="action-icon">
                                    <a href="{{ url('admin/orders/view/'.$order->id) }}" class="btn btn-success ">عرض الفاتورة</a>  <a href="{{ url('admin/orders/details/'.$order->id) }}" class="btn btn-warning ">تفاصيل الطلب</a>
                                 </td>
                              </tr>
                            @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Product list card end -->
      </div>
   </div>
</div>
@endsection