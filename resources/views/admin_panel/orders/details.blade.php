@extends('admin_panel.blank')
@section('title')
   - {{ $title }}
@endsection
@section('content')
@section('content')<div class="page-header card">
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
            <div class="card-block" style="height: 200px;">
               <div class="row invoive-info">
                  <div class="col-md-4 col-xs-12 invoice-client-info">
                      <h6>معلومات المطعم  :</h6>


                      <table class="table table-responsive invoice-table invoice-order table-borderless">
                          <tbody>
                          <tr>
                              <th>اسم المطعم :</th>
                              <td>{{ $order->provider_name }}</td>
                          </tr>
                          <tr>
                              <th>نوع التوصيل :</th>
                              <td>
                                  {{ ($order->is_delivery == "1") ? 'توصيل من المطعم' : 'استلام من المطعم' }}
                              </td>
                          </tr>
                          <tr>
                              <th>رقم الجوال :</th>
                              <td>
                                  {{ $order->branch_phone }}
                              </td>
                          </tr>
                          <tr>
                              <th>البريد الالكترونى : </th>
                              <td>
                                  {{ $order->branch_email }}
                              </td>
                          </tr>
                          </tbody>
                      </table>

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
                              <th>حالة الدفع :</th>
                              <td>
                                 {{ $order->payment_name }}
                              </td>
                           </tr>
                           <tr>
                              <th>رقم الطلب :</th>
                              <td>
                                 {{ $order->order_id }}
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <h6 class="m-b-20">معلومات الرصيد</h6>
                     <h6 class="text-uppercase text-primary">الاجمالي :
                        <span>{{ $order->total_price }} ريال</span>
                     </h6>
                  </div>
               </div>
            </div>
         </div>
         <!-- Invoice card end -->
          <div class="row">
              <div class="col-sm-12">
                  <div class="table-responsive">
                      <table class="table  invoice-detail-table">
                          <thead>
                          <tr class="thead-default">
                              <th style="text-align: right">اسم الوجبة</th>
                              <th style="text-align: right">سعر الوجبة</th>
                              <th style="text-align: right">العدد</th>
                              <th style="text-align: right">الحجم</th>
                              <th style="text-align: right">
                                التفاصيل
                              </th>

                          </tr>
                          </thead>
                          <tbody>
                          @foreach ($meals as $meal)
                          <tr>
                              <td style="text-align: right">
                                  <h6>{{ $meal->ar_name }}</h6>
                              </td>
                              <td style="text-align: right">{{ $meal->meal_price }}</td>
                              <td style="text-align: right">{{ $meal->quantity }}</td>
                              <td style="text-align: right">{{ $meal->size_name }}</td>
                              <td style="text-align: right">
                                  <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#adds-Modal{{ $meal->id }}">الاضافات</button>
                                  <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#options-Modal{{ $meal->id }}">التفضيلات</button>
                              </td>

                          </tr>
                          <div class="modal fade" id="options-Modal{{ $meal->id }}" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title">تفضيلات الوجبة</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                                <ul>

                                              @foreach($meal->options as $option)
                                                  <li>
                                                      الاسم: {{ $option->name }}- السعر المضاف:   {{ $option->added_price }} ريال
                                                  </li>
                                                    <hr />
                                              @endforeach
                                                </ul>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="modal fade" id="adds-Modal{{ $meal->id }}" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title">اضافات الوجبة</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <ul>

                                              @foreach($meal->adds as $add)
                                                  <li>
                                                      الاسم: {{ $add->name }} - السعر المضاف: {{ $add->added_price }} ريال
                                                  </li>
                                                  <hr />
                                              @endforeach
                                          </ul>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-sm-12">
                  <table class="table table-responsive invoice-table invoice-total">
                      <tbody>
                      <tr>
                          <th>الاجمالي قبل الضريبة وسعر التوصيل : </th>
                          <td> {{ $order->total_price - ( $order->order_tax + $order->delivery_price) }} ريال </td>
                      </tr>
                      <tr>
                          <th>الضريبة :</th>
                          <td> {{ $order->order_tax }}  % </td>
                      </tr>
                      <tr>
                          <th>سعر التوصيل :</th>
                          <td> {{ $order->delivery_price }} ريال </td>
                      </tr>
                      <tr class="text-info">
                          <td>
                              <hr/>
                              <h5 class="text-success">الاجمالي :</h5>
                          </td>
                          <td>
                              <hr/>
                              <h5 class="text-success">{{ $order->total_price }} ريال</h5>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

   </div>
   <!-- Container ends -->
</div>
@endsection