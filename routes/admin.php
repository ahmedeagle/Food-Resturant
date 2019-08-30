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

       ////cron job to check if subscription expired
       Route::get("/subscription" , "Admin\Providers@check_subscription");
            
        
Route::middleware(['auth:admin'])->prefix('admin')->group(function(){


    Route::get('/dashboard', "Admin\Dashboard@index") -> middleware('can:dashboard');
    
 Route::group(['prefix' => 'countries', 'middleware' => 'can:countries'], function () {
        Route::get('/', "Admin\Countries@index");
        Route::get('/add', "Admin\Countries@get_add");
        Route::post('/store', "Admin\Countries@post_add");
        Route::get('/edit/{id}', "Admin\Countries@get_edit");
        Route::post('/update/{id}', "Admin\Countries@post_edit");
        Route::get('/delete/{id}', "Admin\Countries@delete");  
    });

    Route::group(['prefix' => 'admins', 'middleware' => 'can:admins'], function () {
        Route::get('/', "Admin\Users@index");
        Route::get('/add', "Admin\Users@get_add");
        Route::post('/store', "Admin\Users@post_add");
        
        Route::get('/delete/{id}', "Admin\Users@delete");
    });


  Route::group(['prefix' => 'admins', 'middleware' => 'can:profile'], function () {
       Route::get('/edit/{id}', "Admin\Users@get_edit");
       Route::post('/update/{id}', "Admin\Users@post_edit");
    });

     Route::group(['prefix' => 'cities', 'middleware' => 'can:cities'], function () {    
        Route::get('/', "Admin\Cities@index");
        Route::get('/add', "Admin\Cities@get_add");
        Route::post('/store', "Admin\Cities@post_add");
        Route::get('/edit/{id}', "Admin\Cities@get_edit");
        Route::post('/update/{id}', "Admin\Cities@post_edit");
        Route::get('/delete/{id}', "Admin\Cities@delete");
    });


     Route::group(['prefix' => 'roles', 'middleware' => 'can:roles'], function () {        
            Route::get('/', 'Admin\RolesController@getIndex')->name('admin.roles.index');
            Route::get('add', 'Admin\RolesController@create') -> name('admin.roles.add');
            Route::post('add', 'Admin\RolesController@save') -> name('admin.roles.save');
            Route::get('/edit/{id}', 'Admin\RolesController@edit') ->name('admin.roles.edit');
            Route::post('/update/{id}', 'Admin\RolesController@update') ->name('admin.roles.update');
            Route::get('/delete/{id}', 'Admin\RolesController@postDelete')->name('admin.roles.delete');
        });


     Route::group(['prefix' => 'pages', 'middleware' => 'can:pages'], function () {            
        Route::get('/', "Admin\Pages@index");
        Route::get('/add', "Admin\Pages@get_add");
        Route::post('/store', "Admin\Pages@post_add");
        Route::get('/edit/{id}', "Admin\Pages@get_edit");
        Route::post('/update/{id}', "Admin\Pages@post_edit");
        Route::get('/delete/{id}', "Admin\Pages@delete");
    });

    Route::group(['prefix' => 'ticketTypes', 'middleware' => 'can:ticket_types'], function () {                 
        Route::get('/', "Admin\Tickets_types@index");
        Route::get('/add', "Admin\Tickets_types@get_add");
        Route::post('/store', "Admin\Tickets_types@post_add");
        Route::get('/edit/{id}', "Admin\Tickets_types@get_edit");
        Route::post('/update/{id}', "Admin\Tickets_types@post_edit");
        Route::get('/delete/{id}', "Admin\Tickets_types@delete");
    });

     Route::group(['prefix' => 'bookingstatus', 'middleware' => 'can:booking_status'], function () {     
        Route::get('/', "Admin\bookingstatus@index");
        Route::get('/add', "Admin\bookingstatus@get_add");
        Route::post('/store', "Admin\bookingstatus@post_add");
        Route::get('/edit/{id}', "Admin\bookingstatus@get_edit");
        Route::post('/update/{id}', "Admin\bookingstatus@post_edit");
        Route::get('/delete/{id}', "Admin\bookingstatus@delete");
    });

     Route::group(['prefix' => 'orderstatus', 'middleware' => 'can:order_status'], function () {         
        Route::get('/', "Admin\orderstatus@index");
        Route::get('/add', "Admin\orderstatus@get_add");
        Route::post('/store', "Admin\orderstatus@post_add");
        Route::get('/edit/{id}', "Admin\orderstatus@get_edit");
        Route::post('/update/{id}', "Admin\orderstatus@post_edit");
        Route::get('/delete/{id}', "Admin\orderstatus@delete");
    });

    Route::group(['prefix' => 'mainCategories', 'middleware' => 'can:categories'], function () {              
        Route::get('/', "Admin\Categories@index");
        Route::get('/add', "Admin\Categories@get_add");
        Route::post('/store', "Admin\Categories@post_add");
        Route::get('/edit/{id}', "Admin\Categories@get_edit");
        Route::post('/update/{id}', "Admin\Categories@post_edit");
        Route::get('/delete/{id}', "Admin\Categories@delete");
    });

    Route::group(['prefix' => 'subCategories'], function () {     
        Route::get('/', "Admin\SubCategories@index");
        Route::get('/add', "Admin\SubCategories@get_add");
        Route::post('/store', "Admin\SubCategories@post_add");
        Route::get('/edit/{id}', "Admin\SubCategories@get_edit");
        Route::post('/update/{id}', "Admin\SubCategories@post_edit");
        Route::get('/delete/{id}', "Admin\SubCategories@delete");
    });

     Route::group(['prefix' => 'crowd', 'middleware' => 'can:crowd'], function () {    
        Route::get('/', "Admin\crowd@index");
        Route::get('/add', "Admin\crowd@get_add");
        Route::post('/store', "Admin\crowd@post_add");
        Route::get('/edit/{id}', "Admin\crowd@get_edit");
        Route::post('/update/{id}', "Admin\crowd@post_edit");
        Route::get('/delete/{id}', "Admin\crowd@delete");
    });

    Route::group(['prefix' => 'mealCategories'], function () {           
        Route::get('/', "Admin\MealCategories@index");
        Route::get('/add', "Admin\MealCategories@get_add");
        Route::post('/store', "Admin\MealCategories@post_add");
        Route::get('/edit/{id}', "Admin\MealCategories@get_edit");
        Route::post('/update/{id}', "Admin\MealCategories@post_edit");
        Route::get('/delete/{id}', "Admin\MealCategories@delete");
    });

    Route::prefix('/foodCategories')->group(function(){
        Route::get('/', "Admin\FoodCategories@index");
        Route::get('/add', "Admin\FoodCategories@get_add");
        Route::post('/store', "Admin\FoodCategories@post_add");
        Route::get('/edit/{id}', "Admin\FoodCategories@get_edit");
        Route::post('/update/{id}', "Admin\FoodCategories@post_edit");
        Route::get('/delete/{id}', "Admin\FoodCategories@delete");
    });

    Route::group(['prefix' => 'meals', 'middleware' => 'can:meals'], function () {        
        Route::get('/', "Admin\Meals@index");
        Route::get('/add', "Admin\Meals@get_add");
        Route::post('/store', "Admin\Meals@post_add");
        Route::get('/edit/{id}', "Admin\Meals@get_edit");
        Route::post('/edit', "Admin\Meals@post_edit");
        Route::post('/update/{id}', "Admin\Meals@post_edit");
        Route::get('/delete/{id}', "Admin\Meals@delete");
        Route::get('/view/{id}', "Admin\Meals@view");
         Route::get('/stop/{id}', "Admin\Meals@stop");
        Route::get('/publish/{id}', "Admin\Meals@publish");
    });

   Route::group(['prefix' => 'offers', 'middleware' => 'can:offers'], function () {             
        Route::get('/list/{status}', "Admin\Offers@index");
        Route::get('/add', "Admin\Offers@get_add");
        Route::post('/store', "Admin\Offers@post_add");
        Route::get('/edit/{id}', "Admin\Offers@get_edit");
        Route::post('/update/{id}', "Admin\Offers@post_edit");
        Route::get('/delete/{id}', "Admin\Offers@delete");
        Route::get('/view/{id}', "Admin\Offers@view");
        Route::get('/reorder', "Admin\Offers@reorder");
        Route::post('/reorder', "Admin\Offers@saveReorder");

    });

   Route::group(['prefix' => 'orders', 'middleware' => 'can:orders'], function () {                  
        Route::get('/', "Admin\Orders@index");
        Route::get('/add', "Admin\Orders@get_add");
        Route::post('/store', "Admin\Orders@post_add");
        Route::get('/edit/{id}', "Admin\Orders@get_edit");
        Route::post('/update/{id}', "Admin\Orders@post_edit");
        Route::get('/delete/{id}', "Admin\Orders@delete");
        Route::get('/view/{id}', "Admin\Orders@view");
        Route::get('/details/{id}', "Admin\Orders@details");
    });

    Route::prefix('/customers')->group(function(){
         Route::get('/{status}', "Admin\Customers@index");
        Route::get('/view/{id}', "Admin\Customers@view");
        Route::get('/edit/{id}', "Admin\Customers@get_edit");
        Route::post('/update/{id}', "Admin\Customers@post_edit");
        Route::post('/change-password/{id}', "Admin\Customers@post_changePassword");
         
       // Route::get('/add', "Admin\Orders@get_add");
       // Route::post('/store', "Admin\Orders@post_add");
       // Route::get('/edit/{id}', "Admin\Orders@get_edit");
        
        Route::get('/delete/{id}', "Admin\Orders@delete");
        
         Route::get('/details/{id}', "Admin\Orders@details");
        
    });

      Route::group(['prefix' => 'providers', 'middleware' => 'can:providers'], function () {                
        Route::get('/{status}', "Admin\Providers@index");
        Route::get('/add', "Admin\Providers@get_add");
        Route::post('/store', "Admin\Providers@post_add");
        Route::get('/edit/{id}', "Admin\Providers@get_edit");
        Route::post('/update/{id}', "Admin\Providers@post_edit");
        Route::post('/profile/edit-image/{id}', "Admin\Providers@edit_logo");
        Route::get('/profile/change_meal_type/{id}', "Admin\Providers@change_meal_type");
        Route::post('/profile/change_meal_type/{id}', "Admin\Providers@post_change_meal_type");
        Route::get('/approved/{id}', "Admin\Providers@approve");
        Route::get('/deactivate/{id}', "Admin\Providers@deactivate");
        Route::get("/view/{id}" , "Admin\Providers@view");
        Route::get("/change-subscription/{id}" , "Admin\Providers@change_subscription");
        Route::post("/change-subscription" , "Admin\Providers@post_change_subscription");
        
      

    });

      Route::group(['prefix' => 'reservations', 'middleware' => 'can:reservations'], function () {
        Route::get('/', "Admin\booking@index");
    });

    Route::prefix('/branches')->group(function(){
        Route::get('/view/{id}', "Admin\Branch@view");
        Route::get('/comments/stop/{id}', "Admin\Branch@stop_comment");
        Route::get('/comments/play/{id}', "Admin\Branch@play_comment");
    });

    Route::group(['prefix' => 'withdraws', 'middleware' => 'can:withdraws'], function () {     
        Route::get('/', "Admin\Withdraw_balance@index");
        Route::get('/accept/{id}', "Admin\Withdraw_balance@accept");
    });

   Route::group(['prefix' => 'settings', 'middleware' => 'can:settings'], function () {          
        Route::get('/', "Admin\Settings@index");
        Route::post('/store', "Admin\Settings@post_add");
    });

    Route::group(['prefix' => 'tickets', 'middleware' => 'can:tickets'], function () {               
        Route::get('/{type}', "Admin\Tickets@index");
        Route::get('/reply/{id}', "Admin\Tickets@get_reply");
        Route::post('/reply', "Admin\Tickets@post_reply");
    });

  Route::group(['prefix' => 'notifications', 'middleware' => 'can:notifications'], function () {                     
        Route::get('/list/{type}', "Admin\Notifications@index");
        Route::get("/add/{type}" , "Admin\Notifications@get_add");
        Route::post("/store" , "Admin\Notifications@post_add");
        Route::get('/delete/{id}', "Admin\Notifications@delete");
    });

    Route::group(['prefix' => 'comments', 'middleware' => 'can:comments'], function () {     
        Route::get('/list', "Admin\Comments@index");
    });

});

Route::middleware([])->prefix('admin')->group(function(){
    Route::get("/login" , "Admin\Login@get_login") -> name('admin.login');
    Route::post("/login" , "Admin\Login@post_login");
    Route::get("/logout" , "Admin\Login@logout");
});



