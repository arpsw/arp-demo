<?php

use Illuminate\Support\Facades\Broadcast;
use Modules\Ai\Models\Chat;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{chatId}', fn ($user, $chatId) => Chat::where('id', $chatId)->where('user_id', $user->id)->exists()
);
