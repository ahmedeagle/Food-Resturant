$(document).ready(function(){
   var list = [];
   var sublist = [];
   var notify_type;
   var server_url;
    $('#default-Modal').modal({show: false,backdrop: 'static'})
    $('#success-modal').modal({show: false,backdrop: 'static'})
    $("#select-notify-type").on("change" , function(){
      var option = $(this).find(":selected").val();
      if(option == 0){
        $("#choose-users-container , #users-list").hide();
          $(".type-error").show();
          $(".type-error").html("برجاء اختيار نوع الارسال");
      }else if(option == 1){
          $("#choose-users-container , #users-list").hide();
          $(".type-error").hide();
          $(".type-error").html("");
      }else{
          $(".type-error").hide();
          $(".type-error").html("");
          $("#choose-users-container , #users-list").show();
      }
   });

   $(".check-user-btn").on("click" , function(){
      var sele_id = $(this).parent().find("#r_id").val();
      if($(this).is(":checked")){
          sublist.push(sele_id);
          //$(this).parent().find("#r_id").attr("form" , "notificatins-form");
      }else{
          sublist.splice( $.inArray(sele_id , sublist), 1 );
          //$(this).parent().find("#r_id").attr("form" , "");
      }
   });

   $(".add-btn-list").on("click", function(){
      list.splice(0 , list.length);
      for(var i = 0; i <= sublist.length -1 ; i++){
          list.push(sublist[i]);
      }

      if(list.length == 0){
          $(".noti-numbers").html("لم يتم اختيار مستقبلى الاشعار");
      }else{
          $(".noti-numbers").html(" سوف يتم ارسال الاشعار الى " + list.length + " مستخدمين ");
      }

      $("#default-Modal").modal("hide");
      console.log(list);
   });

   $(".list-back").on("click" , function(){

       for(var i = 0; i <= sublist.length -1 ; i++){
           $("#refre"+sublist[i]).find(".check-user-btn").prop('checked', false);
       }

       sublist.splice(0 , sublist.length);
       for(var i = 0; i <= list.length -1 ; i++){
           sublist.push(list[i]);
           $("#refre"+list[i]).find(".check-user-btn").prop('checked', true);
       }

       $("#default-Modal").modal("hide");
   });

   $(".send-notify-btn").on("click" , function(e){
       e.preventDefault();
       var title = $(".title").val();
       var content = $(".content").val();
       var op  = $("#select-notify-type").find(":selected").val();

       if(title == ""){
           $(".title-error").show();
           $(".title-error").html("برجاء ادخال عنوان الاشعار");
       }else{
           $(".title-error").hide();
           $(".title-error").html("");
       }
       if(content == ""){
           $(".content-error").show();
           $(".content-error").html("برجاء ادخال محتوى الاشعار");
       }else{
           $(".content-error").hide();
           $(".content-error").html("");
       }

       if(op == 0){
           $(".type-error").show();
           $(".type-error").html("برجاء اختيار نوع الارسال");
       }else if(op == 1){
           $(".type-error").hide();
           $(".type-error").html("");
       }else{
           $(".type-error").hide();
           $(".type-error").html("");
           console.log("len" , list.length);
           if(list.length == 0){
               $(".number-error").show();
               $(".number-error").html("برجاء تحديد مستقبلى الاشعار");
           }else{
               $(".number-error").hide();
               $(".number-error").html("");
           }
       }
       if(title != "" && content != "" && op != 0){
           if( (op == 1) ||  (op == 2 && list.length != 0 )){
               var url = $("#notificatins-form").attr("action");
               var base_url = $("#notificatins-form").attr("base_url");
               server_url = base_url;
               var _token = $("#notificatins-form").find("input[ name = '_token']").val();
               var type = $("#rec_type").val();
               notify_type = type;
               var data = new FormData();
               data.append("_token" , _token);
               data.append("title" , title);
               data.append("content" , content);
               data.append("option_type" , op);
               data.append("type" , type);
               var count = 0;
               for(var i = 0 ; i <= list.length -1; i++){
                   data.append("r_id" +i , list[i]);
                   count = i;
               }
               data.append("count" , count);
               request(url , "POST" , data , function(data) {
                   $(".send-notify-btn").html("ارسال");

                   $("#success-modal").modal("show");
               } , function(error){
                   console.log("error" , error);
               } ,function(){
                    $(".send-notify-btn").html("<i class='fa fa-spinner fa-spin'></i>");
               });
           }
       }

   });

    $("#search").on("keyup", function() {
        var input, filter, ul, li, a, i, txtValue;

        input = document.getElementById("search");

        filter = input.value.toUpperCase();
        ul = $("#notification-container");
        li = ul.find(".notification-cell");

        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("h6")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    });
    $(".search-notification").on("keyup", function() {
        var input, filter, ul, li, a, i, txtValue;

        filter = $(this).val().toUpperCase();

        ul = $(".notification-container-2");

        li = ul.find(".notification-cell-2");
        console.log("count", li.length);
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("h6")[0];

            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    });

   $(".back-to-notification").on("click" , function(){
       location.href = server_url + "/admin/notifications/list/" + notify_type;
   });
    $(".clear-btn").on("click" , function(){
       location.href = server_url + "/admin/notifications/add/" + notify_type;
    });
    function request(url,type,data,success,error,beforeSend){
        $.ajax({
            url: url,
            type:type,
            data:data,
            processData: false,
            contentType: false,
            beforeSend: beforeSend,
            success: success,
            error:error
        });
    }
});
