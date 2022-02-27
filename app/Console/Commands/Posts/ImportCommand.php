<?php

namespace App\Console\Commands\Posts;

use App\Models\Posts\Post;
use App\Receipts\Abos\Abo;
use App\Receipts\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erstellt und aktialisiert Posts aus Dateien';

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
        $files = Storage::files('blog');
        dump($files);
        foreach ($files as $path) {
            $post = Post::updateOrCreateFromFile($path);
        }
    }
}
