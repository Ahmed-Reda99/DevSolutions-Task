<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RetrieveMessagesTest extends TestCase
{
    use RefreshDatabase;
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

        $token = auth()->login($user1);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->get('/api/chat/messages/' . $user2->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'sender_id',
                    'receiver_id',
                    'message',
                    'status',
                    'created_at'
                ]
            ],
            'meta' => [
                'current_page',
                'total'
            ]
        ]);


        $messages = collect($response->json('data'));

        $this->assertCount(2, $messages);
        $this->assertTrue($messages->contains('message', 'Message 1'));
        $this->assertTrue($messages->contains('message', 'Message 2'));
        $this->assertFalse($messages->contains('message', 'Message 3'));
    }
}
