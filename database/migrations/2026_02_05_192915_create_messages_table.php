<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->text('message');
            $table->foreignId('sender_id') // indexing forced automatically on foreign keys
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('receiver_id') // indexing forced automatically on foreign keys
                ->constrained('users')
                ->cascadeOnDelete();
            $table->tinyInteger('status')
                ->default(App\Enums\Status::delivered->value)
                ->comment('\App\Enums\Status 1: delivered, 2: read');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
