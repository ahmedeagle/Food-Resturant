@extends('admin_panel.blank')
@section('title')
   - {{ $title  }}
@endsection

@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">عرض تفاصيل الموجبة</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/meals') }}">الوجبات</a>
         </li>
         <li class="breadcrumb-item"><a>عرض تفاصيل الوجبة</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
   <div class="row">
      <div class="col-md-12">
         <!-- Product detail page start -->
         <div class="card product-detail-page">
            <div class="card-block">
               <div class="row">
                  <div class="col-lg-5 col-xs-12" style="direction: ltr !important">
                     <div class="port_details_all_img row">
                        <div class="col-lg-12 m-b-15" style="direction: ltr !important">
                           <div id="big_banner">
                              @foreach ($meal_images as $img)
                              <div class="port_big_img">
                                 <img class="img img-fluid single-item-rtl" src="{{ url("storage/app/public/meals/" . $img->name) }}" alt="Big_ Details">
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <div class="col-lg-12 product-right" style="direction: ltr !important">
                           <div id="small_banner"  style="direction: ltr !important">
                              @foreach ($meal_images as $img)
                              <div style="direction: ltr !important">
                                 <img class="img img-fluid" src="{{ url("storage/app/public/meals/" . $img->name) }}" alt="small-details">
                              </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-7 col-xs-12 product-detail" id="product-detail">
                     <div class="row">
                        <div>
                           <div class="col-lg-12">
                              <span class="txt-muted d-inline-block">اسم الوجبة بالعربية: <a>{{ $meal->ar_name }}</a></span>
                           </div>
                           <div class="col-lg-12">
                              <h6 class="pro-desc">اسم المطعم: {{ $provider->ar_name }}</h6>
                           </div>
                           <div class="col-lg-12">
                              <span class="txt-muted">تصنيف الوجبة: {{ $meal->cat_name }} </span>
                           </div>

                           <div class="col-lg-12">
                              سعر الوجبة: <span style="margin-right: 0px !important" class="text-primary product-price"><i class="icofont icofont-cur-riyal "></i> {{ $meal->price }}</span>
                              <hr>
                               السعرات الحرارية:<span style="margin-right: 0px !important" class="text-primary product-price"> {{ $meal->calories }}</span>
                              <hr>
                              وصف الوجبة:
                              <p>{!! $meal->ar_description !!}</p>
                              <hr>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Product detail page end -->
      </div>
   </div>
   <!-- Nav tabs start-->
   <div class="tab-header card">
      <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
         <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">عرض معلومات المطعم</a>
            <div class="slide"></div>
         </li>
         <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#review" role="tab">احجام الوجبة</a>
            <div class="slide"></div>
         </li>
         <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#rate" role="tab">اضافات الوجبة</a>
            <div class="slide"></div>
         </li>

          <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#options" role="tab">تفضيلات الوجبة</a>
              <div class="slide"></div>
          </li>
      </ul>
   </div>
   <!-- Nav tabs start-->
   <!-- Nav tabs card start-->
   <div class="tab-content">
      <!-- tab panel personal start -->
      <div class="tab-pane active" id="personal" role="tabpanel">
         <!-- personal card start -->
         <div class="card">
            <div class="card-block">
               <div class="view-info">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="general-info">
                           <div class="row">
                              <div class="col-lg-12 col-xl-6">
                                 <div class="table-responsive">
                                    <table class="table m-0">
                                       <tbody>
                                          <tr>
                                             <th scope="row">الاسم</th>
                                             <td>{{ $provider->ar_name }}</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">الدولة</th>
                                             <td>{{ $provider->country_name }}</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">المدينة</th>
                                             <td>{{ $provider->city_name }}</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">البريد الالكتروني</th>
                                             <td><a>{{ $provider->email }}</a></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">حالة الحساب</th>
                                             <td>
                                                @if($provider->accountactivated == 1)
                                                <label class="label label-success">حساب مفعل</label>
                                                @else
                                                <label class="label label-danger">حساب غير مفعل</label>
                                                @endif
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <!-- end of table col-lg-6 -->
                              <div class="col-lg-12 col-xl-6">
                                 <div class="table-responsive">
                                    <table class="table">
                                       <tbody>
                                          <tr>
                                             <th scope="row">رقم الجوال</th>
                                             <td>{{ $provider->phone }}</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">الرصيد</th>
                                             <td>{{ ($provider_balances) ? $provider_balances->balance : 0 }} ريال</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">نسبة التطبيق</th>
                                             <td>{{ $provider->order_app_percentage }} ريال</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">سعر الاشتراك</th>
                                             <td>{{ ($provider->has_subscriptions) ? $provider->subscriptions_amount : 0 }} ريال {{ ($provider->has_subscriptions) ? ($provider->subscriptions_period == 0) ? 'شهريا' : 'سنويا' : '' }} </td>
                                          </tr>
                                          <tr>
                                             <th scope="row">تاريخ التسجيل</th>
                                             <td>{{ $provider->created_at }}</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <!-- end of table col-lg-6 -->
                           </div>
                           <!-- end of row -->
                        </div>
                        <!-- end of general info -->
                     </div>
                     <!-- end of col-lg-12 -->
                  </div>
                  <!-- end of row -->
               </div>
            </div>
            <!-- end of card-block -->
         </div>
         <!-- personal card end-->
      </div>
      <div class="tab-pane" id="review" role="tabpanel">
         <div class="card">
            <div class="card-block">
                <div class="card-block">
                    @if(count($sizes) > 0)
                    <table id="order-table" class="table table-striped table-bordered nowrap">
                        <thead>
                        <tr>
                            <th>اسم الحجم بالعربية</th>
                            <th>اسم الحجم بالانجليزية</th>
                            <th>السعر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sizes as $size)
                            <tr>
                                <td>{{ $size->ar_name }}</td>
                                <td>{{ $size->en_name }}</td>
                                <td>{{ $size->price }} <i class="icofont icofont-cur-riyal "></i> </td>
                            </tr>
                        @endforeach
                    </table>
                    @else
                        <div style="text-align: center">
                            لا توجد احجام لهذة الموجبة
                        </div>
                    @endif
                </div>
            </div>
         </div>
      </div>
      <div class="tab-pane" id="rate" role="tabpanel">
           <div class="card">
               <div class="card-block">
                   @if(count($adds) > 0)
                   <table id="order-table" class="table table-striped table-bordered nowrap">
                       <thead>
                       <tr>
                           <th>اسم الاضافة بالعربية</th>
                           <th>اسم الاضافة بالانجليزية</th>
                           <th>السعر المضاف</th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach($adds as $add)
                           <tr>
                               <td>{{ $add->ar_name }}</td>
                               <td>{{ $add->en_name }}</td>
                               <td>{{ $add->added_price }} <i class="icofont icofont-cur-riyal "></i> </td>
                           </tr>
                       @endforeach
                   </table>
                   @else
                       <div style="text-align: center">
                           لا توجد اضافات لهذة الوجبة
                       </div>
                   @endif
               </div>
           </div>
       </div>
      <div class="tab-pane" id="options" role="tabpanel">
           <div class="card">
               <div class="card-block">
                   @if(count($options) > 0)
                       <table id="order-table" class="table table-striped table-bordered nowrap">
                           <thead>
                           <tr>
                               <th>اسم التفضيلة بالعربية</th>
                               <th>اسم التفضيلة بالانجليزية</th>
                               <th>السعر المضاف</th>
                           </tr>
                           </thead>
                           <tbody>
                           @foreach($options as $option)
                               <tr>
                                   <td>{{ $option->ar_name }}</td>
                                   <td>{{ $option->en_name }}</td>
                                   <td>{{ $option->added_price }} <i class="icofont icofont-cur-riyal "></i> </td>
                               </tr>
                           @endforeach
                       </table>
                   @else
                       <div style="text-align: center">
                           لا توجد تفضيلات لهذة الوجبة
                       </div>
                   @endif
               </div>
           </div>
       </div>
   <!-- Nav tabs card end-->
   </div>

@endsection