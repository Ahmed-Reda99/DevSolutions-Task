<?php
namespace App\Services;

use App\Enums\Status;
use App\Models\Message;
use App\Events\MessageSent;

class ChatService
{
    public function storeMessage($senderId, $data)
    {
        $message = Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $data['receiver_id'],
            'message' => $data['message']
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    public function getMessages($authUserId, $otherUserId)
    {
        return Message::between($authUserId, $otherUserId)->paginate(10);
    }

    public function markMessageAsRead($data)
    {
        $message = Message::find($data['message_id']);
        $message->status = Status::read->value;
        $message->save();

        return $message;
    }
}
