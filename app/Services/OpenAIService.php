<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
/**
 * Class OpenAIService.
 */
class OpenAIService
{
    public function generate(array $messages): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
            'HTTP-Referer' => 'http://localhost', // required by OpenRouter
            'X-Title' => 'Laravel Blogger Assistant',
        ])->post(env('OPENROUTER_BASE_URL') . '/chat/completions', [
            'model' => 'openai/gpt-4o-mini', // Or llama3, claude-3, etc.
            'messages' => $messages,
        ]);

        if ($response->failed()) {
            logger()->error('OpenRouter API failed', ['response' => $response->body()]);
            return null;
        }

        return $response->json('choices.0.message.content');
    }
}
