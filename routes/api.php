<?php

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\Auth;

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


/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/



// Users
Route::get('/test','TestController@test');
Route::post('/test','TestController@testpost');


// User
Route::post('/user/register','UserController@register');
Route::post('/user/login','UserController@login');
Route::get('/user/{uid}','UserController@getUser');
Route::post('/user/editProfile/{uid}','UserController@editUser');
Route::post('/user/find','UserController@findCompany');


// Offer
Route::post('/offer/register/{uid}','OfferController@registerOffer');
Route::post('/offer/find','OfferController@findOffer');
Route::post('/offer/apply/{offerId}/{uid}','OfferController@applyOffer');
Route::get('/offer/applied/{uid}','OfferController@getAppliedOffers');

// Skill
Route::get('/skill','SkillController@findSkills');
Route::post('/skillapply/{skillId}/{uid}','SkillController@applySkill');
Route::get('/skill/applied/{uid}','SkillController@getApplySkills');






// Ejemplo con params
// Route::get('/loginU/{email}/{password}','UsuarioController@getLoginU');



