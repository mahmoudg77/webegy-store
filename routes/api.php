<?php
use Illuminate\Http\Request;

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

//middleware('auth:api')->
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: X-APP-KEY,Content-Type,X-TOKEN');
header('Access-Control-Allow-Credentials: true');


// if (in_array(request()->segment(2), config('translatable.locales'))) {
//     App::setLocale(request()->segment(2));
// }else{
//      try{
//          App::setLocale(\App\Models\Setting::getIfExists('site_lang'));
//      }catch(Exception $ex){
//          App::setLocale('en');
//      }
// }
//dd(app()->getLocale());
  //'prefix' => app()->getLocale()

    //  Route::get("/sms","API\SMSController@send");
Route::group(['prefix' => '/','middleware'=>'Api'], function()
{
    // Route::get('/user', function ($lang,Request $request) {
    //     return $request->user();
    // });
    // Route::middleware('auth:api')->get('/users', function ($lang,Request $request) {
    //     //app()->setLocale($lang);
    //     return App\User::all();
    // });
    
    Route::get("/category","API\CategoryController@all");
    //Route::get("/category/home","API\CategoryController@home");
    
    //Route::get("/countries/{id}/cities","API\LookupController@getCities")->where('id', '[0-9]+');
    //Route::get("/countries","API\LookupController@getCountries");
 
 Route::get("/category/{slug}/child","API\CategoryController@chieldsBySlug")->where('slug', '[A-Za-z,\-]+');
   
    //Route::get("/category/{id}","API\CategoryController@get")->where('id', '[0-9]+');
    //Route::get("/category/{id}/child","API\CategoryController@chields")->where('id', '[0-9]+');

    //Route::get("/posttype/{id}/posts","API\PostsController@getPostsByType")
     //   ->where('id', '[0-9]+');
    //Route::get("/posttype/{type}/posts","API\PostsController@getPostsByTypeName")
     //   ->where('type', '[A-Za-z]+');
    
    Route::post("/post/rate","API\RateController@rate");
    
    //Route::get("/post/{id}","API\PostsController@getPostByID")->where('id', '[0-9]+');
    Route::get("/post/{slug}","API\PostsController@getPostBySlug")->where('type', '[A-Za-z]+');
    Route::get("/category/{slug}/posts","API\PostsController@getPostByCatSlug")->where('slug', '[A-Za-z,\-]+');
    Route::get("/category/{slug}/top-rates","API\PostsController@topRatesByCatSlug")->where('slug', '[A-Za-z,\-]+');
    //Route::get("/category/{id}/posts","API\PostsController@getPostByCatID")->where('id', '[0-9]+');
    //Route::get("/category/{id}/videos","API\TalentController@getVideosByCatID")->where('id', '[0-9]+');
    Route::post("/contact-us","API\ContactController@send");
    //Route::post('/user/login',"API\LoginController@login");


//Route::get('/talent',"API\TalentController@all");
    Route::get('/setting/group-{key}',"API\SettingController@group");
    //Route::get('/setting/{key}',"API\SettingController@get");
    //Route::get('/setting',"API\SettingController@all");
    //Route::get('/talent/{id}',"API\TalentController@get");
    //Route::get('/profile/{id}',"API\ProfileController@getProfile")->where('id', '[0-9]+');
    /*
    Route::group(['middleware'=>'authapi'],function(){
        Route::get("/user/otp","API\RegisterController@sendOTPCode");
        Route::get('/user/verify-mobile/{code}', "API\RegisterController@verifyMobile");
        Route::get('/user/logout',"API\LoginController@logout");
        Route::post('/user/check',"API\LoginController@check");
        Route::post('/user/saveNewToken',"API\LoginController@saveNewToken");
        Route::get('/profile/me',"API\ProfileController@myProfile");
        Route::post('/image/upload',"API\ImageController@upload");
        Route::post('/profile/uploadImage',"API\ProfileController@uploadPersonalImage");
        // Route::group(['middleware'=>'verifiedapi:activeapi'],function(){
            Route::post('/talent/upload',"API\TalentController@upload");
        //     Route::post('/talent/status',"API\TalentController@status");
        // });
    });

    Route::post("/user/register","API\RegisterController@register");
    */
    //Route::post("/verify-phone","API\RegisterController@register");
    // Route::post("/resend-code","API\RegisterController@register");
    //Route::post("/check","API\RegisterController@check");
});
