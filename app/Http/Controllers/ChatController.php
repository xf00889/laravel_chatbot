<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;

        // Configure global CURL options for API requests
        Http::macro('withCurlOptions', function () {
            return $this->withOptions([
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => true,
                    CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                    CURLOPT_CONNECTTIMEOUT => 30,
                    CURLOPT_TIMEOUT => 30,
                ]
            ]);
        });
    }

    public function index()
    {
        $messages = auth()->user()->chatMessages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('conversation_id');
            
        return view('chat.index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'conversation_id' => 'nullable|string'
        ]);

        $user = auth()->user();
        $user->checkAndUpdateSubscription();

        if (!$user->hasPromptsRemaining()) {
            return response()->json([
                'success' => false,
                'error' => 'no_prompts',
                'message' => 'You have no prompts remaining. Please upgrade your plan.'
            ], 403);
        }

        try {
            // Add error handling for SSL/CURL issues
            if (!extension_loaded('curl')) {
                throw new \Exception('CURL extension is not loaded');
            }

            // Log the attempt
            \Log::info('Attempting to send message to OpenAI', [
                'user_id' => auth()->id(),
                'message_length' => strlen($request->message)
            ]);

            // Get or create conversation ID
            $conversationId = $request->conversation_id ?? Str::uuid();

            // Get conversation history
            $conversationHistory = ChatMessage::where('conversation_id', $conversationId)
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'asc')
                ->get();

            // Get AI response with conversation history
            $response = $this->openAIService->sendMessage($request->message, $conversationHistory);
            
            if (empty($response)) {
                throw new \Exception('Empty response received from AI service');
            }

            // Store the message and response
            $chatMessage = ChatMessage::create([
                'user_id' => $user->id,
                'message' => $request->message,
                'response' => $response,
                'conversation_id' => $conversationId
            ]);

            // Decrement the user's prompts
            $user->decrementPrompts();

            return response()->json([
                'success' => true,
                'message' => [
                    'message' => $request->message,
                    'response' => $response,
                    'conversation_id' => $conversationId
                ],
                'prompts_remaining' => $user->prompts_remaining
            ]);

        } catch (\Exception $e) {
            \Log::error('Chat Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'message' => $request->message,
                'trace' => $e->getTraceAsString(),
                'api_key_configured' => !empty(config('services.openai.key')),
                'api_key_length' => strlen(config('services.openai.key'))
            ]);

            return response()->json([
                'success' => false,
                'error' => 'system_error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'debug_info' => [
                    'api_key_configured' => !empty(config('services.openai.key')),
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version()
                ]
            ], 500);
        }
    }

    public function deleteHistory()
    {
        try {
            // Delete all chat messages for the current user
            auth()->user()->chatMessages()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Chat history deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting chat history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete chat history'
            ], 500);
        }
    }
}