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

         <a style="float: left; color: white" href="{{route('admin.roles.add')}}" class="btn btn-grd-primary">اضافة  صلاحيه جديده </a>


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
                                 <th>المسلسل</th>
                                 <th>الاسم </th>
                                 <th>عدد القدرات </th>
                                  <th>تم الانشاء</th>
                                    <th>اخر تعديل</th>
                                  <th>العمليات</th>
                              </tr>
                           </thead>
                           <tbody>
                           @if(isset($roles) && $roles -> count() > 0)	
                            @foreach ($roles as $role)
                              <tr>
                                 <td>
                                   {{ $role->id }}
                                 </td>
                                 <td>
                                    <h6>{{ $role->name }}</h6>
                                 </td>
                                 <td>
                                    <h6>{{ $role->user_phone }}</h6>
                                 </td>
                                  <td>
                                   {{ $role-> created_at }}
                                 </td>
                                   <td>
                                   {{ $role-> updated_at }}
                                 </td>

                                 <td class="action-icon">
                                    <a href="{{ route('admin.roles.edit',$role->id) }}" class="btn btn-success ">تعديل  </a>  

                                    <a href="{{ route('admin.roles.delete',$role->id) }}" class="btn btn-danger ">حذف  </a>
                                 </td>

                              </tr>
                            @endforeach
                           @endif 
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