<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $emailAddress = env('MAIL_USERNAME');

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Mail::to($emailAddress)->send(new ContactUsMail(($validatedData)));
    }
}
