<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use App\Services\ChatService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_storage(): void
    {
        $chatService = new ChatService();

        $oldMessagesCount = Message::all()->count();
        $sender = User::factory()->create();
        $receiver = User::factory()->create();

        $message = $chatService->storeMessage($sender->id, [
            'receiver_id' => $receiver->id,
            'message' => 'Test message'
        ]);

        $this->assertEquals('Test message', $message->message);
        $this->assertCount($oldMessagesCount + 1, Message::all());
    }

    public function test_messages_retrieval(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        Message::factory()->create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'message' => 'Message 1'
        ]);

        Message::factory()->create([
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
            'message' => 'Message 2'
        ]);

        Message::factory()->create([
            'sender_id' => $user1->id,
            'receiver_id' => $user3->id,
            'message' => 'Message 3'
        ]);

        $chatService = new ChatService();
        $paginator = $chatService->getMessages($user1->id, $user2->id);

        $this->assertInstanceOf(
            \Illuminate\Contracts\Pagination\LengthAwarePaginator::class,
            $paginator
        );
        $this->assertCount(2, $paginator->items());

        $messages = collect($paginator->items())->pluck('message');

        $this->assertTrue($messages->contains('Message 1'));
        $this->assertTrue($messages->contains('Message 2'));
        $this->assertFalse($messages->contains('Message 3'));

        $this->assertEquals(10, $paginator->perPage());
    }
}
