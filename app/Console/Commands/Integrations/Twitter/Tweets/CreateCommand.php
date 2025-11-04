<?php

namespace App\Console\Commands\Integrations\Twitter\Tweets;

use App\Http\Integrations\Twitter\Tweets\CreateRequest;
use Illuminate\Console\Command;

class CreateCommand extends Command
{
    protected $signature = 'integrations:twitter:tweets:create';

    protected $description = 'Tweets a new tweet via Twitter API';

    public function handle()
    {
        $response = CreateRequest::make()
            ->text('Hello World!')
            ->send();

        $this->info($response->status());
        $this->line($response->body());

        return self::SUCCESS;
    }
}
