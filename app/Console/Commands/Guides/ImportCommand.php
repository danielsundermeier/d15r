<?php

namespace App\Console\Commands\Guides;

use App\Models\Guides\Guide;
use App\Models\Posts\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guides:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erstellt und aktialisiert Guides aus Dateien';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
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
