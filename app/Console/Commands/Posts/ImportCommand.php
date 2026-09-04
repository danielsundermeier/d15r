<?php

namespace App\Console\Commands\Posts;

use App\Enums\Tweets\Type;
use App\Models\Posts\Post;
use App\Models\Tweets\Tweet;
use App\Receipts\Abos\Abo;
use App\Receipts\Invoice;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
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
            $filename = basename($path);

            if (! Post::isArticleFile($filename)) {
                continue;
            }

            $post = Post::updateOrCreateFromFile($path);

            if ($post->published_at->toDateString() < Carbon::today('Europe/Berlin')->toDateString()) {
                continue;
            }

            $description = Post::descriptionFromFile($path);

            if (blank($description)) {
                continue;
            }

            Tweet::updateOrCreate([
                'type' => Type::PUBLISH,
                'source' => $post->filename,
                'scheduled_at' => $post->published_at->copy()->startOfDay(),
            ], [
                'text' => $description . "\n\n" . route('posts.show', ['post' => $post]),
            ]);
        }
    }
}
