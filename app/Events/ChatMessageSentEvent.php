<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChatMessage;
use App\Http\Resources\ChatMessageResource;

class ChatMessageSentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\ChatMessage
     */
    public $chatMessage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chatMessage = null)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'NewMessage';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chats.'.$this->chatMessage->chat_id);
        //return new PresenceChannel('chats.'.$this->chat->id);
    }

    public function broadcastWith()
    {
        return [
            'message' => new ChatMessageResource($this->chatMessage),
        ];
    }
}
