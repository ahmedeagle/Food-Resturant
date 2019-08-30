@extends('admin_panel.blank')
@section('title')
    - {{ $title }}
@endsection
@section('style')

    <link href="{{asset('assets/admin_panel/nestedSortable/nestedSortable.css')}}" rel="stylesheet" type="text/css" />


@stop
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

          <a style="float: left; color: white;margin-left: 5px;margin-rigth: 5px;" href="{{ url('admin/offers/add') }}" class="btn btn-grd-primary"> إعاده ترتيب العروض  </a>


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
             

     @if(isset($offers) && $offers -> count() > 0)

      <ol class="sortable">
      	 @foreach($offers as $offer)
             <li id="list_{{$offer -> id }}">
            	<div>
            		<span class="disclose"><span></span>
            	     </span>{{$offer -> ar_title }} </div>
            	 </li>
          @endforeach 
       </ol>

      <button id="toArray" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> حفظ</span></button>
     
     @else 

              لا يوجد اي عروض لترتيبها 
     @endif
		  


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
        })
</script>
@endsection



@section('script')
    
    <script src="{{asset('assets/admin_panel/nestedSortable/jquery.mjs.nestedSortable2.js') }}" type="text/javascript"></script>



    <script type="text/javascript">
    	
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        jQuery(document).ready(function($) {

            // initialize the nested sortable plugin
            $('.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper: 'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels:  3,

                isTree: true,
                expandOnHover: 700,
                startCollapsed: false
            });

            $('.disclose').on('click', function() {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            });

            $('#toArray').click(function(e){
                // get the current tree order
                arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});

                // log it
                console.log(arraied);

                // send it with POST
                $.ajax({
                    url: '{{ Request::url() }}',
                    type: 'POST',
                    data: { tree: arraied },
                })
                    .done(function() {
                        console.log("success");
                        new PNotify({
                            title: "تم حفظ الترتيب بنجاح ",
                            text: " م حفظ الترتيب بنجاح ",
                            type: "success"
                        });
                    })
                    .fail(function() {
                        console.log("error");
                        new PNotify({
                            title: " فشل في حفظ الترتيب ",
                            text: " فشل في حفظ الترتيب ",
                            type: "danger"
                        });
                    })
                    .always(function() {
                        console.log("complete");
                    });

            });

            $.ajaxPrefilter(function(options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });

        });
    </script>

@stop