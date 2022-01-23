<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SMS;
use App\Extra\APIHelper;
/**
 * @SMS 
 * SMS API Methods 
 */
class SMSController extends Controller
{
    use APIHelper;

    /**
     * Send SMS
     */
    public function send(){
       
        return $this->success( SMS::create(request()->all()));
    }
  
}
