<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageApiController;
use App\Http\Controllers\OfferWallTest;
use App\Http\Controllers\S2SController;
use App\Http\Controllers\TournamentController;

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

Route::post('check', [UserController::class, 'check_user']);
Route::post('get_user', [UserController::class, 'get_user']);
Route::post('new_image', [ImageApiController::class, 'new_image']);
Route::post('offers', [UserController::class, 'ApiOffers']);
Route::post('in_offers', [UserController::class, 'in_ApiOffers']);
Route::post('daily', [UserController::class, 'daily_bonus']);
Route::post('trans', [UserController::class, 'trans']);
Route::post('btc', [UserController::class, 'btc']);
Route::post('reward', [UserController::class, 'reward']);
//Route::post('redeem', [UserController::class, 'redeem']);
Route::post('start_offer', [UserController::class, 'start_offer']);
Route::get('test_offers', [OfferWallTest::class, 'index']);
//s2s APIs
Route::get('adjoe', [S2SController::class, 'adjoe']);
Route::get('s2s_is', [S2SController::class, 'is']);
Route::get('adgem', [S2SController::class, 'adgem']);
Route::get('tapjoy', [S2SController::class, 'tapjoy']);
Route::get('pollfish', [S2SController::class, 'pollfish']);
Route::get('cpalead', [S2SController::class, 'cpalead']);
Route::get('offertoro', [S2SController::class, 'offertoro']);
Route::get('adget', [S2SController::class, 'adget']);

//tournaments
Route::post('live_t', [TournamentController::class, 'live_tournaments']);
Route::post('score', [TournamentController::class, 'add_score']);
Route::post('three', [TournamentController::class, 'top_three']);
Route::post('top', [TournamentController::class, 'top_players']);
Route::get('test', [TournamentController::class, 'test']);
//redeem
Route::post('reward', [UserController::class, 'reward_']);
Route::post('redeem', [UserController::class, 'redeem_']);
Route::post('user_h', [UserController::class, 'user_h']);
//leaderboard
Route::post('leaders', [UserController::class, 'leaders']);
//coins
Route::post('add', [UserController::class, 'add']);
Route::post('deduct', [UserController::class, 'deduct']);
Route::post('add_points', [UserController::class, 'add_points']);
//spin
Route::post('check_spin', [UserController::class, 'check_spin']);
//scratch
Route::post('scratch', [UserController::class, 'check_scratch']);

Route::post('daily_b', [UserController::class, 'daily']);
Route::post('games', [UserController::class, 'games']);
Route::post('home', [UserController::class, 'home_data']);
Route::post('visits', [UserController::class, 'visits']);
Route::post('offers', [UserController::class, 'offers']);
Route::post('refer_t', [UserController::class, 'refer_task']);
Route::post('noti', [UserController::class, 'noti']);
Route::post('update_p', [UserController::class, 'update_profile']);
Route::post('bu', [UserController::class, 'bu']);
Route::post('ads', [UserController::class, 'ads']);
Route::post('up_pro', [UserController::class, 'up_pro']);
Route::post('ag', [UserController::class, 'ag']);
Route::post('delete', [UserController::class, 'delete']);

Route::get('test__', [UserController::class, 'test__']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
