$(document).ready(function(){

    /*
    *
    *   Set General variables
    *
    * */
    

    var providerRegisterLogo = "";
    var baseUrl = $('meta[name="base-url"]').attr('content');
    
   /*
    *
    *   Chose provider logo image
    *
    * 
    */
    
    $("#restaurant-logo").on('change', function(event){
        providerRegisterLogo = event.target.files;
        readURL(this, function (e) {
            displayProviderLogo(e);
        });
    });


   /*
    *   Get the Cities List from the server
    * 
    */
    

    $(".country-ajax-request").on('change', function(){
       var id = $(this).find(":selected").val();

       if( id == "") {
           $(".city-ajax-request").html("<option value=''>برجاء تحديد الدولة اولا</option>");
           $(".city-ajax-request").focus();
           return false;
       }

       var url = $(this).attr("data-action");

       var data = new FormData();
       data.append("country", id);

       request(url, "POST", data,function(){}, function(data){
           $(".city-ajax-request").html("<option value=''>يرجى تحديد المدينة</option>");
            $.each(data.cities, function(k,v){
               $(".city-ajax-request").append("<option value='"+ v.id +"'>"+ v.name +"</option>");
                $(".city-ajax-request").focus();
           })

       },function(error){

       });
    });

    /*
    *
    *   Submit provider register form
    *
    * */
    $("#provider-register-form").on("submit", function(e){

        e.preventDefault();

        if(providerRegisterLogo.length == 0){
            $(".logo-error").removeClass("hidden-element");
            scroll("provider-logo-error");
            return false;
        }else{
            $(".logo-error").addClass("hidden-element");
        }



        var data = getFormData($(this));

        var formData = new FormData();

        var unindexed_array = $(this).serializeArray();
        var indexed_array = {};


        var onlineList = false;
        var onlinePayment = false;
        var acceptOrder = false;
        $.map(unindexed_array, function(n, i){

            if(n['name'] == "automatic-list"){
                formData.append(n['name'] , "1");
                onlineList = true;
            }else if(n['name'] == "accept-online-payment"){
                formData.append(n['name'] , "1");
                onlinePayment = true;
            }else if(n['name'] == "accept-order"){
                formData.append(n['name'] , "1");
                acceptOrder = true;
            }else{
                formData.append(n['name'] , n['value']);
            }

        });

        if(!onlinePayment){
            formData.append("accept-online-payment", "0");
        }

        if(!onlineList){
            formData.append("automatic-list", "0")
        }
        
        if(!acceptOrder){
            formData.append("accept-order", "0")
        }

        var url = $(this).attr("data-action");

        $.each(providerRegisterLogo, function(k,v){
            formData.append("image", v);
        });

        request(url, "POST" , formData, function(){}, function (data) {
            if(data.status == false){
                
                
                    
                
            }else{
                // return redirect the provider to phone activate
                  window.location.href = baseUrl + "/restaurant/activate-phone";
                 
            }
            console.log(data);
        }, function (reject) {
               var errors = $.parseJSON(reject.responseText);
                    $.each(errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });   
                    
        });

    });

    /*
    *
    *   Submit Provider Register Food List
    *
    * */
    $("#register-food-btn").on("click", function(){
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
                notif({
                    msg: data.msg,
                    type: "success"
                });
                setTimeout(function () {
                    if(data.final == "1"){
                        window.location.href = baseUrl + "/restaurant/dashboard";
                    }else{
                        window.location.href = baseUrl + "/restaurant/complete-profile/cat";
                    }
                    
                },2000)

            }else{
                notif({
                    msg: data.msg,
                    type: "warning"
                });
            }
        },function(error){
            notif({
                msg: data.msg,
                type: "error"
            });
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

    // Display Provider logo function after upload from device
    function displayProviderLogo(e){

        $(".provider-uploaded-logo").attr('src', e.target.result);
        $("#provider-logo-content").addClass("hidden-element");
        $(".provider-uploaded-logo").removeClass("hidden-element");
    }

    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }


    /*
    *
    *
    * *********************
    * *******************
    *   Profile page
    * *******************
    * *********************
    * */
    var editLogo = "";
    $(".edit-logo-file").on("change", function (event) {
        editLogo = event.target.files;
        readURL(this, function (e) {
            $("#edit-logo-image").attr('src', e.target.result);
            $("#edit-logo-btn").removeClass("hidden-element");
        });
    });

    $("#edit-logo-btn").on("click", function () {
       var url = $(this).attr("data-action");

       var imageData = new FormData();
        $.each(editLogo, function(k,v){
            imageData.append("image", v);
        });

       request(url, "POST", imageData, function(){}, function (data) {
           // success
           if(data.status == true){
               $("#edit-logo-btn").addClass("hidden-element");
               notif({
                   msg: "تم تعديل الصورة بنجاح",
                   type: "success"
               });
           }

       }, function (error) {
           // error
       })
    });

    /*
    *
    *   Add Reservation page
    *
    * */

    $("#special-event").on("change", function () {

        var select = $(this).find(":selected").val();
        if(select == "1"){
            $(".event_desc_content").removeClass("hidden-element");
            $(".event_desc_content").fadeIn(200);
        }else{
            $(".event_desc_content").fadeOut(200);
        }

    });

    /*
    *
    *   Complete Order Page
    *
    * */
 

    $("#in-future").on("change", function () {
        var method = $(this).find(":selected").val();
        if(method == "1"){
            $(".order-date-container, .order-time-container").removeClass("hidden-element");
        }else{
            $(".order-date-container, .order-time-container").addClass("hidden-element");
        }
    });
    // scroll function
    function scroll(id){
        $('html, body').animate({
            scrollTop: ($('#' + id).first().offset().top)
        },500);
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

});