<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chats.{id}', function ($user, $chatId) {
    return Chat::find($chatId)->isMember($user->id);
    // if (Chat::find($chatId)->isMember($user->id)) {
    //     return ['id' => $user->id, 'name' => $user->first_name];
    // }
});
