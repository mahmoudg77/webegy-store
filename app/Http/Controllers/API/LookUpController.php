<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;
use App\Extra\APIHelper;
use App\Models\Country;
/**
 * @group Lookup lists
 * Get all lookup lists such as countries and cities
 */
class LookupController extends Controller
{
    use APIHelper;

    /**
     * Get all countries
     */
    public function getCountries(){
        //dd(app()->getLocale());
        return $this->success(Country::all());
    }
    /**
     * Get cities in specific country
     * @urlParam id required Country ID Example:14
     */
    public function getCities(int $id){
        return $this->success(Country::find($id)->Cities);
    }
}
