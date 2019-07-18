@extends('admin_panel.blank')
@section('title')
- {{ $title }}
@endsection
@section('content')
<div class="page-body">

    <div class="row">


@can('users')
        <div class="col-md-6 col-xl-3">
            <a href="{{ url("/admin/customers/all") }}">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">مستخدمي التطبيق</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span>{{ $users }}</span></h2>
                    <br>
                    <p><span></span></p>
                </div>
            </div>
            </a>
        </div>
@endcan        

@can('providers')        
        <div class="col-md-6 col-xl-3">
            <a href="{{ url("/admin/providers/all") }}">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">المطاعم</h6>
                        <h2 class="text-right"><i class="ti-home f-left"></i><span>{{ $providers }}</span></h2>
                        <br>
                        <p><span></span></p>
                    </div>
                </div>
            </a>
        </div>
  @endcan      

@can('offers')        
        <div class="col-md-6 col-xl-3">
            <a href="{{ url("/admin/offers/list/all") }}">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">العروض</h6>
                        <h2 class="text-right"><i class="ti-agenda f-left"></i><span>{{ $offers }}</span></h2>
                        <br>
                        <p><span></span></p>
                    </div>
                </div>
            </a>
        </div>

@endcan
@can('orders')        
        <div class="col-md-6 col-xl-3">
            <a href="{{ url("/admin/orders") }}">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">الطلبات</h6>
                        <h2 class="text-right"><i class="ti-printer f-left"></i><span>{{ $orders }}</span></h2>
                        <br>
                        <p><span></span></p>
                    </div>
                </div>
            </a>
        </div>
    </div>
  @endcan  

 
</div> 
@endsection