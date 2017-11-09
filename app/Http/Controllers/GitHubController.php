<?php

namespace BotHub\Http\Controllers;

use Illuminate\Http\Request;

class GitHubController extends Controller
{
    public function verifySignature(Request $request)
    {
        $signature = 'sha1=' . hash_hmac('sha1', $request->getContent(), config('services.github.webhook_token'));

        if (hash_equals($signature, $request->header(['X-Hub-Signature']))) {
            return true;
        }

        return false;
    }
}
