<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Func;
use Setting;
use Mail;
class ContactUsController extends Controller
{
    public function index(){
        // $page=Func::getPageBySlug('contact-us');
        // if($page)
        //     \App\Models\Visit::log(\App\Models\Post::class,$page->id);
        return view('front.contact-us');
    }
        
    public function store(Request $request)
    {
        $first_name = $request->get('first_name');
        $last_name = $request->get('last_name');
        // $subject = $request->get('subject');
        $subject = "Replay Message From ". $request->get('email');
        $email = $request->get('email');
        //$cellphone = $request->get('cellphone');
        $messageBody  = $request->get('message');
        //$website  = $request->get('website');
        // Creating Array of Errors
        $formErrors = array();
        if (strlen($first_name) <= 3) {
            $formErrors[] = 'First Name must be larger than <strong>3</strong> characters';
        }

        if (strlen($last_name) <= 3) {
            $formErrors[] = 'Last Name must be larger than <strong>3</strong> characters';
        }
       
        if (strlen($messageBody) < 10) {
            $formErrors[] = 'Message Can\'t be less than <strong>10</strong> characters'; 
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

            $success = '<div class="alert alert-success">We Have Recieved Your Message</div>';
           
           if ($request->ajax())
            return response()->json([
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                        ], 200);
            else
                return back()->with('success', 'Thanks for contacting us!');
        }
        
        if ($request->ajax())
            return response()->json([
                    'status' => 'error',
                    'msg' => $formErrors,
                        ], 200);
        else
            return back()->with('error', $formErrors);
        // return view('front.contact-us',compact('subject','email','message','formErrors'));
         
    }

    public function contactStore(ContactFormRequest $request) {
        
        $contact_data = [
            //'c_is_ajax' => $request->get('c_is_ajax'),
            'c_name' => $request->get('first_name').$request->get('last_name'),
            'c_email' => $request->get('email'),
            'c_subject' => $request->get('subject'),
            'c_message' => $request->get('message'),
            'c_website' => $request->get('website')
        ];

        ContactUS::create([
            'name' => $contact_data['c_name'],
            'email' => $contact_data['c_email'],
            'subject' => $contact_data['c_subject'],
            'message' => $contact_data['c_message'],
            'website' => $contact_data['website'],
        ]);
        $myEmail = Setting::getIfExists('emails_default');

        Mail::send('emails.contact', $contact_data, function($message) use ($contact_data,$myEmail) {
            $message->from($contact_data['c_email'], $contact_data['c_name']);
            $message->to($myEmail, 'Contact Us Form')
                    ->subject($contact_data['c_subject']);
        });

        if ($request->ajax())
            return response()->json([
                    'status' => 'success',
                    'msg' => 'Mail sent successfully',
                        ], 200);
        else
            return back()->with('success', 'Thanks for contacting us!');
    }
}
