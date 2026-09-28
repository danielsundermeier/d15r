<?php

namespace Tests\Feature\Controllers\Posts;

use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeploymentControllerTest extends TestCase
{
    public function test_it_pulls_the_blog_repository_and_imports_all_posts_and_guides(): void
    {
        Process::fake();
        Artisan::shouldReceive('call')
            ->once()
            ->with('posts:import')
            ->ordered()
            ->andReturn(0);
        Artisan::shouldReceive('call')
            ->once()
            ->with('guides:import')
            ->ordered()
            ->andReturn(0);

        $this->post(route('posts.deploy.store'))
            ->assertOk();

        Process::assertRan(function (PendingProcess $process): bool {
            return $process->command === ['git', 'pull']
                && $process->path === Storage::path('blog');
        });
    }
}
