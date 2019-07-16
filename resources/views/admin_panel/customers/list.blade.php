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
         <li class="breadcrumb-item"><a style="line-height: 2.5"><?=$title?></a>
         </li>
      </ul>
   </div>
</div>
<div class="page-body">
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
                     <th>رقم الهاتف</th>
                     <th>البريد الالكترونى</th>
                     <th>النوع</th>
                     <th>تاريخ الميلاد</th>
                     <th>تاريخ التسجيل</th>
                     <th>الرصيد</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($customers as $key => $customer)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ ($customer->gender == "male") ? "ذكر" : "انثى" }}</td>
                        <td>{{ $customer->date_of_birth }}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ (new \App\Http\Controllers\Admin\Customers())->get_balance_user($customer->id) }} ريال </td>
                        <td><a href="{{ url("/admin/customers/view/" . $customer->id) }}" class="btn btn-success">عرض التفاصيل</a>
                        <a href="{{ url("/admin/customers/edit/" . $customer->id) }}" class="btn btn-success"> تعديل </
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
                <p>هل انت متاكد من انك تريد حذف هذا التاجر ؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</a>
            </div>
        </div>
    </div>
</div>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "{{ url('admin/customers/delete') }}" + "/" +val;

        }
</script>
@endsection