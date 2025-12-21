<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DeploymentController extends Controller
{
    public function store(Request $request)
    {
        $githubPayload = $request->input('payload');
        $githubHash = $request->header('X-Hub-Signature');

        $localToken = config('app.deploy_secret');
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        // if (! hash_equals($githubHash, $localHash)) {
        //     return abort(404);
        // }

        // if (! $githubHash) {
        //     return abort(404);
        // }

        $command = 'git -C '. base_path() . ' pull';
        echo $command . PHP_EOL;
        $process = Process::fromShellCommandline($command);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        Artisan::call('tweets:import', [
            '--quiet' => true,
        ]);

        echo $process->getOutput();
    }
}