<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\OpenAIService;

class AIContentController extends Controller
{

    protected $OpenAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->OpenAIService = $openAIService;
    }

    public function generateContent(Request $request)
    {

        $request->validate([
            'content' => 'required|string|max:25000'
        ]);

        $message = [['role' => 'user', 'content' => $request->input('content')]];
        $result = $this->OpenAIService->generate($message);

        return response()->json([
            'result' => $result
        ]);
    }
}
