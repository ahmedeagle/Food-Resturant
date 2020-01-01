@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
<style>
    .offer_ar_more , .offer_en_more{
        color: #3886de;
        text-decoration: underline;
    }
</style>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">{{ $title }}</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="{{ url('admin/offers/list/all') }}" style="line-height: 2.5">{{ $title }}</a>
         </li>
         <a style="float: left; color: white" href="{{ url('admin/offers/add') }}" class="btn btn-grd-primary">اضافة عرض جديد</a>

          <a style="float: left; color: white;margin-left: 5px;margin-rigth: 5px;" href="{{ url('admin/offers/reorder') }}" class="btn btn-grd-primary"> إعاده ترتيب العروض  </a>


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
            <table id="order-table" class="order-table table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                      <th>صورة العرض</th>
                     <th>عنوان العرض باللغة العربية</th>
                     <th>عنوان العرض باللغة الانجليزية</th>
                      <th>ملاحظات  العرض باللغة العربية</th>
                     <th>ملاحظات  العرض باللغة الانجليزية</th>
                     <th>اسم المطعم</th>
                     <th>حالة العرض</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                <?php  $index=1;?>
                  @foreach($offers as $key => $offer)
                    <tr>
                        <td><img style="width: 100px; height: 66px" src="{{ url('/storage/app/public/offers/'.$offer->image) }}"></td>
                        <td><input type="hidden" value="{{ $offer->ar_title }}" /> {{ str_limit($offer->ar_title, $limit = 30, $end = "....") }}@if(strlen($offer->ar_title) > 30)<a href="#" class="offer_ar_more">عرض المزيد</a> @endif</td>
                        <td><input type="hidden" value="{{ $offer->en_title }}" />{{ str_limit($offer->en_title, $limit = 30, $end = "....") }}@if(strlen($offer->ar_title) > 30)<a href="#" class="offer_en_more">عرض المزيد</a>@endif</td>
                        <td><input type="hidden" value="{{ $offer->ar_notes }}" /> {{ str_limit($offer->ar_notes, $limit = 30, $end = "....") }}@if(strlen($offer->ar_notes) > 30)<a href="#" class="offer_ar_more"> المزيد</a> @endif</td>
                        <td><input type="hidden" value="{{ $offer->en_notes }}" />{{ str_limit($offer->en_notes, $limit = 30, $end = "....") }}@if(strlen($offer->en_notes) > 30)<a href="#" class="offer_en_more"> المزيد</a>@endif</td>
                        <td>{{ $offer->ar_name }}</td>
                         <td>{{ ($offer->approved == 1) ? 'مفعل' : 'غير مفعل'}}</td>
                        <td>{{ $offer->created_at }}</td>
                        <td>
                            <a href="{{ url('admin/offers/edit/'.$offer->id) }}" class="btn btn-warning ">تعديل</a>
                            <button value="{{ $offer->id }}" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button>
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
                <h4 class="modal-title">حذف العرض</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذا العرض؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="content-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">تفاصيل العرض</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-content-data modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "{{ url('admin/offers/delete') }}" + "/" +val;

        }
        $(".offer_ar_more , .offer_en_more").on("click", function(e){
            e.preventDefault();
            $(".modal-content-data p").html($(this).parent().find("input").val());
            $("#content-Modal").modal();
        });


</script>
@endsection