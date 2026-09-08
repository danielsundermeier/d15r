<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            'cf-turnstile-response' => ['required', 'string', 'max:2048'],
        ]);

        $expectedHostnames = config('services.turnstile.hostnames', []);

        try {
            $turnstileResult = Http::asForm()
                ->timeout(10)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => config('services.turnstile.secret'),
                    'response' => $attributes['cf-turnstile-response'],
                    'remoteip' => $request->ip(),
                ])
                ->throw()
                ->json();

            $captchaIsValid = $expectedHostnames !== []
                && data_get($turnstileResult, 'success') === true
                && data_get($turnstileResult, 'action') === 'contact'
                && in_array(data_get($turnstileResult, 'hostname'), $expectedHostnames, true);
        } catch (Throwable $exception) {
            Log::warning('The Turnstile assessment failed.', [
                'exception' => $exception::class,
            ]);
            $captchaIsValid = false;
        }

        if (! $captchaIsValid) {
            throw ValidationException::withMessages([
                'cf-turnstile-response' => 'Die CAPTCHA-Prüfung ist fehlgeschlagen. Bitte versuche es erneut.',
            ]);
        }

        unset($attributes['cf-turnstile-response']);

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
