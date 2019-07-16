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
                     <th>رقم الهاتف</th>
                     <th>البريد الالكترونى</th>
                     <th>الرصيد</th>
                     <th>نسبة التطبيق</th>
                     <th>التصنيف</th>
                     <th>تاريخ التسجيل</th>
                     <th>الاشتراك</th>
                     <th>مدة الاشتراك</th>
                     <th>قيمة الاشتراك</th>
                     <th>حالة المطعم</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($providers as $key => $merchant)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $merchant->ar_name }}</td>
                        <td>{{ $merchant->phone }}</td>
                        <td>{{ $merchant->email }}</td>
                        <td>{{ (new \App\Http\Controllers\Admin\Providers())->get_balance($merchant->id) }} ريال </td>
                        <td>{{ $app_percentage }} % </td>
                        <td>{{ $merchant->cat }}</td>
                        <td>{{ $merchant->created_at }}</td>
                        <td>{{ ($merchant->has_subscriptions == "1" ) ? 'يوجد' : 'لايوجد' }}</td>
                        <td>@if($merchant->subscriptions_period == "0") لايوجد @elseif($merchant->subscriptions_period == "1") شهرى @else سنوى @endif</td>
                        <td>{{ $merchant->subscriptions_amount }}</td>
                        <td>{{ ($merchant->accountactivated == "1") ? 'مفعل' : 'غير مفعل'  }}</td>
                        <td>
                            @if($merchant->accountactivated == 0)
                                <a href="{{ url('admin/providers/approved/'.$merchant->id) }}" class="btn btn-success">تفعيل</a>
                            @else
                                <a href="{{ url('admin/providers/deactivate/'.$merchant->id) }}" class="btn btn-danger">الغاء التفعيل</a>
                            @endif
                            <a href="{{ url('admin/providers/view/'.$merchant->id) }}" class="btn btn-primary">عرض التفاصيل</a>
                            <a href="{{ url('admin/providers/change-subscription/'.$merchant->id) }}" class="btn btn-warning">تعديل الاشتراك</a>
                            <a href="{{ url('admin/providers/edit/'.$merchant->id) }}" class="btn btn-warning">تعديل  البيانات</a>
                            
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
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "{{ url('admin/merchants/delete') }}" + "/" +val;

        }
</script>
@endsection