$(document).ready(function () {

    // global variables
    var mealImages = [];
    var baseUrl = $('meta[name="base-url"]').attr('content');

    var deleted_id = [];
    // add meal image
    $(".add-meal-image").on("change", function (event) {


        var imagesNumber = $(".add-meal-images").children().length;
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

            $(".add-meal-images").append("<div><i class='delete-img fa fa-times' aria-hidden='true'></i><img class='io' src='"+ dataSrc +"' /></div>")
            $.each(selectedFile , function(k,v){
                mealImages.push(v);

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
        mealImages.splice($(this).parent().index(), 1);
        $(this).parent().remove();
    });

    $("#spicy").on("change", function () {

        var select = $(this).find(":selected").val();
        if(select == "1"){
            $(".spicy-degree-container").removeClass("hidden-element");
        }else{
            $(".spicy-degree-container").addClass("hidden-element");
        }

    });

    /*
    *
    *    Click On Add meal Button
    *
    * */

    $("#add-meal-from, #edit-meal-from").on("submit", function (event) {

        event.preventDefault();
        var imagesChildernNumber = $(".add-meal-images").children().length;
        if(imagesChildernNumber == 0){
            $("#meal-images-error").removeClass("hidden-element");
            scroll("restaurant-logo");
            return false;
        }else{
            $("#meal-images-error").addClass("hidden-element");
        }

        var calorie = $('#calorie').val();

        if(!$.isNumeric(calorie)){
            $("#meal-calorie-error").html("عدد السعيرات الحرارية غير صحيح");
            $("#meal-calorie-error").removeClass("hidden-element");
            scroll("calorie");
            return false;
        }else{
            $("#meal-calorie-error").html("");
            $("#meal-calorie-error").addClass("hidden-element");
        }

        var size1 = $("#size1").val();
        var price1 = $("#price1").val();

        if(size1 == "" || price1 == ""){
            notif({
                msg: "برجاء ادخال على الاقل حجم واحد من احجام الوجبة",
                type: "warning"
            });
            return false;
        }

        var enDetailsInput = $(".en-details").val();
        var arDetailsInput = $(".ar-details").val();
        var enDetails = enDetailsInput.split(" ");
        var arDetails = arDetailsInput.split(" ");

        if(arDetails.length < 5){
            $(".ar-details").addClass("has-error");
             $("#ar-details-error").removeClass("hidden-element");
            scroll("details");
            return false;
        }else{
            $(".ar-details").removeClass("has-error");
        }

        if(enDetails.length < 5){
            $(".en-details").addClass("has-error");
             $("#en-details-error").removeClass("hidden-element");
            scroll("details");
            return false;
        }else{
            $(".en-details").removeClass("has-error");
        }

        var spicy = $("#spicy").find(":selected").val();
        var spicyDegree = $("#spicy-degree").val();

        if(spicy == "1"){

            var degree = parseInt(spicyDegree);
            if(spicyDegree == "" || !$.isNumeric(spicyDegree) || degree > 5 || degree < 0){
                notif({
                    msg: "برجاء ادخال قيمة صحيحة لدرجة حرارة الصنف",
                    type: "warning"
                });
                scroll("spicy-degree");
                return false;
            }

        }


        var formData = new FormData();

        var unindexed_array = $(this).serializeArray();
        var indexed_array = {};


        var onlineList = false;
        var onlinePayment = false;

        $.map(unindexed_array, function(n, i){
            formData.append(n['name'] , n['value']);
        });


        var url = $(this).attr("data-action");

        var count = 0;
        $.each(mealImages, function(k,v){
            formData.append(k, v);
            count++;
        });

        formData.append("count", count);

        formData.append("deletedId", deleted_id);
        // call the server
        request(url, "POST", formData, function(){}, function (data) {

            if(data.status == true){
                notif({
                    msg: data.msg,
                    type: "success"
                });
                 setTimeout(function () {
                    window.location.href = baseUrl + "/restaurant/food-menu/list";
                 },2000)

            }else{
                notif({
                    msg: data.msg,
                    type: "warning"
                });
            }

        },function (error) {

        })

    });
    // helper functions
    function scroll(id){
        $('html, body').animate({
            scrollTop: ($('#' + id).first().offset().top)
        },500);
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
