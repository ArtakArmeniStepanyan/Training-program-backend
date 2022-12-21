<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\GalleryFoldersController;


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
Route::delete('/remove-image/{id}', UserController::class . '@removeImage');
Route::get('/users/{id}', UserController::class . '@getAllUsers');
Route::get('/users', UserController::class . '@getAllUsersForGuest');
Route::get('/user/{id}', UserController::class . '@getUser');

Route::post('/add-to-friend', FriendsController::class . '@addToFriend');
Route::post('/remove-from-friend', FriendsController::class . '@removeFromFriend');
Route::post('/is-friend', FriendsController::class . '@isFriend');
Route::get('/friends/{id}', FriendsController::class . '@getFriends');


Route::post('/add-todo', TodosController::class . '@addTodo');
Route::get('/get-todos/{id}', TodosController::class . '@getTodos');
Route::get('/clear-completed/{id}', TodosController::class . '@clearCompleted');
Route::post('/change-todo-status', TodosController::class . '@changeTodoStatus');
Route::post('/delete-todo', TodosController::class . '@deleteTodo');

Route::post('/create-folder', GalleryFoldersController::class . '@createFolder');
Route::get('/get-folders/{id}', GalleryFoldersController::class . '@getUserFolders');
Route::get('/get-current-folder/{id}', GalleryFoldersController::class . '@getCurrentFolder');
Route::get('/get-current-images/{id}', GalleryFoldersController::class . '@getCurrentImages');
Route::get('/delete-folder/{id}', GalleryFoldersController::class . '@deleteFolder');
Route::get('/delete-image/{id}', GalleryFoldersController::class . '@deleteImage');
Route::post('/save-image', GalleryFoldersController::class . '@saveImage');

