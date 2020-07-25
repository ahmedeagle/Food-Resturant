$(document).ready(function () {

    $("#add-reply-btn").on("click", function (event) {
        event.preventDefault();
        var reply = $("#provider-details").val();

        if(reply == ""){
            $("#reply-error").html("برجاء كتابة الرد");
            $("#reply-error").removeClass("hidden-element");
            return false;
        }else{
            $("#reply-error").html("");
            $("#reply-error").addClass("hidden-element");
        }

        var url = $("#add-reply-form").attr("data-action");
        var formData = new FormData();
        formData.append("reply", reply);
        formData.append("ticket_id", $(".ticker_id").val());
        request(url, "POST", formData,function () {

        }, function (data) {

            $(".time").html(data.created_at);
            $(".reply-text").html(reply)

            $(".chat-container").append($(".reply-cell").html());
            $("#provider-details").val("");
        },function (error) {

        })
    })
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