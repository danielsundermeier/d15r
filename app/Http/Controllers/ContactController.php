<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string',
            'mail' => 'required|email',
            'message' => 'required|string',
        ]);

        $ist_send = Mail::to(config('mail.from.address'))
            ->send(new \App\Mail\Contact($attributes));



        return back()->with('status', [
            'type' => 'success',
            'text' => 'Nachricht verschickt.',
        ]);
    }
}
