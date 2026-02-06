<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Enums\Status;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_message_through_api(): void
    {
        $sender = User::factory()->create();
        $receiver = User::factory()->create();
        $token = auth()->login($sender);

        Event::fake();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/chat/send', [
                'receiver_id' => $receiver->id,
                'message' => 'Test message'
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('messages', [
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => 'Test message',
            'status' => Status::delivered->value
        ]);
        Event::assertDispatched(\App\Events\MessageSent::class);
    }
}
