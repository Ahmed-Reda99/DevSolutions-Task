<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'sender_id',
        'receiver_id'
    ];

    protected $attributes = [
        'status' => 1,
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeBetween($query, $authUserId, $otherUserId)
    {
        return $query->where(function ($q) use ($authUserId, $otherUserId) {
            $q->where('sender_id', $authUserId)
            ->where('receiver_id', $otherUserId);
        })->orWhere(function ($q) use ($authUserId, $otherUserId) {
            $q->where('sender_id', $otherUserId)
            ->where('receiver_id', $authUserId);
        })->orderByDesc('created_at');
    }
}
