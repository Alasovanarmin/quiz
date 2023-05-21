<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Contact::query()
            ->orderBy("read_at")
            ->orderByDesc("created_at")
            ->get();

        return view("dashboard.message.index", compact('messages'));
    }

    public function show($id)
    {
        $message = Contact::query()
            ->where("id", $id)
            ->first();

        $message->update(['read_at' => now()]);

        return view("dashboard.message.show", compact('message'));
    }

    public function sendMail($id, Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $subject = $request->subject;
        $email = $request->email;
        $message = $request->message;

        Mail::send("mail.send-mail", ['text' => $message], function ($a) use($subject, $email) {
            return $a->subject($subject)->to($email);
        });

        return redirect()->route("dashboard.message.show", $id);
    }
}
