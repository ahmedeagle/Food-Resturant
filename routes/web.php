<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['guest:web', 'guest:provider', 'guest:branch'])->group(function() {
 Route::post('/contact-us', "Site\ContactController@contact_us");
  Route::prefix('user')->group(function() {
    Route::post("/register", "User\RegisterController@register");
    Route::post("/forget-password", "User\ForgetPasswordController@post_forget_password");
    Route::post("/password-recovery", "User\ForgetPasswordController@post_password_recovery");
    Route::post("/change-user-password", "User\ForgetPasswordController@post_change_password");
    Route::post("/login", "User\LoginController@login");
  });

});

Route::middleware(['auth:web'])->prefix('user')->group(function() {
    Route::post("/activate-phone", "User\AuthController@post_activate_phone");
     Route::middleware(['user_phone_active'])->group(function() {
         Route::post("/profile", "User\ProfileController@post_profile_page");
         Route::post("/profile/edit-image", "User\ProfileController@edit_logo");
         Route::post("/change-password", "User\ProfileController@change_password");
         Route::post("/reservations/add-reservation" , "User\ReservationController@post_add_reservation");
          Route::post("/tickets/open-new-ticket" , "User\TicketController@post_new_ticket");
          Route::post("/cart/add", "User\CartController@add");
          Route::post("/cart/check-cart-content", "User\CartController@check_cart_content");
          Route::post("/cart/complete-order", "User\CartController@post_complete_order");
          Route::post("/cart/check_balance", "User\CartController@checkUserBalance");
          Route::post('/paytabs_response', "User\PaymentController@payment_response");
          Route::post("/add-comment", "User\CommentController@add_comment");
     });

});

Route::middleware(['guest:provider', 'guest:branch','web'])->group(function() {
  Route::post('/search', "Site\SearchController@search");
});




Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {

        Route::middleware(['guest:web', 'guest:provider', 'guest:branch'])->group(function() {

            Route::get('/', "Site\HomeController@index");
            //cron job to check if subscription expired
            Route::get("/subscription" , "Site\HomeController@check_subscription");
            Route::get('/register', "Site\HomeController@register");
            Route::get('/login', "Site\HomeController@login");
            Route::get('/login/facebook', 'User\SocialLoginController@redirectToFacebookProvider');
            Route::get('/auth/facebook/callback', 'User\SocialLoginController@handleFacebookProviderCallback');
            Route::get('/login/twitter', 'User\SocialLoginController@redirectToTwitterProvider');
            Route::get('/auth/twitter/callback', 'User\SocialLoginController@handleTwitterProviderCallback');
            Route::get('/categories', "Site\CategoryController@categories");
            Route::get('/page/{id}', "Site\PageController@get_page");
            
            Route::prefix('user')->group(function() {
                Route::get("/forget-password", "User\ForgetPasswordController@get_forget_password");        
                Route::get("/password-recovery/{token}", "User\ForgetPasswordController@get_password_recovery");
                Route::get("/change-password/{token}", "User\ForgetPasswordController@get_change_password");    

            });

        });
   });      


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {
        Route::middleware(['guest:provider', 'guest:branch','web'])->group(function() {
            Route::get("/restaurant-page/{id}", "Site\BranchController@get_restaurant_page");
            Route::get("/meal-page/{id}", "Site\MealController@get_meal_page");    
            Route::get('/search', "Site\SearchController@get_search");
            Route::get('/cat-restaurants/{id}', "Site\CategoryController@get_cat_providers");
        });
});


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {

    Route::middleware(['auth:web'])->prefix('user')->group(function() {
        Route::get("/activate-phone", "User\AuthController@get_activate_phone");
        Route::get("/resend-activation-code", "User\AuthController@resend_activate_code");
        Route::get("/logout", "User\LogoutController@logout");
        Route::middleware(['user_phone_active'])->group(function() {
            Route::get("/dashboard", "User\HomeController@index");
            Route::get("/profile", "User\ProfileController@get_profile_page");
            Route::get("/reservations", "User\ReservationController@get_reservations");
            Route::get("/reservations/reservation-details/{id}" , "User\ReservationController@get_reservation");
            Route::get("/reservations/add-reservation/{id}/{type}" , "User\ReservationController@add_reservation");
            Route::get("/reservations/decline/{id}" , "User\ReservationController@decline_reservation");
            Route::get("/orders", "User\OrderController@get_orders");
            Route::get("/orders/order-details/{id}" , "User\OrderController@get_order");
            Route::get("/orders/decline-order/{id}" , "User\OrderController@decline_order");
            Route::get("/favorites", "User\FavoritController@get_favorites");
            Route::get("/favorites/remove/{id}", "User\FavoritController@remove");
            Route::get("/favorites/add/{id}", "User\FavoritController@add");
            Route::get("/page/{id}", "User\PageController@get_page");
            Route::get("/tickets", "User\TicketController@get_tickets_select");
            Route::get("/tickets/open-new-ticket" , "User\TicketController@open_new_ticket");
            Route::get("/tickets/tickets/list" , "User\TicketController@get_tickets");
            Route::get("/tickets/ticket/details/{id}" , "User\TicketController@get_ticket_details");
            Route::get("/notifications", "User\NotificationController@get_notifications");
            Route::get("/cart", "User\CartController@get_cart_page");
            Route::get("/cart/remove-cart-meal/{id}", "User\CartController@remove_cart_meal");
            Route::get("/cart/complete-order", "User\CartController@get_complete_order");        
            Route::get("/cart/finish-order", "User\CartController@get_finish_order");
            Route::get("/cart/order-failed", "User\CartController@get_failed_order");
        });

    });

});