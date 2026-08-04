<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Throwable;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mail' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
            'g-recaptcha-response' => ['required', 'string'],
        ]);

        try {
            $captchaIsValid = Http::asForm()
                ->timeout(5)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $attributes['g-recaptcha-response'],
                    'remoteip' => $request->ip(),
                ])
                ->json('success', false);
        } catch (Throwable $exception) {
            report($exception);
            $captchaIsValid = false;
        }

        if (! $captchaIsValid) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Die CAPTCHA-Prüfung ist fehlgeschlagen. Bitte versuche es erneut.',
            ]);
        }

        unset($attributes['g-recaptcha-response']);

        try {
            Mail::to(config('mail.from.address'))
                ->send(new Contact($attributes));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('status', [
                    'type' => 'error',
                    'text' => 'Die Nachricht konnte leider nicht verschickt werden. Bitte versuche es später noch einmal.',
                ]);
        }

        return back()->with('status', [
            'type' => 'success',
            'text' => 'Nachricht verschickt. Vielen Dank, ich melde mich.',
        ]);
    }
}
