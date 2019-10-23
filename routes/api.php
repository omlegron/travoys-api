<?php

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

Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');


Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
Route::get('email/check', 'VerificationController@check')->name('verification.check');

Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset')->middleware('web');
Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', 'LoginController@logout');
});

Route::get('radio/statistic', 'LiveRadioVisitorController@statistic');
Route::get('radio/increment', 'LiveRadioVisitorController@increment');
Route::get('radio/decrement', 'LiveRadioVisitorController@decrement');
Route::group(['namespace' => 'Api'], function () {
    Route::get('qr_code/encrypt/{user_id}','QRCodeController@encrypt');
    Route::get('qr_code/decrypt/{string}','QRCodeController@decrypt');
    Route::get('qr_code/image/{user_id}','QRCodeController@getQR');

});
Route::middleware(['verified'])->group(function () {
    Route::resource('banners', 'BannerController');
    Route::put('banners/{banner}/status', 'BannerController@changeStatus');

    Route::get('check-in-history', 'CheckInController@checkInHistory');

    Route::resource('posts', 'PostController');
    Route::resource('posts.comments', 'CommentController');

    Route::get('predictions/by-date', 'PredictionController@getByDate');
    Route::get('predictions/by-time', 'PredictionController@getByTime');

    Route::get('profiles/{id}', 'ProfileController@show')->where('id', '[0-9]+');
    Route::get('profiles/me', 'ProfileController@myProfile');
    Route::put('profiles/update/avatar', 'ProfileController@updateAvatar');
    Route::put('profiles/update/name', 'ProfileController@updateName');
    Route::put('profiles/update/email', 'ProfileController@updateEmail');
    Route::put('profiles/update/phone', 'ProfileController@updatePhone');

    Route::post('rest-areas/{rest_area}/check-in', 'CheckInController@checkIn');
    Route::post('rest-areas/{rest_area}/check-out', 'CheckInController@checkOut');

    Route::get('rest-areas/{rest_area}/parking/slots', 'ParkingSlotController@show');
    Route::get('rest-areas/{rest_area}/parking/status', 'ParkingSlotController@status');
    Route::post('rest-areas/{rest_area}/parking/status', 'ParkingSlotController@changeStatus');
    Route::post('rest-areas/{rest_area}/parking/in', 'ParkingSlotController@increaseUsedSlots');
    Route::post('rest-areas/{rest_area}/parking/out', 'ParkingSlotController@decreaseUsedSlots');

    Route::get('rest-areas/{rest_area}/fuel/status', 'FuelController@show');
    Route::post('rest-areas/{rest_area}/fuel/status', 'FuelController@changeStatus');

    Route::get('rest-areas/recap', 'RecapController@export');

    Route::post('places/nearby', 'PlaceController@indexNearby');
    Route::apiResource('places/categories', 'PlaceCategoryController');
    Route::apiResource('places', 'PlaceController');

    Route::post('cities/nearby', 'CityController@indexNearby');
    Route::apiResource('cities', 'CityController');
    Route::apiResource('cities.places', 'CityPlaceController');

    Route::get('vouchers/{voucher}/redeem', 'VoucherController@redeem');
    Route::apiResource('vouchers', 'VoucherController');
    Route::apiResource('vouchers.codes', 'VoucherCodeController');

    Route::get('feedback/mine', 'FeedbackController@indexMine');
    Route::apiResource('feedback', 'FeedbackController');
    Route::apiResource('feedback-categories', 'FeedbackCategoryController');

    Route::get('trav-points/accounts', 'TravPointController@account');
    Route::post('trav-points/referral', 'TravPointController@setReferral');

    Route::get('notifications', 'NotificationController@index');

    Route::get('trip-plans/demography/age', 'TripPlanDemographyController@age');

    Route::apiResource('toll-gates', 'TollGateController');

    Route::group(['namespace' => 'Api'], function () {
        Route::resource('vehicle-classes', 'VehicleClassController');
        Route::resource('trip-plans', 'TripPlanController');
        Route::resource('highways', 'HighwayController');
        Route::resource('highways.rest-areas', 'HighwayRestAreaController');

        Route::post('rest-areas/nearby', 'RestAreaController@indexNearby');
        Route::resource('rest-areas', 'RestAreaController');
        Route::apiResource('rest-areas.places', 'RestAreaPlaceController');
        Route::resource('rest-areas.eateries', 'EateryController');
        Route::get('eatery-orders/satgas', 'EateryOrderController@indexSatgas');
        Route::resource('eatery-orders', 'EateryOrderController');
        Route::patch('eatery-orders/{id}/status', 'EateryOrderController@UpdateStatus');
        Route::get('eatery-orders-recent', 'EateryOrderController@recent');
    });

    Route::group(['namespace' => 'Api'], function () {
        Route::resource('vehicle-classes', 'VehicleClassController');

    });
});
