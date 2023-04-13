<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HowWeWork;
use App\Models\ContactMail;
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

      

        $contactmail = ContactMail::where('id', 1)->first()->name;

	    $mail_to_send_to = $contactmail;
	    
        $from_email = "info@taxdocs.co.uk";
        $subject= "New message from Taxdocs";

        $message= "\r\n" . "Name: $name" . "\r\n". "Subject: $visitor_subject" . "\r\n"; //get recipient name in contact form
        $message = $message.$visitor_message . "\r\n" ;//add message from the contact form to existing message(name of the client)
        $headers = "From: $from_email" . "\r\n" . "Reply-To: $email"  ;
        $a = mail( $mail_to_send_to, $subject, $message, $headers );

        // $array['name'] = $name;
        // $array['email'] = $email;
        // $array['visitor_subject'] = $visitor_subject;
        // $array['visitor_message'] = $visitor_message;
        // $b = Mail::send('emails.contactmail', $array, function($message) {
        //     $message->to('kazimuhammadullah@gmail.com', 'Taxdocs')->subject
        //         ('Taxdocs Contact Message');
        //     $message->from('kmushakil22@gmail.com','shakil11');
        // });
        
        if ($a)
        {
            $message ="<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Thanks for your message! We will get back to you soon :)
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();

        } else {

            $message ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Problem with sending message !
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();

        }


    }
}
