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
         <li class="breadcrumb-item"><a href="{{ url('admin/pages') }}" style="line-height: 2.5">{{ $title }}</a>
         </li>
         <a style="float: left; color: white" href="{{ url('admin/pages/add') }}" class="btn btn-grd-primary">اضافة صفحة جديده</a>
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
         <h5>{{ $title }}</h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>  
                     <th>عنوان الصفحه باللغة العربية</th>
                     <th>عنوان الصفحة باللغة الانجليزية</th>
                     {{--<th>محتوى الصفحه باللغة العربية</th>--}}
                     {{--<th>محتوى الصفحه باللغة الانجليزية</th>--}}
                     <th>مفعل</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>

                  @foreach($pages as $key => $page)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $page->ar_title }}</td>
                        <td>{{ $page->en_title }}</td>
                        {{--<td>{{ word_limiter($page->ar_content,5) }}</td>--}}
                        {{--<td>{{ word_limiter($page->en_content,5) }}</td>--}}
                        <td>@if($page->active == 1) مفعل @else غير مفعل @endif</td>
                        <td>{{ $page->created_at }}</td>
                        <td>
                            <a href="{{ url('admin/pages/edit/'.$page->id ) }}" class="btn btn-warning ">تعديل</a>
                            @if($page->id != 1)
                                <button value="{{ $page->id }}" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button>
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
                <h4 class="modal-title">حذف الصفحة</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذه الصفحة ؟</p>
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
        a.href = "{{ url('admin/pages/delete') }}" + "/" +val;

        }
</script>
@endsection