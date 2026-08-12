<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class AnswerControllerTest extends TestCase
{
    public function test_it_shows_the_current_answer(): void
    {
        $response = $this->get(route('answer.index'));

        $response
            ->assertOk()
            ->assertSee('Das Regelbuch des Lebens')
            ->assertSee('Die Realität ist wahr')
            ->assertSee('Die Realität zeigt ihn dir.');
    }

    public function test_the_old_philosophy_url_redirects_to_the_answer(): void
    {
        $this->get('/philosophy')
            ->assertRedirect('/answer')
            ->assertStatus(301);
    }

    public function test_the_answer_is_linked_from_the_navigation(): void
    {
        $this->get(route('answer.index'))
            ->assertOk()
            ->assertSee(route('answer.index'), false)
            ->assertSee('Antwort');
    }
}
