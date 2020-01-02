@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10"><?=$title?></h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item" style="line-height: 2.5">
                    <a href="{{ url('admin/dashboard') }}">الرئيسية</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ url('reservations') }}" style="line-height: 2.5"><?=$title?></a>
                </li>
                {{--<a style="float: left; color: white" href="{{ url('admin/orderstatus/add') }}" class="btn btn-grd-primary">اضافة حالة جديدة</a>--}}
            </ul>
        </div>
    </div>




    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Product list card start -->
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
                        <div class="table-responsive">
                            <div class="table-content">
                                <div class="project-table">


                                    <table id="order-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>مسلسل</th>
                                            <th>اسم المطعم</th>
                                            <th>اسم المستخدم</th>
                                            <th>رقم الهاتف</th>
                                            <th>الايميل</th>
                                            <th>تاريخ الحجز</th>
                                            <th>عدد المقاعد</th>
                                            <th>مناسبة خاصة</th>
                                            <th>نوع الحجز</th>
                                            <th>حالة الحجز</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($reservations as $key => $r)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $r->provider_name }}</td>
                                                <td>{{ $r->user_name }}</td>
                                                <td>{{ $r->user_phone }}</td>
                                                <td>{{ $r->user_email }}</td>
                                                <td>{{ $r->time }} - {{ $r->date }}</td>
                                                <td>{{ $r->seats_number }}</td>
                                                <td>{{ ($r->special_reservation == "1") ? 'نعم': 'لا' }}</td>
                                                <td>{{ ($r->booking_status == "0") ? 'أفراد': 'عائلات' }}</td>
                                                <td>{{ $r->status }}</td>

                                            </tr>
                                        @endforeach
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


    <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">حذف الحالة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل تريد حذف هذا الحالة؟</p>
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
            a.href = "{{ url('admin/orderstatus/delete/') }}"+ "/" +val;

        }
    </script>
@endsection