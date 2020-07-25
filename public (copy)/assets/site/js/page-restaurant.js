$(document).ready(function(){

    var baseUrl = $('meta[name="base-url"]').attr('content');
    var rateStare = baseUrl + "/assets/site/img/-e-rating-icon.svg";
    var rateNoColor = baseUrl + "/assets/site/img/-e-rating-icon-ncolor.svg"

    var service = 0;
    var quality = 0;
    var cleanliness =0;
    /* 1. Visualizing things on Hover - See next part for action on click */

    initMap();


    /* 2. Action to perform on click */
    $('#cleanliness-stars li, #service-stars li, #quality-stars li').on('click', function(){

        var rate = $("#is_user_rate").val();
        var canRate = $("#is_user_can_rate").val();
        if(canRate == false) {
            return false;
        }

        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        if($(this).parent().attr("id") == "cleanliness-stars"){
            cleanliness = onStar;
        }

        if($(this).parent().attr("id") == "service-stars"){
            service = onStar;
        }

        if($(this).parent().attr("id") == "quality-stars"){
            quality = onStar;
        }


        for (i = 0; i < stars.length; i++) {
            $(stars[i]).find(".img-fluid").attr("src", rateNoColor);//removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).find(".img-fluid").attr("src", rateStare);//.addClass('selected');
        }

    });

    $("#add-comment-btn").on("click", function(){

        var comment = $("#comment-text").val();
        var branch_id = $("#branch_id").val();
        if(comment == ""){
            notif({
                msg: "برجاء كتابة نص التعليق",
                type: "warning"
            });
            return false;
        }

        var data = new FormData();

        data.append("cleanliness", cleanliness);
        data.append("service", service);
        data.append("quality", quality);
        data.append("id", branch_id);
        data.append("comment", comment);
        // send request
        var url = $("#user_comment_url").val();

        request(url, "POST", data, function(){}, function(data){

            $(".comment-cell").find(".comment-cell-text").html(comment);
            $(".comment-container").prepend($(".comment-cell").html());
            $("#comment-text").val("");
            $("#comment-text").blur();
            notif({
                msg: "تمت العملية بنجاح",
                type: "success"
            });

        },function (error) {

        })
    });





















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
