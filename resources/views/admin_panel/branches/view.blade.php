@extends('admin_panel.blank')
@section('title')
   - {{ $title  }}
@endsection

@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">عرض تفاصيل الفرع</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/providers/view/' . $branch->provider_id) }}">عودة الى المطعم</a>
         </li>
         <li class="breadcrumb-item"><a>عرض تفاصيل الفرع</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
   <div class="row">
      <div class="col-md-12">
         <!-- Product detail page start -->
          @if(Session::has("success"))

              <div class="alert alert-success">
                {{ Session::get("success") }}
              </div>

          @endif
         <div class="card product-detail-page">
            <div class="card-block">
               <div class="row">
                  <div class="col-lg-5 col-xs-12" style="direction: ltr !important">
                     <div class="port_details_all_img row">
                        <div class="col-lg-12 m-b-15" style="direction: ltr !important">
                           <div id="big_banner">
                              @foreach ($branch_images as $img)
                              <div class="port_big_img">
                                 <img class="img img-fluid single-item-rtl" src="{{ url("storage/app/public/branches/" . $img->name) }}" alt="Big_ Details">
                              </div>
                              @endforeach
                           </div>
                        </div>
                        <div class="col-lg-12 product-right" style="direction: ltr !important">
                           <div id="small_banner"  style="direction: ltr !important">
                              @foreach ($branch_images as $img)
                              <div style="direction: ltr !important">
                                 <img class="img img-fluid" src="{{ url("storage/app/public/branches/" . $img->name) }}" alt="small-details">
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
                                <h6 class="pro-desc">اسم المطعم التابع للفرع: {{ $branch->provider_ar_name }}</h6>
                            </div>
                           <div class="col-lg-12">
                              <span class="txt-muted d-inline-block">عنوان الفرع: <a>{{ $branch->ar_address }}</a></span>
                           </div>
                           <div class="col-lg-12">
                              <span class="txt-muted">تصنيف المطعم التابع للفرع: {{ $branch->cat_name }} </span>
                           </div>

                           <div class="col-lg-12">
                              التوصيل: <span style="margin-right: 0px !important" class="text-primary product-price"> {{ ( $branch->has_delivery ) ? 'يوجد' : 'لا يوجد' }}</span>
                              <hr>
                               سعر التوصيل:<span style="margin-right: 0px !important" class="text-primary product-price"> {{ $branch->delivery_price }} ريال </span>
                              <hr>
                              متوسط سعر المنيو:
                              <p>{{ $meal_avg }}</p>
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
   <div class="col-lg-12 tab-header card">
      <ul class="col-lg-12 nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
         <li class="col-lg-4 nav-item">
            <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">عرض معلومات الفرع</a>
            <div class="slide"></div>
         </li>
         <li class="col-lg-4 nav-item">
            <a class="nav-link" data-toggle="tab" href="#review" role="tab">التعليقات</a>
            <div class="slide"></div>
         </li>
         <li class="col-lg-4 nav-item">
            <a class="nav-link" data-toggle="tab" href="#rate" role="tab">تفاصيل التقييم</a>
            <div class="col-lg-12 slide"></div>
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
                                             <th scope="row">الحجوزات</th>
                                             <td>{{ ( $branch->has_booking == "1") ? 'يوجد' : 'لا يوجد'}}</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">حالة الحجز</th>
                                             <td>@if($branch->booking_status == "0" ) افراد @elseif($branch->booking_status == "1") عوائل @else عوائل و افراد @endif</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">ميعاد بدء العمل</th>
                                             <td>{{ $branch->start_working_time }}</td>
                                          </tr>
                                          <tr>
                                             <th scope="row">ميعاد انهاء العمل</th>
                                             <td><a>{{ $branch->end_working_time }}</a></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">رقم الجوال لمدير الفرع</th>
                                             <td><a>{{ $branch-> phone }}</a></td>
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
                                               <th scope="row">اسم البنك</th>
                                               <td><a>{{ $branch->bank_name }}</a></td>
                                           </tr>
                                           <tr>
                                               <th scope="row">رقم الاىبان</th>
                                               <td><a>{{ $branch->iban_number }}</a></td>
                                           </tr>
                                           <tr>
                                               <th scope="row">مفعل من قبل المطعم</th>
                                               <td><a>{{ ( $branch->published == "1" ) ? 'مفعل' : 'غير مفعل' }}</a></td>
                                           </tr>
                                           <tr>
                                               <th scope="row">حالة الازدحام</th>
                                               <td><a>{{ $branch->cons_name }}</a></td>
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
                    @foreach($comments as $comment)

                        <div class="media m-b-20">
                            <a class="media-left" href="#">
                                <img style="width: 60px;height: 60px;border-radius: 50%;" class="media-object img-radius m-r-20" src="{{ ($comment->user_image_url) ? $comment->user_image_url : url("/storage/app/public/users/avatar.png") }}" alt="Generic placeholder image">
                            </a>
                            <div class="media-body b-b-muted social-client-description">
                                <div class="chat-header">{{ $comment->username }}<span class="text-muted">{{ $comment->created_at }}<br />@if($comment->stopped == "0") <a href="{{ url("/admin/branches/comments/stop/" . $comment->id) }}">ايقاف التعليق</a> @else <a href="{{ url("/admin/branches/comments/play/" . $comment->id) }}">إظهار التعليق</a> @endif </span></div>
                                <p class="text-muted">{{ $comment->comment }}</p>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
         </div>
      </div>
      <div class="tab-pane" id="rate" role="tabpanel">
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
                                                      <th scope="row">الخدمة</th>
                                                      <td>{{ $branch->average_service_rate }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">النظافة</th>
                                                      <td>{{ $branch->average_cleanliness_rate  }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">الجودة</th>
                                                      <td>{{ $branch->total_average_rate }}</td>
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
                                                      <th scope="row">التقييم الكلى</th>
                                                      <td><a>{{ $branch->total_average_rate }}</a></td>
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
       </div>
   <!-- Nav tabs card end-->
   </div>

@endsection