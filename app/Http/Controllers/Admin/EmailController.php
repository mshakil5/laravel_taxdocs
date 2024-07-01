<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\MailContent;

class EmailController extends Controller
{
    public function sendMail($id)
    {
        $user = User::findOrFail($id);
        $mailContent = MailContent::latest()->first();
        Mail::to($user->email)->send(new SendMail($mailContent->title, $mailContent->content));
        return response()->json(['message' => 'Mail sent successfully']);
    }
}
