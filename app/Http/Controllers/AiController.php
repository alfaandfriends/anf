<?php

namespace App\Http\Controllers;

use App\Enums\AiChatMessageStatus;
use App\Events\AiResponseStream;
use App\Jobs\CreateChat;
use App\Jobs\GenerateQuiz;
use App\Jobs\InitiateChat;
use App\Jobs\SendPrompt;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use OpenAI;
use Str;

class AiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = DB::table('ai_chats')->select('id', 'name')->get();

        return Inertia::render('AiChat/Index', [
            'chats'   => $chats,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::check() && !$request->chat_id){
            $chat_id = Str::ulid();
            $user_id = Auth::id();

            DB::table('ai_chats')->insert([
                'id' => (string)$chat_id,
                'user_id' => $user_id,
                'name' => $request->messages
            ]);

            DB::table('ai_chat_messages')->insert([
                'id' => Str::ulid(),
                'chat_id' => (string)$chat_id,
                'prompt' => $request->messages,
                'status' => AiChatMessageStatus::NOT_STARTED,
            ]);

            return response()->json([
                'chat_id' => $chat_id,
            ]);
        }

        return redirect(route('ai.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $chats      = DB::table('ai_chats')->select('id', 'name')->get();
        $chat_data  = DB::table('ai_chats')
                        ->join('ai_chat_messages', 'ai_chat_messages.chat_id', '=', 'ai_chats.id')
                        ->where('ai_chats.user_id', Auth::id())
                        ->where('ai_chats.id', $id)
                        ->select('ai_chats.thread_id', 'ai_chat_messages.*')
                        ->get();

        if($chat_data->isNotEmpty()){
            $latest_record = $chat_data->first();
            if(count($chat_data) == 1 && $latest_record->status == AiChatMessageStatus::NOT_STARTED){
                DB::table('ai_chat_messages')->where('id', $latest_record->id)->update([
                    'status' => AiChatMessageStatus::PROCESSING
                ]);
                InitiateChat::dispatch($id, auth()->id(), $latest_record->prompt);
            }

            return Inertia::render('AiChat/Index', [
                'chats'   => $chats,
                'chat_id' => $id,
                'thread_id' => $latest_record->thread_id,
                'chat_data' => $chat_data,
            ]);
        }

        return redirect(route('ai.index'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        SendPrompt::dispatch($id, auth()->id(), $request->thread_id, $request->messages);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('ai_chats')->where('id', $id)->delete();

        return back();
    }

    /**
     * Create an instant quiz.
     */
    public function generateQuiz()
    {
        if(Auth::check()){
            $ulid = Str::ulid();
            $user_id = Auth::id();

            DB::table('ai_chats')->insert([
                'id' => (string)$ulid,
                'user_id' => $user_id,
                'name' => 'Generate random quiz'
            ]);

            GenerateQuiz::dispatch($ulid);

            return response()->json($ulid);
        }

        return redirect()->route('login');
    }
}
