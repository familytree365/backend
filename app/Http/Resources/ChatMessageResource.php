<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            '_id' => $this->id,
            'content' => $this->message,
            'senderId' => $this->sender_id,
            'username' => $this->sender->userName(),
            'avatar' => '',
            'date' => date('d M',strtotime($this->updated_at)),
            'timestamp' => date('h:i',strtotime($this->updated_at)),
            'system' => false,
            'saved' => true,
            'distributed' => false,
            'seen' => false,
            'disableActions' => false,
            'disableReactions' => false,
            'roomId' => $this->chat->id
        ];
    }
}
