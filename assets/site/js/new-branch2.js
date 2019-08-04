    $(document).ready(function () {

    var branchImages = [];
    var deleted_id = [];

    var baseUrl = $('meta[name="base-url"]').attr('content');
    $("#restaurant-logo").on("change", function (event) {


        var imagesNumber = $(".add-branch-images").children().length;
        if(imagesNumber == 10){
            notif({
                msg: "عفواً لا يمكن اضافة اكثر من 10 صور",
                type: "warning"
            });
            return false;
        }


        var selectedFile = event.target.files;

        readURL(this, function (e) {

            var dataSrc = e.target.result;

            $(".add-meal-images").append("<div><i class='delete-img fa fa-times' aria-hidden='true'></i><img class='io' src='"+ dataSrc +"' /></div>");
            $.each(selectedFile , function(k,v){
                branchImages.push(v);
            });

        });
    });

    $('body').on('mouseover', '.add-meal-images div', function() {

        $(this).find(".delete-img").css("visibility" , "visible");
    });


    $('body').on('mouseleave', '.add-meal-images div', function() {

        $(this).find(".delete-img").css("visibility" , "hidden");
    });


    $('body').on('click', '.add-meal-images div .delete-img', function() {
        var img_id = $(this).parent().find(".image_id").val();
        if(img_id){
            deleted_id.push(img_id);
        }
        branchImages.splice($(this).parent().index(), 1);
        $(this).parent().remove();
    });



    $("#new-banch-form, #edit-branch-from").on("submit", function (event) {

        event.preventDefault();

        var imagesChildernNumber = $(".add-meal-images").children().length;

        if(imagesChildernNumber == 0){
            $("#branch-images-error").removeClass("hidden-element");
            scroll("restaurant-logo");
            return false;
        }else{
            $("#branch-images-error").addClass("hidden-element");
        }

        var deliveryPrice = $('#delivery-price').val();

        if(!$.isNumeric(deliveryPrice)){

            $(".delivery-price-error").html("سعر التوصيل غير صحيح");
            $(".delivery-price-error").removeClass("hidden-element");
            scroll("delivery-price");
            return false;
        }else{
            $(".delivery-price-error").html("");
            $(".delivery-price-error").addClass("hidden-element");
        }


        var averagePrice = $('#average-price').val();

        if(!$.isNumeric(averagePrice)){

            $(".average-price-error").html("متوسط الاسعار غير صحيح");
            $(".average-price-error").removeClass("hidden-element");
            scroll("average-price");
            return false;
        }else{
            $(".average-price-error").html("");
            $(".average-price-error").addClass("hidden-element");
        }

        var phoneNumber = $('#phone-number').val();

        if(!$.isNumeric(phoneNumber)){

            $(".phone-number-error").html("رقم الجوال غير صحيح");
            $(".phone-number-error").removeClass("hidden-element");
            scroll("phone-number");
            return false;
        }else{
            $(".phone-number-error").html("");
            $(".phone-number-error").addClass("hidden-element");
        }

        if($("#branch-lat").val() == ""){
            $('.branch-location-error').html("برجاء تحديد عنوان الفرع على الخريطة");
            $('.branch-location-error').removeClass("hidden-element");
            scroll("address-map");
            return false;
        }else{
            $('.branch-location-error').html("");
            $('.branch-location-error').addClass("hidden-element");
        }



        // if($(".working-hours").val() == ""){
        //
        //     // show the working hours tab
        //     $("#work-tab").addClass("active");
        //     $("#work").addClass("show active");
        //
        //     // hide the other tabs
        //     $("#info-tab").removeClass('active');
        //     $("#branch-info").removeClass('show active');
        //
        //     $("#working-hours-error").removeClass("hidden-element");
        //
        //     window.scrollTo(0,0);
        //     return false;
        //
        // }else{
        //     $("#working-hours-error").addClass("hidden-element");
        // }

        // var type = $("#service-provider").find(":selected").val();
        // $("#service-provider").on("change", function () {
        //     type = $(this).find(":selected").val();
        // });

        var formData = new FormData();

        //formData.append("service-provider", type);
        var unindexed_array = $(this).serializeArray();
        var indexed_array = {};


        var onlineList = false;
        var onlinePayment = false;

        var found_has_booking = false
        var found_has_delivery = false;

        var options = [];
        $.map(unindexed_array, function(n, i){

            if(n['name'] == "has-delivery"){
                formData.append(n['name'] , "1");
                found_has_delivery = true;

            }else if(n['name'] == "has-booking"){
                formData.append(n['name'] , "1");
                found_has_booking = true;

            }else if(n['name'] == "has_payment"){
                 
                 formData.append(n['name'] , "1");
                  onlinePayment = true;
                
            }
            else{
                var check = n['name'].split("_");
                if(check[1]){
                    if(check[0] == "option"){
                        options.push(check[1]);
                    }
                }
                formData.append(n['name'] , n['value']);
            }
            
            
          
            

        });

        formData.append("options", options);
        if(!onlinePayment){
            formData.append("has_payment", "0");
        }
        
        if(!found_has_delivery){
            formData.append("has-delivery", "0");
        }

        if(!found_has_booking){
            formData.append("has-booking", "0");
        }
        var url = $(this).attr("data-action");

        var count = 0;
        $.each(branchImages, function(k,v){
            formData.append(k, v);
            count++;
        });

        formData.append("count", count);

        var workingCount = 0;

        $('.working-hours').each(function(key, value) {

            var selectedTime = $("#" + value.id).find(":selected").val();
            formData.append(value.id, selectedTime);

            if(selectedTime){

                // var selectedId = value.id;
                //
                // if(checkDay == ''){
                //     checkDay = selectedId;
                // }else{
                //
                //     var arr = selectedId.split("-");
                //     if(arr[1] == 'start'){
                //         checkDay = selectedId;
                //     }else{
                //         var checkarr =  checkDay.split("-");
                //         console.log("name", checkarr[0], arr[0]);
                //         if(checkarr[0] != arr[0] ){
                //             TimeError = false;
                //         }else{
                //             TimeError = true;
                //         }
                //     }
                // }
                workingCount++;
            }
        });

        var saturdayStart = $("#saturday-start-working-hours-select").find(":selected").val();
        var saturdayEnd = $("#saturday-end-working-hours-select").find(":selected").val();

        var sundayStart = $("#sunday-start-working-hours-select").find(":selected").val();
        var sundayEnd = $("#sunday-end-working-hours-select").find(":selected").val();

        var mondayStart = $("#monday-start-working-hours-select").find(":selected").val();
        var mondayEnd = $("#monday-end-working-hours-select").find(":selected").val();

        var tuesdayStart = $("#tuesday-start-working-hours-select").find(":selected").val();
        var tuesdayEnd = $("#tuesday-end-working-hours-select").find(":selected").val();

        var wednesdayStart = $("#wednesday-start-working-hours-select").find(":selected").val();
        var wednesdayEnd = $("#wednesday-end-working-hours-select").find(":selected").val();

        var thursdayStart = $("#thursday-start-working-hours-select").find(":selected").val();
        var thursdayEnd = $("#thursday-end-working-hours-select").find(":selected").val();

        var fridayStart = $("#friday-start-working-hours-select").find(":selected").val();
        var fridayEnd = $("#friday-end-working-hours-select").find(":selected").val();

        if(workingCount == 0){

            TimeErrorShow();
            return false;

        }else{
            TimeErrorHide();
        }

        if((saturdayStart && !saturdayEnd) || (saturdayEnd && !saturdayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }

        if((sundayStart && !sundayEnd) || (sundayEnd && !sundayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }

        if ((mondayStart && !mondayEnd) || (mondayEnd && !mondayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }

        if((tuesdayStart && !tuesdayEnd) || (tuesdayEnd && !tuesdayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }

        if((wednesdayStart && !wednesdayEnd) || (wednesdayEnd && !wednesdayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }

        if((thursdayStart && !thursdayEnd) || (thursdayEnd && !thursdayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }

        if((fridayStart && !fridayEnd) || (fridayEnd && !fridayStart)){
            TimeErrorShow();
            return false;
        }else{
            TimeErrorHide();
        }


        var meals = [];
        $('.branch-meal').each(function(key, value) {
            if($("#" + value.id).is(":checked")){
                formData.append("meal_" + $("#" + value.id).attr("data") , true);
                meals.push($("#" + value.id).attr("data"));
            }

        });

        formData.append("meals", meals);




        formData.append("deletedId", deleted_id);
        // call the server
        request(url, "POST", formData, function(){}, function (data) {

            if(data.status == true){
                notif({
                    msg: data.msg,
                    type: "success"
                });
                setTimeout(function () {
                    window.location.href = baseUrl + "/restaurant/branches/list";
                },2000)

            }else{
                notif({
                    msg: data.msg,
                    type: "danger"
                });
            }

        },function (error) {

        })

    });
    function TimeErrorShow(){
        // show the working hours tab
        $("#work-tab").addClass("active");
        $("#work").addClass("show active");

        // hide the other tabs
        $("#info-tab").removeClass('active');
        $("#branch-info").removeClass('show active');

        $("#working-hours-error").removeClass("hidden-element");

        window.scrollTo(0,0);
    }

    function TimeErrorHide(){
        $("#working-hours-error").addClass("hidden-element");
    }
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

    function scroll(id){
        $('html, body').animate({
            scrollTop: ($('#' + id).first().offset().top)
        },500);
    }

    function  readURL(input, handler) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var data = e.target.result;
                var check = data.substr(0, data.indexOf(';')).slice(5).split("/");
                if(check[0] != "image") {

                    notif({
                        msg: "برجاء اختيار صورة",
                        type: "warning"
                    });
                    return false;
                }
                handler(e);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

});
