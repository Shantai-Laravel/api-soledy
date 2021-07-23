<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\CallRequestMail;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialLoginController;

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

Route::post('/mail/acceptPolicies', [MailController::class, 'acceptPolicies']);
Route::get('/login/{service}', [SocialLoginController::class, 'redirect']);
Route::get('/login/{service}/callback', [SocialLoginController::class, 'callback']);
Route::get('/login/cancel', [SocialLoginController::class, 'cancel']);

Route::get('/auth-user', [SocialLoginController::class, 'getAuthUser']);

// Route::group(['middleware' => 'cors'], function(){
    // Route::get('/auth-user', [SocialLoginController::class, 'getAuthUser']);
    // Route::any('mail/acceptPolicies', [MailController::class, 'acceptPolicies']);
// });

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/test', function() {
        dd('test auth');
    });
});
