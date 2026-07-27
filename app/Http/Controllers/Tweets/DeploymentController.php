<?php

namespace App\Http\Controllers\Tweets;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class DeploymentController extends Controller
{
    public function store(): void
    {
        Process::path(Storage::path('x'))
            ->run(['git', 'pull'])
            ->throw();

        Artisan::call('tweets:import');
    }
}
