<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;
use App\Extra\APIHelper;
//use App\Http\Resources\CategoryResource;
use Setting;
/**
 * @group Category
 *
 * APIs for managing categories
 */
class CategoryController extends Controller
{
    use APIHelper;
    
     /**
	 * Get Category By ID
     * @urlParam id required Category ID
     * @response {
     *        "isSuccess": true,
     *        "code": 200,
     *        "message": "",
     *        "data":{
     *               "id": 1,
     *               "created_by": null,
     *               "updated_by": null,
     *               "parent_id": null,
     *               "ordering": 0,
     *               "deleted_at": null,
     *               "created_at": "2019-04-24 09:36:20",
     *               "updated_at": "2019-04-24 09:36:20",
     *               "slug": "sections",
     *               "sort": 0,
     *               "icon": null,
     *               "title": null,
     *               "description": null,
     *               "body": null
     *           }
     *         }
	 */
    public function get($id){
        
        return $this->success(Category::findOrFail($id));
    }
    /**
	 * Get All Categories
	 */
    public function all(){
        return $this->success(Category::all());
    }
    /**
     * Get Chields By Parent ID
     * @urlParam id required Parent ID
    * @response {
    *        "isSuccess": true,
    *        "code": 200,
    *        "message": "",
    *        "data":{
    *               "id": 1,
    *               "created_by": null,
    *               "updated_by": null,
    *               "parent_id": null,
    *               "ordering": 0,
    *               "deleted_at": null,
    *               "created_at": "2019-04-24 09:36:20",
    *               "updated_at": "2019-04-24 09:36:20",
    *               "slug": "sections",
    *               "sort": 0,
    *               "icon": null,
    *               "title": null,
    *               "description": null,
    *               "body": null
    *           }
    *         }
    */
    public function chields($id){
        return $this->success(Category::findOrFail($id)->Chields);
    }
     public function chieldsBySlug($slug){
        $cat=Category::whereSlug($slug)->first();
        if($cat)return $this->success($cat->Chields);
    
         return $this->error("Category nof found !",404);
     }
     /**
	 * Get Home Categories
	 */
    public function home(){
        return $this->success(Category::whereIn('id',explode("|",Setting::getIfExists('app_home_cats','51,50')))->get());
    }
    
}
