<?php

namespace App\Console\Commands\Guides;

use App\Models\Guides\Guide;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCommand extends Command
{
    protected $signature = 'guides:import';

    protected $description = 'Erstellt und aktualisiert Guides aus Dateien';

    public function handle()
    {
        $this->handleDirectories();
    }

    private function handleDirectories($directories = 'blog/guides')
    {
        $directories = Storage::allDirectories($directories);
        foreach ($directories as $directory) {
            $files = Storage::files($directory);
            if (empty($files)) {
                continue;
            }

            $guide = Guide::updateOrCreateFromDirectory($directory);
            dump($guide);
        }
    }
}
