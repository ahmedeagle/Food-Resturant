<?php



Route::get('trans',function(){
     
     $translator = new Dedicated\GoogleTranslate\Translator;


            $result = $translator->setSourceLang('en')
                                 ->setTargetLang('ru')
                                 ->translate('Hello World');
                                       
            dd($result); // "Привет мир"     


});

Route::prefix('restaurant')->group(function(){


     Route::post("/change-password" , "Provider\ForgetPasswordController@post_change_password");
     Route::post("/register" , "Provider\RegisterController@post_register");
     Route::post("/login" , "Provider\LoginController@post_login");
     Route::post("/cities" , "Provider\HomeController@get_cities");
     Route::post("/activate-phone", "Provider\AuthController@post_activate_phone");
     Route::post("/forget-password" , "Provider\ForgetPasswordController@post_forget_password");
     Route::post("/password-recovery/{guard?}" , "Provider\ForgetPasswordController@post_password_recovery");
     Route::middleware(['auth:provider','provider_phone_active'])->group(function(){
        Route::post("/complete-profile/map" , "Provider\HomeController@post_map_page");
        Route::post("/complete-profile/food" , "Provider\HomeController@post_food_select");
        Route::post("/complete-profile/cat" , "Provider\HomeController@post_cat_select");
        Route::post("/profile" , "Provider\ProfileController@post_profile");
        Route::post("/profile/edit-image" , "Provider\ProfileController@edit_logo");
        Route::post("/profile/change-password" , "Provider\ProfileController@change_password");
        Route::post("/profile/change-meal-type" , "Provider\ProfileController@post_change_meal_type");
        Route::post("/profile/change-resturant-categories" , "Provider\ProfileController@post_change_resturant_categories");
         Route::post("/profile/change-map-address" , "Provider\ProfileController@post_change_map_address");
         Route::post('/storebrowsertoken',"Provider\ProfileController@storebrowsertoken");
         Route::post("/contact-us/ticket/add-reply" , "Provider\TicketController@add_ticket_reply");
         Route::post("/contact-us/open-new-ticket" , "Provider\TicketController@post_new_ticket");
         Route::post("/branches/edit" , "Provider\BranchController@post_edit_branch");
         Route::post("/branches/getTimeFromOtherBranch/{branch_id}" , "Provider\BranchController@getTimesFromOtherBranch");
        Route::post("/food-menu/new-cat" , "Provider\MealController@post_new_cat");
        Route::post("/food-menu/cat/edit" , "Provider\MealController@post_edit_meal_cat");
        Route::post("/food-menu/edit" , "Provider\MealController@post_edit_meal");
        Route::post("/food-menu/add-new-meal" , "Provider\MealController@post_add_meal");
        
        Route::post("/branches/new-branch" , "Provider\BranchController@post_add_branch");

     });


    }); 



Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {


Route::prefix('restaurant')->group(function(){
    
    Route::get("/forget-password" , "Provider\ForgetPasswordController@get_forget_password");
    Route::get("/password-recovery/{token}/{guard?}" , "Provider\ForgetPasswordController@get_password_recovery");   
    Route::get("/change-password/{token}/{guard?}" , "Provider\ForgetPasswordController@get_change_password");   
    Route::get("/activate-phone", "Provider\AuthController@get_activate_phone");
    Route::get("/resend-activation-code", "Provider\AuthController@resend_activate_code");
    Route::middleware(['auth:provider','provider_phone_active'])->group(function(){

        Route::get("/complete-profile/map" , "Provider\HomeController@get_map_page");
        Route::get("/complete-profile/food" , "Provider\HomeController@get_food_select");
        Route::get("/complete-profile/cat" , "Provider\HomeController@get_cat_select");      
        Route::get("/profile" , "Provider\ProfileController@get_profile");
        Route::get("/profile/change-meal-type" , "Provider\ProfileController@change_meal_type");        
        Route::get("/profile/change-resturant-categories" , "Provider\ProfileController@change_resturant_categories");        
        Route::get("/profile/change-map-address" , "Provider\ProfileController@change_map_address");
        Route::get("/food-menu" , "Provider\MealController@get_food_menu_list");
        Route::get("/food-menu/add-new-meal" , "Provider\MealController@get_add_meal");  
        Route::get("/food-menu/list" , "Provider\MealController@get_meals");
        Route::get("/food-menu/stop/{id}" , "Provider\MealController@stop_meal");
        Route::get("/food-menu/activate/{id}" , "Provider\MealController@activate_meal");
        Route::get("/food-menu/edit/{id}" , "Provider\MealController@get_edit_meal");
        Route::get("/food-menu/cat/edit/{id}" , "Provider\MealController@get_edit_meal_cat");
        Route::get("/food-menu/cat/stop/{id}" , "Provider\MealController@get_stop_meal_cat");
        Route::get("/food-menu/cat/activate/{id}" , "Provider\MealController@get_activate_meal_cat");
        Route::get("/food-menu/cat/delete/{id}" , "Provider\MealController@get_delete_meal_cat");
        Route::get("/food-menu/delete/{id}" , "Provider\MealController@delete_meal");
        Route::get("/food-menu/categories" , "Provider\MealController@get_meal_categories");
        Route::get("/branches/list" , "Provider\BranchController@get_branches");
        Route::get("/branches/new-branch" , "Provider\BranchController@add_branch");
        Route::get("/branches/edit/{id}" , "Provider\BranchController@edit_branch");
        Route::get("/branches/stop-branch/{id}" , "Provider\BranchController@stop_branch");
        Route::get("/branches/activate-branch/{id}" , "Provider\BranchController@activate_branch");
        Route::get("/branches/delete/{id}" , "Provider\BranchController@delete_branch");
        Route::get("/contact-us" , "Provider\TicketController@get_contact_page");
        Route::get("/contact-us/open-new-ticket" , "Provider\TicketController@open_new_ticket");
        Route::get("/contact-us/tickets/list" , "Provider\TicketController@get_tickets");
        Route::get("/contact-us/ticket/details/{id}" , "Provider\TicketController@get_ticket_details");
        Route::get("/balance" , "Provider\BalanceController@get_balance_page");
        Route::get("/balance/withdraw" , "Provider\WithdrawController@withdraw_balance");
        Route::get("/download-rules" , "Provider\ProfileController@download_rules");        
        Route::get("/notifications_list" , "Provider\ProfileController@get_notifications") -> name('provider.notifications');

    });
    
       Route::middleware(['providerorbranch'])->group(function(){
            
              Route::get("/dashboard" , "Provider\IndexController@index");
            
        });

    

 Route::middleware(['providerorbranch'])->group(function() {
    Route::get("/reservations/list/{type}" , "Provider\ReservationController@get_reservations");
    Route::get("/reservations/reservation-details/{id}" , "Provider\ReservationController@get_reservation");
    Route::get("/reservations/accept/{id}" , "Provider\ReservationController@accept_reservation");
    Route::get("/reservations/decline/{id}" , "Provider\ReservationController@decline_reservation");
    Route::get("/reservations/finish/{id}" , "Provider\ReservationController@finish_reservation");

    Route::get("/orders/list/{type}" , "Provider\OrderController@get_orders");
    Route::get("/orders/order-details/{id}" , "Provider\OrderController@get_order");
    Route::get("/orders/accept-order/{id}" , "Provider\OrderController@accept_order");
    Route::get("/orders/decline-order/{id}" , "Provider\OrderController@decline_order");
    Route::get("/orders/confirm-processed-order/{id}" , "Provider\OrderController@processed_order");
    Route::get("/orders/finish-order/{id}" , "Provider\OrderController@finish_order");
    Route::get("/logout" , "Provider\LogoutController@logout");
    
 });
     
    
    Route::get("/page/{id}" , "Provider\PageController@get_page");

});


});