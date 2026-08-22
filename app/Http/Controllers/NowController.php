<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use JsonException;

class NowController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $token = config('services.overland.token');

        if (! is_string($token)
            || $token === ''
            || ! hash_equals($token, (string) $request->bearerToken())) {
            abort(401);
        }

        try {
            $payload = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return response()->json(['message' => 'The request body must be valid JSON.'], 422);
        }

        if (! is_array($payload)) {
            return response()->json(['message' => 'The request body must be a JSON object.'], 422);
        }

        $validator = Validator::make($payload, [
            'locations' => ['required', 'array', 'min:1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $receivedAt = now();

        Storage::disk('local')->append(
            'now/'.$receivedAt->toDateString().'.ndjson',
            json_encode([
                'received_at' => $receivedAt->toIso8601String(),
                'payload' => $payload,
            ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)
        );

        Cache::forever('now.latest', $payload);

        return response()->json(['result' => 'ok']);
    }
}
