@extends('admin_panel.blank')
@section('title')
    {{ $title  }}  
@endsection
 

@section("content")
    <main class="page-content py-5 mb-4">
        <div class="container">
            <div class="row">

 
                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">تغيير نوع الطعام</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                             <div class="alert alert-success" style="display:none;" id="food_selection">
                                  تمت العملية بنجاح
                            </div>
 
                            <form id="register-food-form" action="{{ url("/admin/providers/profile/change_meal_type".'/'.$provider_id) }}" method="POST" class="mt-4 font-body-md " data-toggle="buttons">

                                @php
                                    $count = 1;
                                    $addParent = true;
                                @endphp

                                <input type="hidden" class="food-count" value="{{ count($cats) }}" />
                                @foreach($cats as $key => $cat)

                                    @if($addParent)
                                        <div class="row justify-content-center">
                                            @endif

                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food @if($cat->selected == "1") active @endif">
                                                        <input
                                                                data-id = "{{ $cat->id }}"
                                                                class="form-check-input{{ $key }}"
                                                                type="checkbox"
                                                                @if($cat->selected == "1") checked @endif
                                                        />
                                                        {{ $cat->name }}
                                                    </label>
                                                </div>
                                            </div>

                                            @if($count < 4)
                                                @php
                                                    $count = $count + 1;
                                                    $addParent = false;
                                                @endphp

                                                @if(count($cats) == ($key +1))
                                        </div>
                            @endif
                            @continue
                            @else
                                @php
                                    $count =  1;
                                    $addParent = true;
                                @endphp
                            @endif
                    </div>
                    @endforeach

                    <div class="text-center mt-4 text-center">
                        <button type="submit" id="register-food-btn" class="btn btn-primary px-5 mx-auto text-center">تغيير</button>
                    </div>
                    </form>

                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

@endsection


@section('script') 

   <script>
       
        
         /*
    *
    *   Submit Provider Register Food List
    *
    * */
    $("#register-food-btn").on("click", function(){
        
        $('#food_selection').hide();
        
        
        // get the check box list
        var foodArray = [];
        var foodCount = $(".food-count").val();

        for(var i = 0; i<= parseInt(foodCount) -1; i++){

            if($(".form-check-input" + i).is(":checked")){
                foodArray.push($(".form-check-input" + i).attr("data-id"));
            }
        }

        var formData = new FormData()
        formData.append("food",foodArray);

        var url = $("#register-food-form").attr("action");
        request(url, "POST", formData, function(){},function(data){
            if(data.status == true){
                
                $('#food_selection').show();
                
                setTimeout(function () {
                         window.location.href = baseUrl + "/admin/providers/all";
                   
                },2000)

            }else{
                
            }
        },function(error){
             
        });

    });
    // upload image function
    function  readURL(input, handler) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var data = e.target.result;
                var check = data.substr(0, data.indexOf(';')).slice(5).split("/");
                if(check[0] != "image") return false;
                handler(e);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    
      // Request Function
    function request(url,type,data,beforeSend,success,error){
        $.ajax({
            url: url,
            type:type,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            processData: false,
            contentType: false,
            beforeSend: beforeSend,
            success: success,
            error:error
        });
    }
       
   </script>
@stop