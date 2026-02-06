<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 users
        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
        ]);

        User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
        ]);

        $this->command->table(
            ['ID', 'Name', 'Email', 'Password'],
            User::all()->map(fn ($user) => [
                $user->id,
                $user->name,
                $user->email,
                'password',
            ])->toArray()
        );
    }
}
