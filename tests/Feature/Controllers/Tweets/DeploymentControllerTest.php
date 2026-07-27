<?php

namespace Tests\Feature\Controllers\Tweets;

use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeploymentControllerTest extends TestCase
{
    public function test_it_pulls_the_x_repository_and_imports_tweets(): void
    {
        Process::fake();
        Artisan::shouldReceive('call')
            ->once()
            ->with('tweets:import')
            ->andReturn(0);

        $this->post(route('tweets.deploy.store'))
            ->assertOk();

        Process::assertRan(function (PendingProcess $process): bool {
            return $process->command === ['git', 'pull']
                && $process->path === Storage::path('x');
        });
    }
}
