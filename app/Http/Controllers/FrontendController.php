<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HowWeWork;
use App\Models\ContactMail;
use App\Mail\ContactFormMail;
use App\Models\Contact;
use Mail;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function getWorkDetails($id)
    {
        $data = HowWeWork::where('id',$id)->first();
        return view('frontend.workdtl', compact('data'));
    }
    public function privacy()
    {
        return view('frontend.privacy');
    }
    public function terms()
    {
        return view('frontend.terms');
    }

    
    public function faqs()
    {
        return view('frontend.faqs');
    }

    public function visitorContact(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $visitor_subject = $request->subject;
        $visitor_message = $request->message;

        $emailValidation = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,10}$/";

        if(empty($name)){
            $message ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Please fill name field, thank you!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        if(empty($email)){
            $message ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Please fill email field, thank you!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(!preg_match($emailValidation,$email)){
	    
            $message ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Your mail ".$email." is not valid mail. Please wirite a valid mail, thank you!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
            
        }
        
        if(empty($visitor_subject)){
            $message ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Please fill subject field, thank you!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($visitor_message)){
            $message ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Please write your query in message field, thank you!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

      

        $contactmail = ContactMail::where('id', 1)->first()->email;

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email; 
        $contact->subject = $request->subject; 
        $contact->message = $request->message; 
        if ($contact->save()) {

            $array['name'] = $request->name;
            $array['email'] = $request->email;
            $array['subject'] = $request->subject;
            $array['message'] = $request->message;
            $array['contactmail'] = $contactmail;
            Mail::to($contactmail)
            ->send(new ContactFormMail($array));

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Message Send Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error']);
        }

        

        
        
        


    }
}
