<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api_auth'])->group(function () {

    Route::post("/SignUp", "Apis\User\SignupController@SignUp")->name("post.api.signup");
    Route::get("/SignUp", "Apis\User\GeneralController@echo_Empty")->name("get.api.signup");

    Route::post("/Login", "Apis\User\LoginController@login")->name("post.api.login");
    Route::get("/Login", "Apis\User\GeneralController@echo_Empty")->name("get.api.login");

    Route::post("/SocialLogin", "Apis\User\SignupController@social_login");
    Route::get("/SocialLogin", "Apis\User\GeneralController@echo_Empty");

    Route::post("GetCities", "Apis\User\CityController@get_cities");
    Route::get("/GetCities", "Apis\User\GeneralController@echo_Empty");

    Route::post("GetCountries", "Apis\User\CountryController@get_countries");
    Route::get("/GetCountries", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetMealSubCategories", "Apis\User\SubcategoryController@get_meal_sub_categories");
    Route::get("/GetMealSubCategories", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetPages", "Apis\User\PageController@get_pages");
    Route::get("/GetPages", "Apis\User\GeneralController@echo_Empty");

    Route::post("/UsageAgreement", "Apis\User\PageController@get_usage_agreement_page");
    Route::get("/UsageAgreement", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetPage", "Apis\User\PageController@get_page");
    Route::get("/GetPage", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetHome", "Apis\User\HomeController@get_home_page");
    Route::get("/GetHome", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetCategories", "Apis\User\SubcategoryController@get_main_sub_categories");
    Route::get("/GetCategories", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetCategoryProviders", "Apis\User\SubcategoryController@get_nearest_providers_inside_main_sub_categories");
    Route::get("/GetCategoryProviders", "Apis\User\GeneralController@echo_Empty");

    Route::post("/resultOrderBy", "Apis\User\SearchController@searchResultOrderBy");
    Route::get("/resultOrderBy", "Apis\User\GeneralController@echo_Empty");

    Route::post("/filterResturants", "Apis\User\SearchController@filterResturants");
    Route::get("/filterResturants", "Apis\User\GeneralController@echo_Empty");


    Route::post("/GetOffers", "Apis\User\OfferController@get_offers");
    Route::get("/GetOffers", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetOffersApp", "Apis\User\OfferController@GetOffersApp");
    Route::get("/GetOffersApp", "Apis\User\GeneralController@echo_Empty");

    Route::post("/NearYou", "Apis\User\UserController@get_nearest_providers");
    Route::get("/NearYou", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetRestaurantPage", "Apis\User\BranchController@get_branch_page");
    Route::get("/GetRestaurantPage", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetRestaurantComments", "Apis\User\CommentController@get_branch_comments");
    Route::get("/GetRestaurantComments", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetRestaurantFoodList", "Apis\User\MealController@get_list_of_meals_inside_branch");
    Route::get("/GetRestaurantFoodList", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetCategoryMeals", "Apis\User\MealController@get_meals_cat");
    Route::get("/GetCategoryMeals", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetTicketTypes", "Apis\User\TicketController@get_ticket_types");
    Route::get("/GetTicketTypes", "Apis\User\GeneralController@echo_Empty");

    Route::post("/GetMealDetails", "Apis\User\MealController@get_meal_details");
    Route::get("/GetMealDetails", "Apis\User\GeneralController@echo_Empty");

    Route::post('/forgetPassword', "Apis\User\ForgetPasswordController@forgetPassword");
    Route::get('/forgetPassword', "Apis\User\GeneralController@echo_Empty");
      
    Route::post('/prepareFilter', "Apis\User\SearchController@prepareSearch");
    Route::get('/prepareFilter', "Apis\User\GeneralController@echo_Empty");

    Route::post('/filterResturants', "Apis\User\SearchController@filterResturants");
    Route::get('/filterResturants', "Apis\User\GeneralController@echo_Empty");
    

    Route::post('/Search', "Apis\User\SearchController@search");
    Route::get('/Search', "Apis\User\GeneralController@echo_Empty");

    Route::post('/getSearchAutocompleteLists', "Apis\User\SearchController@get_provider_names");
    Route::get('/getSearchAutocompleteLists', "Apis\User\GeneralController@echo_Empty");
    
    Route::middleware(['api_token'])->group(function () {
        Route::post('/activateAccount', "Apis\User\ForgetPasswordController@activateAccount");
        Route::get('/activateAccount', "Apis\User\GeneralController@echo_Empty");

        Route::post('/updatePassword', "Apis\User\ForgetPasswordController@updatePassword");
        Route::get('/updatePassword', "Apis\User\GeneralController@echo_Empty");
    
        Route::post("/PostUserMealSubCategories", "Apis\User\UserController@post_user_meal_sub_categories");
        Route::get("/PostUserMealSubCategories", "Apis\User\GeneralController@echo_Empty");

        Route::post("/GetFavoriteProviders", "Apis\User\FavoriteController@get_favorite_providers");
        Route::get("/GetFavoriteProviders", "Apis\User\GeneralController@echo_Empty");

        Route::post("/PostFavoriteProvider", "Apis\User\FavoriteController@post_favorite_providers");
        Route::get("/PostFavoriteProvider", "Apis\User\GeneralController@echo_Empty");

        Route::post("/RemoveFavoriteProvider", "Apis\User\FavoriteController@remove_favorite_providers");
        Route::get("/RemoveFavoriteProvider", "Apis\User\GeneralController@echo_Empty");

        Route::post("/AddComment", "Apis\User\CommentController@add_comment");
        Route::get("/AddComment", "Apis\User\GeneralController@echo_Empty");

        Route::post("/AddRate", "Apis\User\RateController@add_rate");
        Route::get("/AddRate", "Apis\User\GeneralController@echo_Empty");

        Route::post("/AddReservation", "Apis\User\ReservationController@add_reservation");
        Route::get("/AddReservation", "Apis\User\GeneralController@echo_Empty");

        Route::post("/CancelReservation", "Apis\User\ReservationController@cancel_reservation");
        Route::get("/CancelReservation", "Apis\User\GeneralController@echo_Empty");

        Route::post("/GetReservations", "Apis\User\ReservationController@get_Reservation");
        Route::get("/GetReservations", "Apis\User\GeneralController@echo_Empty");

        Route::post("/AddTicket", "Apis\User\TicketController@add_ticket");
        Route::get("/AddTicket", "Apis\User\GeneralController@echo_Empty");

        Route::post("/GetTickets", "Apis\User\TicketController@get_tickets");
        Route::get("/GetTickets", "Apis\User\GeneralController@echo_Empty");

        Route::post("/GetTicketMessages", "Apis\User\TicketController@get_ticket_messages");
        Route::get("/GetTicketMessages", "Apis\User\GeneralController@echo_Empty");

        Route::post("/AddMessage", "Apis\User\TicketController@add_message");
        Route::get("/AddMessage", "Apis\User\GeneralController@echo_Empty");

        Route::post("/PrepareUpdateProfile", "Apis\User\UserController@prepare_update_user_profile");
        Route::get("/PrepareUpdateProfile", "Apis\User\GeneralController@echo_Empty");

        Route::post("/UpdateProfile", "Apis\User\UserController@update_user_profile");
        Route::get("/UpdateProfile", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/ChangePassword", "Apis\User\UserController@change_password");
        Route::get("/ChangePassword", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/GetNotificationsList", "Apis\User\NotificationController@get_notifications");
        Route::get("/GetNotificationsList", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/GetNotificationsCount", "Apis\User\NotificationController@get_notification_count");
        Route::get("/GetNotificationsCount", "Apis\User\GeneralController@echo_Empty");
         
        
        Route::post("/AddOrder", "Apis\User\OrderController@create_order");
        Route::get("/AddOrder", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/CancelOrder", "Apis\User\OrderController@cancel_order");
        Route::get("/CancelOrder", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/GetOrders", "Apis\User\OrderController@get_list_of_orders");
        Route::get("/GetOrders", "Apis\User\GeneralController@echo_Empty");
        
        
        Route::post("/GetOrderDetails", "Apis\User\OrderController@get_order_details");
        Route::get("/GetOrderDetails", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/AddFavoriteOrder", "Apis\User\OrderController@add_favorit_order");
        Route::get("/AddFavoriteOrder", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/RemoveFavoriteOrder", "Apis\User\OrderController@remove_favorit_order");
        Route::get("/RemoveFavoriteOrder", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/GetFavoriteOrders", "Apis\User\OrderController@get_favorit_orders");
        Route::get("/GetFavoriteOrders", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/GetFavoriteOrderDetails", "Apis\User\OrderController@get_favorit_order_details");
        Route::get("/GetFavoriteOrderDetails", "Apis\User\GeneralController@echo_Empty");
        
        Route::post("/SendVerifiedCode", "Apis\User\UserController@send_verified_code");
        Route::get("/SendVerifiedCode", "Apis\User\SmsController@echo_Empty");
        
        Route::post("/GetUserBalance", "Apis\User\BalanceController@get_user_balance");
        Route::get("/GetUserBalance", "Apis\User\SmsController@echo_Empty");
        
        Route::post("/GetBalanceSettings", "Apis\User\BalanceController@get_app_balanace_settings");
        Route::get("/GetBalanceSettings", "Apis\User\SmsController@echo_Empty");
        
        
       
        
    });
});



 Route::get('testation',function(){
            
                 
  
                    
        });
        