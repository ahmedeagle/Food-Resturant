//(function ($) {

    var size = 0;
    var options = [];
    var adds = [];
    var meal_id = $("#meal_id").val();
    // Dynamic selected items
    function dynamicSelect() {
        $('#input-tags, #recommended').selectize({
            delimiter: ',',
            persist: false,
            create: function (input) {
                return{
                    value: input,
                    text: input
                }
            },
            render: {
                option_create: function (data, escape) {
                    return '<div class="create">Ø£Ø¶Ù <strong>' + escape(data.input) + '</strong>&hellip;</div>';
                }
            }
        });
    }
    if ($('body').is('.new-branch, .new-kind')) {
        dynamicSelect();
    }

    // Sorting items by
    function sortItems() {
        let toggler = $('.sort-by .dropdown-toggle');
        let togglerText  = toggler.text();
        let sortList  = $('.sort-by .dropdown-item');
        let defaultText = $(sortList).first().text();
        toggler.text(togglerText + defaultText);
        $(sortList).on('click', function (e) {
            if (sortList.length != 0) {
                let nthChild = sortList.index(this) + 1;
                let childText = $('.sort-by .dropdown-item:nth-child(' + nthChild + ')').text();
                $(toggler).text(togglerText + childText);
            }
            e.preventDefault();
        });
    }(sortItems());

    function sortOrders() {
        let toggler = $('.orders-sort .dropdown-toggle');
        let togglerText  = toggler.text();
        let sortList  = $('.orders-sort .dropdown-item');
        let defaultText = $(sortList).first().text();
        toggler.text(togglerText + defaultText);
        $(sortList).on('click', function (e) {
            if (sortList.length != 0) {
                let nthChild = sortList.index(this) + 1;
                let childText = $('.orders-sort .dropdown-item:nth-child(' + nthChild + ')').text();
                $(toggler).text(togglerText + childText);
            }
            e.preventDefault();
        });

    }(sortOrders());

    function sortReservation() {
        let toggler = $('.reservation-sort .dropdown-toggle');
        let togglerText  = toggler.text();
        let sortList  = $('.reservation-sort .dropdown-item');
        let defaultText = $(sortList).first().text();
        toggler.text(togglerText + defaultText);
        $(sortList).on('click', function (e) {
            if (sortList.length != 0) {
                let nthChild = sortList.index(this) + 1;
                let childText = $('.reservation-sort .dropdown-item:nth-child(' + nthChild + ')').text();
                $(toggler).text(togglerText + childText);
            }
            e.preventDefault();
        });

    }(sortReservation());


    // change size
    $(".size_select").on("change", function () {
        size = $(this).val();

        // check the cart data
        check_cart_data();
    });
    // change options selections
    $(".options_select").on("change", function () {

        if ($(this).is(":checked"))
        {
            options.push($(this).val());

        }else{

            var val = $(this).val();
            options = jQuery.grep(options, function(value) {
                return value != val;
            });

        }

        // check the cart data
        check_cart_data();
    });

    // change adds selections
    $(".adds_select").on("change", function () {

        if ($(this).is(":checked"))
        {
            adds.push($(this).val());

        }else{

            var val = $(this).val();
            adds = jQuery.grep(adds, function(value) {
                return value != val;
            });

        }

        // check the cart data
        check_cart_data();
    });

    function check_cart_data(){

        var meal_has_sizes = $("#meal_has_sizes").val();

        if(meal_has_sizes == 1 && size == 0){

            return false;
        }

        var url = $("#check_cart_content_url").val();

        var data = new FormData();

        data.append("meal_id", meal_id);
        data.append("size", size);
        data.append("adds", adds);
        data.append("options", options);

        request(url, "POST", data, function () {

        }, function (data) {



            $(".total_price_span").html(data.price);
            $("#number").html(data.qty);



        },function (error) {

        });
    }

    function increaseValue() {

        var meal_has_sizes = $("#meal_has_sizes").val();

        if(meal_has_sizes == 1 && size == 0){
            notif({
                msg: "برجاء اختيار حجم الوجبة",
                type: "warning"
            });
            return false;
        }

        // var warning = $("#clear_cart_alert").val();
        //
        // if(warning == 1){
        //
        //     $("#confirm-clear-cart").modal();
        //     return;
        // }
        //
        // $("#clear_cart_alert").val("0");
        // send request to the server

        var url = $("#add_cart_meal").val();
        var data = new FormData();
        data.append("meal_id", meal_id);
        data.append("size", size);
        data.append("options", options);
        data.append("adds", adds);
        request(url, "POST", data, function () {

        }, function (response) {

            var qty = parseInt(response.data.qty);

            $(".total_price_span").html(response.data.price);
            $("#number").html(qty);

        },function (error) {

        });
        var value = document.getElementById('number').innerHTML;
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById('number').innerHTML = value;
    }

    function decreaseValue() {

        // send request to the server

        var value = document.getElementById('number').innerHTML;
        value = isNaN(value) ? 0 : value;
        value--;
        value < 0 ? value = 0 : '';
        document.getElementById('number').innerHTML = value;
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

//})(jQuery);



