<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class WhyAiControllerTest extends TestCase
{
    public function test_it_explains_why_the_website_is_entrusted_to_ai(): void
    {
        $response = $this->get(route('why-ai.index'));

        $response
            ->assertOk()
            ->assertSee('Warum ich diese Webseite einer KI überlasse')
            ->assertSee('Das Gespräch ist das eigentliche Produkt')
            ->assertSee('Ein offenes Experiment');
    }

    public function test_the_page_is_linked_from_the_homepage_and_footer(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('why-ai.index'), false);
    }
}
