@extends('admin_panel.blank')
@section('title')
    - {{ $title  }}
@endsection

@section('content')
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/admins') }}" style="line-height: 2.5"><?=$title?></a>
         </li>
         <a style="float: left; color: white" href="{{ url('admin/admins/add') }}" class="btn btn-grd-primary">اضافة مدير جديد</a>
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
                     <th>الاسم بالكامل</th>  
                     <th>رقم الجوال</th>
                     <th>البريد الالكتروني</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($admins as $key => $admin)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->phone }}</td>
                        <td>{{ $admin->email }}</td>
                        <td><a href="{{ url('admin/admins/edit/'.$admin->id) }}" class="btn btn-warning ">تعديل</a>
                            @if($admin->id != 1)
                            <button value="{{ $admin->id }}" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">تأكيد الحذف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل انت متاكد من انك تريد حذف هذا المستخدم ؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "{{ url('admin/admins/delete') }}" + "/" +val;

        }
</script>
@endsection