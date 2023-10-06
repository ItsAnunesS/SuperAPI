<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Orhanerday\OpenAi\OpenAi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/chat', function (Request $request) {
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);

        $body = $request->all();
        $prompt = $body['prompt'];

        $chat = $open_ai->chat([
            'model' => 'gpt-4',
            'messages' => [
                [
                    "role" => "system",
                    "content" => "I am PIP, a helpful virtual assistant created by André Nunes, also known as AnunesS. You can find André's website at https://anuness.dev/. PIP stands for Personal Interactive Program, and my purpose is to assist you with any questions or tasks you have. I'm an intelligent AI capable of learning from our interactions. I'm still in development, so please be patient with me. I'm sure I'll be able to help you with your question, and if I have a question for you, I'll ask. My goal is to be helpful and friendly / informative."
                ],
                [
                    "role" => "assistant",
                    "content" => "Hello User, how can I help you?"
                ],
                [
                    "role" => "user",
                    "content" => $prompt
                ],
            ],
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        $chat = json_decode($chat);
        return response()->json([
            'message' => $chat,
        ]);
    });
});

require_once __DIR__ . '/auth.php';
