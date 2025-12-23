<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MarkdownWithTocController;

class EudaimonicaController extends MarkdownWithTocController
{
    private const MARKDOWN_PATHS = [
        'tutorial' => 'markdown/eudaimonica/mythology/tutorial/tutorial.md',
        'lets-play' => 'markdown/eudaimonica/mythology/lets-play/lets-play.md',
        'new-game-plus' => 'markdown/eudaimonica/mythology/new-game-plus/new-game-plus.md'
    ];

    protected $markdown_path = 'markdown/eudaimonica/eudaimonica.md';

    public function show(string $section)
    {
        if (array_key_exists($section, self::MARKDOWN_PATHS)) {
            $this->markdown_path = self::MARKDOWN_PATHS[$section];
        }

        return parent::show($section);
    }
}
