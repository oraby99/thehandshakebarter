<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::whereHas('barter', function ($query) {
            $query->where('requester_id', Auth::id())
                ->orWhere('receiver_id', Auth::id());
        })->with(['barter', 'messages'])->get();

        return response()->json([
            'data' => $conversations
        ]);
    }

    public function show($id)
    {
        $conversation = Conversation::with(['messages.sender', 'barter'])->findOrFail($id);

        // Authorization check
        if ($conversation->barter->requester_id !== Auth::id() && $conversation->barter->receiver_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'data' => $conversation
        ]);
    }


    public function storeMessage(Request $request, $id)
    {
        $request->validate([
            'message_body' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $conversation = Conversation::findOrFail($id);

        // Authorization check
        if ($conversation->barter->requester_id !== Auth::id() && $conversation->barter->receiver_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message_body' => $request->message_body,
            'attachment' => $path,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => new MessageResource($message),
        ]);
    }

    public function storeMessageByBarter(Request $request, $barterId)
    {
        $request->validate([
            'message_body' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Find or create conversation for this barter
        $barter = \App\Models\Barter::findOrFail($barterId);

        // Authorization check
        if ($barter->requester_id !== Auth::id() && $barter->receiver_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation = Conversation::firstOrCreate([
            'barter_id' => $barterId
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'message_body' => $request->message_body,
            'attachment' => $path,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => new MessageResource($message),
        ]);
    }
}
