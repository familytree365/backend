<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSentEvent;
use App\Models\Chat;
use App\Models\ChatMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ChatMessageResource;
use App\Http\Resources\UserFilterResource;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requester = $request->user();
        $chatObject = new Chat();

        return $chatObject->getChatsByUser($requester->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        $event = new ChatMessageSentEvent();
        event($event);
        dd('here');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $event = new ChatMessageSentEvent();
        // broadcast($event);
        $request->validate([
            'chat_type' => 'required',
            'chat_with' => 'required|integer',
        ]); 

        $potentialChatName1 = $request->chat_type.'_chat_'.$request->user()->id.'_'.$request->chat_with;
        $potentialChatName2 = $request->chat_type.'_chat_'.$request->chat_with.'_'.$request->user()->id;

        $checkDuplicate = Chat::where('chat_name', $potentialChatName1)->orWhere('chat_name', $potentialChatName2)->first();

        if($checkDuplicate){
            return $checkDuplicate->format($checkDuplicate, $request->user()->id);
        }

        DB::beginTransaction();

        try {
            
            $chat = Chat::create([
                'chat_type' => $request->chat_type,            
                'chat_name' => $request->chat_name ?? $potentialChatName1
            ]);

            $chat->users()->attach([$request->user()->id, $request->chat_with]);
            
            // ChatMember::create([
            //     'user_id' => $request->user()->id,
            //     'chat_id' => $chat->id
            // ]);
            
            // ChatMember::create([
            //     'user_id' => $request->chat_with,
            //     'chat_id' => $chat->id
            // ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        

        return $chat->format($chat, $request->user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        return $chat;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }

    public function searchUser(Request $request){
        $query = $request->get('query');
        return UserFilterResource::collection(User::where('first_name', 'like', '%'.$query.'%')->orWhere('last_name', 'like', '%'.$query.'%')->paginate(5));
    }


    public function chatMessages(Request $request, $chatId){
        $chat = Chat::find($chatId);
        $chat->updateLastReadMsg($request->user()->id);
        $chatMessages = ChatMessageResource::collection($chat->chatMessages()->paginate());
        return [
            'unreadMsgCount' => $request->user()->totalUnreadMessages(),
            'chat' => $chat,
            'data' => $chatMessages
        ];

        //return $chatMessages;
    }

}
