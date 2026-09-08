<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class ImpressumControllerTest extends TestCase
{
    public function test_it_describes_the_current_privacy_relevant_services(): void
    {
        $this->get(route('impressum'))
            ->assertOk()
            ->assertSee('Angaben gemäß § 5 DDG')
            ->assertSee('Cookies und lokale Speicherung')
            ->assertSee('Schutz des Kontaktformulars mit Cloudflare Turnstile')
            ->assertSee('https://www.cloudflare.com/turnstile-privacy-policy/', false)
            ->assertDontSee('Privacy Shield')
            ->assertDontSee('Registrierfunktion')
            ->assertDontSee('Reichweitenmessung/Marketing');
    }
}
