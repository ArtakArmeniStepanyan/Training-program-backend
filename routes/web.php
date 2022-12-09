<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendsController;


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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', LogController::class . '@login');
Route::delete('/login/{id}', LogController::class . '@logout');

Route::get('/login/{token}', LogController::class . '@getUser');

Route::get('/check-mail-origin/{email}', UserController::class . '@checkOriginEmail');
Route::post('/check-mail-origin', UserController::class . '@checkOriginEmailWithRegisteredUser');



Route::post('/registration', UserController::class . '@registration');
Route::post('/edit-profile', UserController::class . '@editProfile');

Route::post('/edit-pass', UserController::class . '@editPass');

Route::post('/add-to-friend', FriendsController::class . '@addToFriend');
Route::post('/remove-from-friend', FriendsController::class . '@removeFromFriend');
Route::post('/is-friend', FriendsController::class . '@isFriend');

Route::delete('/remove-image/{id}', UserController::class . '@removeImage');

Route::get('/users/{id}', UserController::class . '@getAllUsers');
Route::get('/users', UserController::class . '@getAllUsersForGuest');
Route::get('/user/{id}', UserController::class . '@getUser');
Route::get('/friend/{id}', FriendsController::class . '@getFriends');
