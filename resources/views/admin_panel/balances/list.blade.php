@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('content')
    <style>
        .offer_ar_more, .offer_en_more {
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
                <li class="breadcrumb-item"><a href="{{ url('admin/balances/list/' . $type) }}"
                                               style="line-height: 2.5">{{ $title }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-body">
        @if(Session::has('errors'))
            <div class="alert alert-danger"> {{ $errors->first('new_balance') }}</div>
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
                             <th>الاسم</th>
                            <th> الرصيد الحالي</th>
                            <th>اخر تحديث</th>
                            <th>العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                         @foreach($balances as  $balance)
                            <tr>
                                 <td>{{ $balance->name }}</td>
                                <td>{{ $balance->balance }}</td>
                                <td>{{ $balance->last_updated }}</td>
                                <td>
                                    <button value="{{ $balance->balance_id }}" data_name="{{$balance -> name}}"
                                            type="button"
                                            class="btn btn-success waves-effect" data-toggle="modal"
                                            data-target="#default-Modal" onclick="updatefn(this.value)">تعديل
                                    </button>
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
                    <h4 class="modal-title">تعديل الرصيد </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="updateBalnce" method="GET">
                    <div class="modal-body">

                        <input type="text" value="{{old('new_balance')}}" name="new_balance" class="form-control">
                        @if($errors->has("new_balance"))
                            <span class="text-danger">{{ $errors->first("new_balance") }}</span>
                        @endif
                    </div>
                    <div class="modal-footer">

                        <button type="submit" id="yes" style="margin-left: 5px; color: white"
                                class="btn btn-success waves-effect ">تعديل
                        </button>
                        <button type="button" data-dismiss="modal" aria-label="Close"
                                class="btn btn-primary waves-effect waves-light ">رجوع
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function updatefn(val) {
            var url = "{{ url('admin/balances/update') }}" + "/" + val;
            $('#updateBalnce').attr('action',url);
        }
    </script>
@endsection

@section('script')
    <script>
        $(document).ready(function () {

        });
    </script>
@stop