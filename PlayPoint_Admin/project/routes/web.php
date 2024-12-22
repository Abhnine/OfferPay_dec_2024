<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/refer/{refer_id}','UserController@refer')->name('refer');

Route::get('/data-delete','Admin\HomeController@account_deletion')->name('account_deletion');

Route::get('/', 'Admin\HomeController@login')->middleware('guest:admin');

//pages
Route::get('/page/{slug}', 'Admin\HomeController@web_pages')->name('web_pages');

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){
Route::namespace('Auth')->middleware('guest:admin')->group(function(){
Route::post('login','AuthenticatedSessionController@store')->name('adminlogin');
});

Route::get('/', 'HomeController@main')->middleware('guest:admin');

Route::middleware('admin')->group(function(){

Route::get('license', 'HomeController@license')->name('license');
Route::post('license', 'HomeController@activate')->name('license_post');

Route::get('dashboard','HomeController@index')->name('dashboard')->middleware('csmdev');
Route::post('/dashboard','HomeController@watch_video_points');
//Games
Route::get('/games','HomeController@games')->name('games')->middleware('csmdev');
Route::get('/edit/game/{id}','HomeController@edit_game')->name('edit_game')->middleware('csmdev');
Route::put('/edit/game/{id}','HomeController@update_game');
Route::get('/add/game','HomeController@add_game')->name('csm_add_game')->middleware('csmdev');
Route::post('/add/game','HomeController@post_game');
Route::get('delete-game/{id}','HomeController@csm_delete_game')->name('csm_delete_game');
//visit web
Route::get('/visit','HomeController@visit')->name('visit')->middleware('csmdev');
Route::get('/edit/visit/{id}','HomeController@edit_visit')->name('edit_visit')->middleware('csmdev');
Route::put('/edit/visit/{id}','HomeController@update_visit');
Route::get('/add/visit','HomeController@add_visit')->name('csm_add_visit')->middleware('csmdev');
Route::post('/add/visit','HomeController@post_visit');
Route::get('delete-visit/{id}','HomeController@csm_delete_visit')->name('csm_delete_visit');
//Refer Tasks
Route::get('/refer','HomeController@refer')->name('refer')->middleware('csmdev');
Route::get('/edit/refer/{id}','HomeController@edit_refer')->name('edit_refer')->middleware('csmdev');
Route::put('/edit/refer/{id}','HomeController@update_refer');
Route::get('/add/refer','HomeController@add_refer')->name('csm_add_refer')->middleware('csmdev');
Route::post('/add/refer','HomeController@post_refer');
Route::get('delete-refer/{id}','HomeController@csm_delete_refer')->name('csm_delete_refer');
//Offerwalls
Route::get('/offerwalls','HomeController@offerwalls')->name('offerwalls')->middleware('csmdev');
Route::get('/edit/offerwall/{id}','HomeController@edit_offerwalls')->name('edit_offerwalls')->middleware('csmdev');
Route::put('/edit/offerwall/{id}','HomeController@update_offerwall');
//ads & videos
Route::get('/ads','HomeController@ads')->name('ads')->middleware('csmdev');
Route::get('/edit/ads/{id}','HomeController@edit_ads')->name('edit_ads')->middleware('csmdev');
Route::put('/edit/ads/{id}','HomeController@update_ads');
//settings
Route::get('/settings','HomeController@settings')->name('settings')->middleware('csmdev');
Route::get('/settings/fraud-prevention','HomeController@fraud_prevention_settings')->name('fraud_prevention')->middleware('csmdev');
Route::get('/app/settings','HomeController@csm_app_settings')->name('csm_app_settings')->middleware('csmdev');
Route::post('/settings','HomeController@update_settings')->name('up_settings');
Route::post('/app-settings','HomeController@update_app_settings')->name('up_app_settings');
Route::post('/up_daily_streak_settings','HomeController@up_daily_streak_settings')->name('up_daily_streak_settings');
Route::post('/up_fraud_prevention','HomeController@up_fraud_prevention')->name('up_fraud_prevention');
Route::post('/app_mode','HomeController@app_mode')->name('app_mode');
Route::post('/app/settings','HomeController@up_app_settings')->name('up_app_settings');
//redeem requests
Route::get('/redeem-requests','HomeController@redeem')->name('redeem')->middleware('csmdev');
Route::get('/withdrawal/request-view/{id}','HomeController@request_view')->name('with_reqs_up');
Route::put('/withdrawal/request-view/{id}','HomeController@update_request_view');
Route::get('/redeem/status/{id}','HomeController@redeem_status')->name('redeem_status')->middleware('csmdev');
//redeem methods
Route::get('/redeem-methods','HomeController@redeem_methods')->name('redeem_methods')->middleware('csmdev');
Route::get('/edit/redeem-method/{id}','HomeController@edit_rm')->name('edit_rm')->middleware('csmdev');
Route::put('/edit/redeem-method/{id}','HomeController@update_rm');
Route::get('/edit/redeem-amounts/{id}','HomeController@edit_rm_amounts')->name('edit_rm_amounts')->middleware('csmdev');
Route::post('/edit/redeem-amounts/{id}','HomeController@create_rm_amounts');
Route::get('/delete-amounts/{id}','HomeController@delete_rm_amounts')->name('delete_rm_amounts')->middleware('csmdev');
Route::get('/delete-redeem/{id}','HomeController@delete_rm')->name('delete_rm')->middleware('csmdev');
Route::get('/add/redeem-method','HomeController@add_rm_method')->name('add_rm_method')->middleware('csmdev');
Route::post('/add/redeem-method','HomeController@create_rm_method');
//trckers
Route::get('/tracker','HomeController@tracker')->name('tracker')->middleware('csmdev');
Route::get('/tracker/{id}','HomeController@tracker_u')->name('trackeru')->middleware('csmdev');
//Postbacks
Route::get('/postbacks','HomeController@postbacks')->name('postbacks')->middleware('csmdev');
//add banners
Route::get('/banners','HomeController@csm_banners')->name('csm_banners');
Route::post('/banners','HomeController@banners_add')->name('add-banners');
Route::get('delete-banners/{id}','HomeController@csm_delete_banners')->name('csm_delete_banners');
Route::get('banners-status/{id}/{id2}','HomeController@csm_status_banners')->name('csm_status_banners');
//send notifications
Route::get('/notification','HomeController@csm_noti')->name('csm_noti');
Route::post('/push','HomeController@push')->name('push');
Route::get('/send','HomeController@push')->middleware('csmdev');
Route::get('delete-noti/{id}','HomeController@csm_delete_noti')->name('csm_delete_noti');
//users routes
Route::get('users','HomeController@users')->name('users')->middleware('csmdev');
Route::get('user/search/{data}','HomeController@users_search')->name('users_search')->middleware('csmdev');
Route::get('/edit/user/{id}','HomeController@edit_user')->name('useredit')->middleware('csmdev');
Route::put('/edit/user/{id}','HomeController@update_user');
Route::get('user-status/{id}/{id2}','HomeController@csm_status_user')->name('csm_status_user');
Route::get('user/delete/{id}','HomeController@admin_del_user')->name('del_user');
//users routes
Route::get('referrals','HomeController@t_referrals')->name('t_referrals')->middleware('csmdev');

//files
Route::get('resources', 'HomeController@file_resources')->name('file_resources')->middleware('csmdev');
Route::get('del-resources-file/{name}','HomeController@delete_file_resources')->name('del_file_resources')->middleware('csmdev');

//pages
Route::get('/pages','HomeController@pages')->name('pages');
Route::get('/edit/page/{id}','HomeController@edit_page')->name('pageedit');
Route::put('/edit/page/{id}','HomeController@update_page');

Route::get('users/delete/requests','HomeController@usersdel_requests')->name('usersdel_requests')->middleware('csmdev');
Route::get('user/delete/request/{email}/{id}','HomeController@delete_user_req')->name('delete_user_req');

});
Route::get('login','HomeController@login')->name('login');
Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});






