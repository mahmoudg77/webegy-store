<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Extra\APIHelper;
use App\Models\Setting;
use Func;
use Validator;
use Mail;
class ContactController extends Controller
{    
    use APIHelper;
     
    public function send(Request $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        //$subject = $request->input('subject');
        $subject = "Contact us form message from ".$first_name." ".$last_name;//"Replay Message From ". $request->get('c_email');
        $email = $request->input('email');
        //$cellphone = $request->get('cellphone');
        $messageBody  = $request->input('message');
        //$website  = $request->get('website');
        // Creating Array of Errors
        $formErrors = array();
        if (strlen($first_name) <= 3) {
            $formErrors[] = 'First Name must be larger than 3 characters';
        }

        if (strlen($last_name) <= 3) {
            $formErrors[] = 'Last Name must be larger than 3 characters';
        }
       
        if (strlen($messageBody) < 10) {
            $formErrors[] = 'Message Can\'t be less than 10 characters'; 
        }
        if (strlen($email) < 10) {
            $formErrors[] = 'Email Is Required'; 
        }
        // If No Errors Send The Email [ mail(To, Subject, Message, Headers, Parameters) ]
        $headers = 'From: ' . $email . '\r\n';
        $myEmail = explode(";",Setting::getIfExists('emails_default'));

        if (count($formErrors)==0) {
            Mail::send('email.contactus', compact('first_name','last_name','email','subject','messageBody'), function ($m) use ($email,$subject,$myEmail) {
                $m->to($myEmail, 'Contact Us Form')->subject($subject);
            });

            //$success = '<div class="alert alert-success">We Have Recieved Your Message</div>';
           
           //if ($request->ajax())
           // return response()->json([
           //         'status' => 'success',
           //         'msg' => 'Mail sent successfully',
            //            ], 200);
          //  else
           //     return back()->with('success', 'Thanks for contacting us!');
        return $this->success("We Have Recieved Your Message");
        
        }
        return $this->error(implode(",",$formErrors),412);
        
       
    }

}
