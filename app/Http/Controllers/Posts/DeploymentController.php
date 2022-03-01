<?php

namespace App\Http\Controllers\Posts;

use App\Models\Posts\Post;
use D15r\Deployment\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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

        $command = 'git -C '. Storage::path('blog') . ' pull';
        echo $command . PHP_EOL;
        $process = Process::fromShellCommandline($command);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

        $payload = json_decode($githubPayload, true);
        foreach ($payload['head_commit']['added'] as $filename) {
            Post::updateOrcreateFromFile('blog/' . $filename);
        }

        foreach ($payload['head_commit']['modified'] as $filename) {
            Post::updateOrcreateFromFile('blog/' . $filename);
        }
    }
}