<?php

use Dingo\Api\Routing\Router;

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

Route::get('index', 'ClientController@getAll');
Route::get('client/hall', 'ClientController@getClientHall');
Route::post('addTicket', 'ClientController@addTicket');
Route::get('getTicket', 'ClientController@getTicket');
Route::post('updateTicket', 'ClientController@updateTicket');
Route::get('oauth', 'AdminController@getClient');



// Create Dingo Router
$api = app(Router::class);

// Create a Dingo Version Group
$api->version('v1', ['middleware' => 'api'], function ($api) {
    $api->group(['prefix' => 'auth'], function ($api) {
        $api->post('register', [
            'as' => 'register',
            'uses' => 'App\\Api\\V1\\Controllers\\RegisterController@register',
        ]);

        $api->post('login', [
            'as' => 'login',
            'uses' => 'Laravel\\Passport\\Http\\Controllers\\AccessTokenController@issueToken',
        ]);

        $api->get('logout', [
            'middleware' => 'auth:api',
            'as' => 'logout',
            'uses' => 'App\\Api\\V1\\Controllers\\LogoutController@logout',
        ]);

        $api->post('recovery', [
            'as' => 'password.email',
            'uses' => 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail',
        ]);
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');
    });

    // Protected routes
    $api->group(['middleware' => 'auth:api'], function ($api) {
        $api->get('protected', function () {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.',
            ]);
        });
      

        $api->get('users', [
            'as' => 'users.index',
            'uses' => 'App\\Api\\V1\\Controllers\\UserController@index',
        ]);

        $api->get('users/{user}', [
            'as' => 'users.show',
            'uses' => 'App\\Api\\V1\\Controllers\\UserController@show',
        ]);

        $api->get('users', [
            'as' => 'users.index',
            'uses' => 'App\\Api\\V1\\Controllers\\UserController@index',
        ]);

        $api->get('users/{user}', [
            'as' => 'users.show',
            'uses' => 'App\\Api\\V1\\Controllers\\UserController@show',
        ]);

        $api->post('createHall', [
            'as' => 'admin.createHall',
            'uses' => 'App\\Http\\Controllers\\AdminController@createHall',
        ]);

        $api->post('deleteHall', [
            'as' => 'admin.deleteHall',
            'uses' => 'App\\Http\\Controllers\\AdminController@deleteHall',
        ]);


        $api->post('updateHall', [
            'as' => 'admin.updateHall',
            'uses' => 'App\\Http\\Controllers\\AdminController@updateHall',
        ]);

        $api->post('updatePricesHall', [
            'as' => 'admin.updatePricesHall',
            'uses' => 'App\\Http\\Controllers\\AdminController@updatePricesHall',
        ]);

        $api->post('addFilm', [
            'as' => 'admin.addFilm',
            'uses' => 'App\\Http\\Controllers\\AdminController@addFilm',
        ]);

        $api->post('deleteFilm', [
            'as' => 'admin.deleteFilm',
            'uses' => 'App\\Http\\Controllers\\AdminController@deleteFilm',
        ]);

         $api->post('updateFilm', [
            'as' => 'admin.updateFilm',
            'uses' => 'App\\Http\\Controllers\\AdminController@updateFilm',
        ]); 

       

        $api->post('addSeances', [
            'as' => 'admin.addSeances',
            'uses' => 'App\\Http\\Controllers\\AdminController@addSeances',
        ]);

        $api->post('removeSeances', [
            'as' => 'admin.removeSeances',
            'uses' => 'App\\Http\\Controllers\\AdminController@removeSeances',
        ]);
        
        $api->post('openSale', [
        'as' => 'admin.openSale',
        'uses' => 'App\\Http\\Controllers\\AdminController@openSale',
    ]);
        
       
    });
    
});
