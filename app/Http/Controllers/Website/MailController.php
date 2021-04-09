<?php

namespace App\Http\Controllers\Website;

use App\Mail\Feedback;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function feedback(Request $request)
    {
        $data = [
            'name' => $request->first . ' ' . $request->last,
            'body' => $request->message,
            'sender' => $request->sender
        ];

        Mail::to('pawadiweb@gmail.com')->send(new Feedback($data));
    }
}
