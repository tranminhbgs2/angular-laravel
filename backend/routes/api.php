<?php


Route::group([

    'middleware' => 'api',

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('sendpasswordreset', 'ResetPasswordController@sendEmail');
    Route::post('resetpassword', 'ChangePasswordController@process');
    Route::get('role/{token}', 'AuthController@respondWithToken');
    //product
    Route::apiResource('/products','ProductController');
    //Ticket
    Route::apiResource('/ticket','TicketsController');
    //Ticket
    Route::apiResource('/ticket-detail','TicketDetailController');
    //Category
    Route::apiResource('/categories','CategoriesController');
    //Customer
    Route::apiResource('/user', 'UserController');
    // upload file product
    Route::post('upload/{slug}', 'ProductController@upfile');
    //sách liên quan
    Route::get('booksame/{cate_id}', 'ProductController@booksame');
    // upload file user
    Route::post('uploadUser/{slug}', 'UserController@uploadfile');
    //profile user
    Route::get('profile', function (){
        return auth()->user();
    });
    // show product Ticket
    Route::get('detail-ticket/{id}', 'ProductController@showTicket');
//Review
    Route::group(['prefix'=>'products'],function (){
        Route::apiResource('/{product}/reviews','ReviewController');
    });
    //Customer
//    Route::group(['prefix' => 'customer'], function (){
//        Route::post('signup', 'CustomerController@signup');
//        Route::post('login', 'CustomerController@login');
//        Route::post('logout', 'CustomerController@logout');
//        Route::post('refresh', 'CustomerController@refresh');
//        Route::post('me', 'CustomerController@me');
//        Route::post('sendpasswordreset', 'ResetPasswordController@sendEmail');
//        Route::post('resetpassword', 'ChangePasswordController@process');
//    });
    Route::fallback(function(){
        return response()->json([
            'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
    });
});

