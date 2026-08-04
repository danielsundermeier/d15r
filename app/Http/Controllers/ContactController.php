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
            'g-recaptcha-response' => ['required', 'string'],
        ]);

        try {
            $captchaAssessment = Http::withHeaders([
                'X-Goog-Api-Key' => config('services.recaptcha.api_key'),
            ])
                ->timeout(5)
                ->post(sprintf(
                    'https://recaptchaenterprise.googleapis.com/v1/projects/%s/assessments',
                    config('services.recaptcha.project_id'),
                ), [
                    'event' => [
                        'token' => $attributes['g-recaptcha-response'],
                        'siteKey' => config('services.recaptcha.site_key'),
                        'expectedAction' => 'submit',
                        'userIpAddress' => $request->ip(),
                        'userAgent' => $request->userAgent(),
                    ],
                ])
                ->throw()
                ->json();

            $captchaIsValid = data_get($captchaAssessment, 'tokenProperties.valid') === true
                && data_get($captchaAssessment, 'tokenProperties.action') === 'submit'
                && data_get($captchaAssessment, 'riskAnalysis.score', 0) >= config('services.recaptcha.minimum_score');
        } catch (Throwable $exception) {
            Log::warning('The reCAPTCHA assessment failed.', [
                'exception' => $exception::class,
            ]);
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
