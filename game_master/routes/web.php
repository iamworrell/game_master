<?php

use Illuminate\Support\Facades\Route;
//Hook up controller logic to the routes
use App\Http\Controllers\UserController;

Route::get('/welcome', function () {
    return view('welcome');
});

//Hook up the function in the controller to this specific route
Route::get('/game-master/user/sign-up', [UserController::class, 'userSignUp']);

Route::get('/game-master/login', [UserController::class, 'userLoginPage']);
Route::get('/', [UserController::class, 'landing']);

//use wildcard to pull data from database
Route::get('/user/homepage/{uuid}', [UserController::class, 'userHomePage'])->name('user.home');

Route::get('/user/play/{uuid}', [UserController::class, 'playPage']);
Route::get('/user/{uuid}/select-starter-card', [UserController::class, 'selectStarterCards']);
Route::get('/user/{uuid}/battle/', [UserController::class, 'battlePage']);
Route::get('/user/deck-manager/{uuid}', [UserController::class, 'deckManager']);

Route::get('/logout', [UserController::class, 'logout'])->name('game.logout');

//Post Request for Creating and Adding Users to the Database
Route::post('/users', [UserController::class, 'createUser']);

Route::post('/login', [UserController::class, 'loginUser'])->name('game.login');


Route::post('/user/{uuid}/select-starter-card', [UserController::class, 'submitSelectedCards']);

//Update user deck - remove card
Route::post('/cards/remove/', [UserController::class, 'removeCardFromHand'])->name('cards.remove');