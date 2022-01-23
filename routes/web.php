<?php


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

if (in_array(Request::segment(1), config('translatable.locales'))) {
    App::setLocale(Request::segment(1));

} else {

    try {
       App::setLocale(\App\Models\Setting::getIfExists('site_lang'));
    }catch(Exception $ex) {
        App::setLocale('en');
    }
}
Route::get('/',function(){
    return response()->redirectTo("/".App::setLocale(\App\Models\Setting::getIfExists('site_lang')));
});
Route::group(['prefix' => app()->getLocale()], function() {

/*Route::get('/rate-relocate',function(){
    foreach (\App\Models\PostRate::whereNull('country')->get() as $rateRec){
        //$rateRec->rate=$rate;
        //$rateRec->post_id=$post->id;
         //$location=geoip()->getLocation($ip);
        $location = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$rateRec->ip));    
        $rateRec->country=$location->geoplugin_countryName;
        $rateRec->city=$location->geoplugin_city;
        $rateRec->region=$location->geoplugin_region;
        $rateRec->country_code=$location->geoplugin_countryCode;
        
        $rateRec->longitude=$location->geoplugin_longitude;
        $rateRec->latitude=$location->geoplugin_latitude;
        
        //return json_encode($location);
        //PostRate::create(['rate'=>$rate,'post_id'=>$postid,'ip'=>$ip]);
        $rateRec->save();
    }
    return Func::success("save success");
});
*/
    Route::get('/imgs/{model}/{model_id}/{mode}/{size}/{model_tag}-{index}.png', 'Front\ImageController@item')->name('images');

    Route::post('/translate', 'Front\GTranslateController@index');

    //Auth::routes();
    // Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('authenticated');
//Route::post('register', 'Auth\RegisterController@register')->middleware('authenticated');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//Share Improve this answer Follow
     //Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
     //Route::post('/login', 'Auth\LoginController@login');
     //Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/lang', 'Front\LanguageController@index')->name('swichlang');

    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'AccessDashboard','ViewFilter']], function() {
        #Dashboard Routes
        Route::post('/post-image-delete','Dashboard\MediaFileController@deleteImage');
        #DataTable Routes
        Route::post('/posts/datatable', 'Dashboard\PostController@dataTable')->name('cp.posts.datatable');
        Route::post('/user/datatable', 'Dashboard\UserController@dataTable')->name('cp.user.datatable');
        Route::resource('/city', 'Dashboard\CityController', ['as' => 'cp']);
        Route::get('/tags-recommend', 'Dashboard\TagController@getTags')->name('cp.get-tags');
        Route::get('/', 'Dashboard\DashboardController@index')->name('cp.dashboard');
        Route::resource('/posts', 'Dashboard\PostController', ['as' => 'cp']);
        Route::resource('/account-level', 'Dashboard\AccountLevelController', ['as' => 'cp']);
        Route::resource('/post-type', 'Dashboard\PostTypeController', ['as' => 'cp']);
        Route::resource('/category', 'Dashboard\CategoryController', ['as' => 'cp']);
        Route::resource('/file', 'Dashboard\FileController', ['as' => 'cp']);
        Route::resource('/media-file', 'Dashboard\MediaFileController', ['as' => 'cp']);
        Route::resource('/tag', 'Dashboard\TagController', ['as' => 'cp']);
        Route::resource('/user', 'Dashboard\UserController', ['as' => 'cp']);
        Route::resource('/menu', 'Dashboard\MenuController', ['as' => 'cp']);
        Route::resource('/menu-link', 'Dashboard\MenuLinkController', ['as' => 'cp']);
        
        Route::resource('/secgroup', 'Dashboard\SecGroup', ['as' => 'cp']);
        Route::resource('/secpermission', 'Dashboard\SecPermission', ['as' => 'cp']);
        
        //Route::resource('/setting', 'Dashboard\SettingController', ['as' => 'cp']);
        Route::get('/setting', 'Dashboard\SettingController@index')->name('cp.setting.index');
        Route::get('/setting/edit', 'Dashboard\SettingController@editGroup')->name('cp.setting.edit');
        Route::put('/setting/edit', 'Dashboard\SettingController@updateGroup')->name('cp.setting.update');
        Route::post('/post-slug', 'Dashboard\PostController@getFreeSlug')->name('cp.post-slug');
        Route::get('/locales', 'Dashboard\LocalesController@index')->name('cp.locales.index');
        Route::post('/locales', 'Dashboard\LocalesController@save')->name('cp.locales.store');
        Route::post('/post-unpublish', 'Dashboard\PostController@unpublish')->name('cp.post-unpublish');
        Route::post('/post-publish', 'Dashboard\PostController@publish')->name('cp.post-publish');
        Route::post('/area-unpublish', 'Dashboard\AreaController@unpublish')->name('cp.area-unpublish');
        Route::post('/area-publish', 'Dashboard\AreaController@publish')->name('cp.area-publish');
        Route::post('/delete-bulk', 'Dashboard\PostController@destroySelected')->name('cp.post-delete-bulk');
        Route::post('/publish-bulk', 'Dashboard\PostController@publishSelected')->name('cp.post-publish-bulk');
        Route::post('/unpublish-bulk', 'Dashboard\PostController@unpublishSelected')->name('cp.post-unpublish-bulk');
        Route::post('/move-bulk', 'Dashboard\PostController@moveSelected')->name('cp.post-move-bulk');
        Route::post('/secpermission-getactions', 'Dashboard\SecPermission@getActionsList')->name('cp.secpermission-getactions');
        Route::post('/secpermission-getfilter', 'Dashboard\SecPermission@getForceFilter')->name('cp.secpermission-getfilter');
        Route::post('/user-unpublish', 'Dashboard\UserController@unpublish')->name('cp.user-unpublish');
        Route::post('/user-publish', 'Dashboard\UserController@publish')->name('cp.user-publish');
        Route::post('/resendVerify', 'Dashboard\UserController@resendVerifyMail')->name('cp.resendVerify');
        Route::post('/languages/install', 'Dashboard\LanguagesController@install')->name('cp.languages.install');
        Route::post('/languages/uninstall', 'Dashboard\LanguagesController@uninstall')->name('cp.languages.uninstall');
        Route::get('/languages', 'Dashboard\LanguagesController@index')->name('cp.languages.index');
  
    });

    Route::get('/', 'Front\HomeController@index')->name('home');
    
    Route::get('/contact', 'Front\ContactUsController@index')->name('contact');
    Route::post('/contact', 'Front\ContactUsController@store')->name('contact.store');
    //Route::get('/{id}_pdf', 'Front\SingleController@viewPostFileByID')->name('viewPostFileByID');
    
    Route::get('/{id}', 'Front\SingleController@getPostByID')->where('id', '[0-9]+')->name('getPostByID');
     
    Route::get('/{slug}_pdf', 'Front\SingleController@viewPostFileBySlug')->name('viewPostFileBySlug');
  
    Route::get('/{slug}', 'Front\SingleController@getPostBySlug')->name('getPostBySlug');
     
    Route::get('/content/{slug}', 'Front\CategoryController@getConentBySlug')->name('getConentBySlug');
    Route::get('/cat/{slug}', 'Front\CategoryController@getPostsByCatSlug')->name('categoryBySlug');
    Route::get('/cat/{id}', 'Front\CategoryController@getPostsByCatID')->name('getPostsByCatID');
    Route::get('/tags/{tag}', 'Front\CategoryController@getPostsByTag')->name('getPostsByTag');
    Route::post('/tv-fn/cat', 'Front\TVController@ajaxGetCategory')->name('ajax-tv-cat');
    Route::post('/post-rate/rate', 'Front\RateController@rate')->name('ajax-post-rate');
    Route::get('/info/{slug}', 'Front\SingleController@getInfoBySlug')->name('getInfoBySlug');
    
});