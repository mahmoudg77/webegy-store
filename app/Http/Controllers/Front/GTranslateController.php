<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Cloud\Translate\V2\TranslateClient;


class GTranslateController extends Controller
{
    public function index() {

        $target = request()->get("target");
        if (!isset($target)) {
            $target = 'en';
        }
        $translate = new TranslateClient([
            'key' => ''
        ]);

        // Translate text from english to french.
        $result = $translate->translate(request()->get('t'), [
            'target' => $target
        ]);

        //return $result;

        return response()->json($result);
        
    }
}