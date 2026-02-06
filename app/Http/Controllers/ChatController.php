<?php

namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Http\Resources\MessageResource;
use App\Http\Requests\MarkAsReadRequest;
use App\Http\Requests\GetMessagesRequest;
use App\Http\Requests\SendMessageRequest;

class ChatController extends Controller
{
    protected $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Get the chat messages between the authenticated and the specified user
     * param int $user_id the specified user
     */
    public function messages(GetMessagesRequest $request, $user_id)
    {
        $messages = $this->chatService->getMessages(auth()->id(), $user_id);

        return MessageResource::collection($messages)->response()->getData(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function send(SendMessageRequest $request)
    {
        $message = $this->chatService->storeMessage(
            auth()->id(),
            $request->validated()
        );

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => new MessageResource($message)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function markAsRead(MarkAsReadRequest $request)
    {
        $message = $this->chatService->markMessageAsRead($request->validated());

        return response()->json([
            'message' => 'Message marked as read successfully',
            'data' => new MessageResource($message)
        ], 200);
    }
}
