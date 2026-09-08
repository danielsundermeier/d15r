<?php

namespace Tests\Feature\Controllers;

use App\Mail\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.turnstile.secret' => 'test-secret',
            'services.turnstile.site_key' => 'test-site-key',
            'services.turnstile.hostnames' => ['d15r.test'],
        ]);
    }

    public function test_it_sends_a_contact_message_and_shows_the_success_message(): void
    {
        Mail::fake();
        $this->fakeValidCaptchaAssessment();
        config(['mail.from.address' => 'daniel@example.com']);

        $response = $this->post(route('contact.store'), [
            'name' => 'Ada Lovelace',
            'mail' => 'ada@example.com',
            'message' => 'Ich möchte mit dir zusammenarbeiten.',
            'cf-turnstile-response' => 'valid-captcha-token',
        ]);

        $response
            ->assertRedirect()
            ->assertSessionHas('status', fn (array $status) =>
                $status['type'] === 'success'
                && $status['text'] === 'Nachricht verschickt. Vielen Dank, ich melde mich.'
            );

        Mail::assertSent(Contact::class, function (Contact $mail) {
            $mail->build();

            return $mail->hasTo('daniel@example.com')
                && $mail->hasReplyTo('ada@example.com', 'Ada Lovelace');
        });

        Http::assertSent(fn ($request) =>
            $request->url() === 'https://challenges.cloudflare.com/turnstile/v0/siteverify'
            && $request['secret'] === 'test-secret'
            && $request['response'] === 'valid-captcha-token'
        );
    }

    public function test_it_keeps_the_input_and_shows_an_error_when_sending_fails(): void
    {
        config(['mail.from.address' => 'daniel@example.com']);
        $this->fakeValidCaptchaAssessment();

        Mail::shouldReceive('to')
            ->once()
            ->with('daniel@example.com')
            ->andThrow(new RuntimeException('SMTP unavailable'));

        $response = $this->from(route('contact.index'))->post(route('contact.store'), [
            'name' => 'Ada Lovelace',
            'mail' => 'ada@example.com',
            'message' => 'Bitte verliere diese Nachricht nicht.',
            'cf-turnstile-response' => 'valid-captcha-token',
        ]);

        $response
            ->assertRedirect(route('contact.index'))
            ->assertSessionHas('_old_input.name', 'Ada Lovelace')
            ->assertSessionHas('_old_input.mail', 'ada@example.com')
            ->assertSessionHas('_old_input.message', 'Bitte verliere diese Nachricht nicht.')
            ->assertSessionHas('status', fn (array $status) =>
                $status['type'] === 'error'
                && $status['text'] === 'Die Nachricht konnte leider nicht verschickt werden. Bitte versuche es später noch einmal.'
            );
    }

    public function test_it_validates_the_contact_message_before_sending(): void
    {
        Mail::fake();

        $this->from(route('contact.index'))
            ->post(route('contact.store'), [
                'name' => '',
                'mail' => 'keine-mailadresse',
                'message' => '',
            ])
            ->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors(['name', 'mail', 'message']);

        Mail::assertNothingSent();
    }

    public function test_it_rejects_the_contact_message_when_the_captcha_is_invalid(): void
    {
        Mail::fake();
        Http::fake(['challenges.cloudflare.com/turnstile/*' => Http::response([
            'success' => false,
        ])]);

        $this->from(route('contact.index'))
            ->post(route('contact.store'), [
                'name' => 'Ada Lovelace',
                'mail' => 'ada@example.com',
                'message' => 'Diese Nachricht darf nicht verschickt werden.',
                'cf-turnstile-response' => 'invalid-captcha-token',
            ])
            ->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors([
                'cf-turnstile-response' => 'Die CAPTCHA-Prüfung ist fehlgeschlagen. Bitte versuche es erneut.',
            ]);

        Mail::assertNothingSent();
    }

    public function test_it_rejects_a_valid_captcha_with_the_wrong_action(): void
    {
        Mail::fake();
        $this->fakeValidCaptchaAssessment(action: 'other');

        $this->from(route('contact.index'))
            ->post(route('contact.store'), [
                'name' => 'Ada Lovelace',
                'mail' => 'ada@example.com',
                'message' => 'Diese Nachricht darf nicht verschickt werden.',
                'cf-turnstile-response' => 'suspicious-captcha-token',
            ])
            ->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors('cf-turnstile-response');

        Mail::assertNothingSent();
    }

    public function test_it_rejects_a_valid_captcha_from_an_unapproved_hostname(): void
    {
        Mail::fake();
        Http::fake(['challenges.cloudflare.com/turnstile/*' => Http::response([
            'success' => true,
            'action' => 'contact',
            'hostname' => 'attacker.example',
        ])]);

        $this->from(route('contact.index'))
            ->post(route('contact.store'), [
                'name' => 'Ada Lovelace',
                'mail' => 'ada@example.com',
                'message' => 'Diese Nachricht darf nicht verschickt werden.',
                'cf-turnstile-response' => 'wrong-hostname-token',
            ])
            ->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors('cf-turnstile-response');

        Mail::assertNothingSent();
    }

    public function test_the_layout_displays_the_message_stored_in_the_session(): void
    {
        $this->withSession([
            'status' => [
                'type' => 'warning',
                'text' => 'Diese konkrete Nachricht kommt aus der Session.',
            ],
        ])->get(route('contact.index'))
            ->assertOk()
            ->assertSee('Diese konkrete Nachricht kommt aus der Session.')
            ->assertDontSee('Nachricht verschickt. Vielen Dank, ich melde mich.');
    }

    private function fakeValidCaptchaAssessment(string $action = 'contact'): void
    {
        Http::fake(['challenges.cloudflare.com/turnstile/*' => Http::response([
            'success' => true,
            'action' => $action,
            'hostname' => 'd15r.test',
        ])]);
    }
}
