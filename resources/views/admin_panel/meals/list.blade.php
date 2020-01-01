@extends('admin_panel.blank')
@section('title')
   - {{ $title  }}
@endsection

@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">{{ $title }}</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/meals') }}" style="line-height: 2.5">{{ $title }}</a>
         </li>
          <a style="float: left; color: white  " href="{{ url('admin/meals/add') }}" class="btn btn-grd-primary">اضافة وجبة جديدة  </a>
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
             @if(Session::has("success"))
                 <div class="alert alert-success">
                     {{ Session::get("success") }}
                 </div>
             @endif
            <div class="card-block">
               <div class="table-responsive">
                  <div class="table-content">
                     <div class="project-table">

                         <table id="order-table" class="table table-striped table-bordered nowrap">
                             <thead>
                             <tr>
                                 <th>صورة الوجبة</th>
                                 <th>اسم الوجبة بالعربية</th>
                                 <th>اسم الوجبة بالانجليزية</th>
                                 <th>السعر</th>
                                 <th>السعرات الحرارية</th>
                                 <th>اسم المطعم</th>
                                 <th>مفعل</th>
                                 <th>العمليات</th>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach ($meals as $meal)
                                 <tr>
                                     <td class="pro-list-img">
                                         <img style="height: 64px; width: 64px;" src="{{ url("storage/app/public/meals/". $meal->image_url) }}" class="img-fluid" alt="tbl">
                                     </td>
                                     <td class="pro-name">
                                         {{ $meal->ar_name }}
                                     </td>
                                     <td class="pro-name">
                                         {{ $meal->en_name }}
                                     </td>
                                     <td>{{ $meal->price }} ريال</td>
                                     <td>{{ $meal->calories }}</td>
                                     <td>{{ $meal->provider_name }}</td>
                                     <td>{{ ($meal->published == 1) ? 'مفعل' : 'غير مفعل' }}</td>
                                     <td class="action-icon">
                                         <a style="color:#fff !important;" href="{{ url("admin/meals/view/" . $meal->id) }}" class="btn btn-primary m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">عرض التفاصيل<i class="icofont icofont-eye-alt"></i></a>
                                         <a style="color:#fff !important;" href="{{ url("admin/meals/edit/" . $meal->id) }}" class="btn btn-success m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">تعديل</a>
                                         @if($meal->published == "1")
                                            <a style="color:#fff !important;" href="{{ url("admin/meals/stop/" . $meal->id) }}" class="btn btn-danger m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">ايقاف الوجبة</a>
                                         @else
                                             <a style="color:#fff !important;" href="{{ url("admin/meals/publish/" . $meal->id) }}" class="btn btn-warning m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">الغاء الايقاف</a>
                                         @endif
                                     </td>
                                 </tr>
                             @endforeach
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