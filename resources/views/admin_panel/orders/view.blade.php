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
         <li class="breadcrumb-item"><a href="{{ url('admin/orders') }}">الطلبات</a>
         </li>
         <li class="breadcrumb-item"><a>{{ $title }}</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
   <!-- Container-fluid starts -->
   <div class="container">
      <!-- Main content starts -->
      <div>
         <!-- Invoice card start -->
         <div class="card">
            <div class="row invoice-contact">
               <div class="col-md-8">
                  <div class="row">
                     <div class="col-sm-12">
                        <table class="table invoice-table invoice-order table-borderless">
                           <tbody>
                              <tr>
                                 <td style="padding-right: 15px;"> اسم التطبيق:  {{ $settings->app_ar_name }}</td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"> العنوان:  {{ $settings->ar_address }}</td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"> البريد الالكترونى:  <a>{{ $settings->email }}</a>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="padding-right: 15px;"> رقم الجوال:  {{ $settings->phone }}</td>
                              </tr>
                              <!-- <tr>
                                 <td><a href="#" target="_blank">www.demo.com</a>
                                 </td>
                                 </tr> -->
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
               </div>
            </div>
            <div class="card-block">
               <div class="row invoive-info">
                  <div class="col-md-4 col-xs-12 invoice-client-info">
                     <h6>معلومات صاحب الطلب :</h6>
                     <h6 class="m-0"> الاسم: {{ $order->username }}</h6>
                     <p class="m-0 m-t-10"> النوع: {{ ($order->usergender == "male") ? 'ذكر' : 'انثى' }}</p>
                     <p class="m-0"> رقم الهاتف: {{ $order->userphone }}</p>
                     <!-- <p>البريد الالكتروني</p> -->
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <h6>بيانات الطلب :</h6>
                     <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                           <tr>
                              <th>التاريخ :</th>
                              <td>{{ $order->created_at }}</td>
                           </tr>
                           <tr>
                              <th>حالة الطلب :</th>
                              <td>
                                  <span class="label label-primary">{{ $order->status }}</span>
                              </td>
                           </tr>
                           <tr>
                              <th>رقم الطلب :</th>
                              <td>
                                #{{ $order->id }}
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <!-- <h6 class="m-b-20">رقم الفاتورة <span>#12398521473</span></h6> -->
                     <h6 class="text-uppercase text-primary">الاجمالي :
                        <span>{{ $order->total_price }} ريال</span>
                     </h6>
                  </div>
               </div>
            </div>
         </div>
         <!-- Invoice card end -->
         <div class="row text-center">
             <div class="col-sm-12 invoice-btn-group text-center">
                 <a href="{{ url('admin/orders/details/'.$order->id) }}" style="color: white" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light m-r-20">التفاصيل</a>
                 <a href="{{ url('admin/orders') }}" style="color: white" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light">رجوع </a>
             </div>
         </div>
      </div>
   </div>
   <!-- Container ends -->
</div>
@endsection