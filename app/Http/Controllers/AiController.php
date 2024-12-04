<?php

namespace App\Http\Controllers;

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
        $threads = DB::table('ai_chats')->select('id', 'name', 'thread_id', 'run_id')->get();

        return Inertia::render('AiChat/Index', [
            'threads'   => $threads,
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
        $chatId = $request->form['chat_id'];
        $threadId = $request->form['thread_id'];
        $messages = $request->form['messages'];
        
        if(Auth::check() && !$threadId){
            $ulid = Str::ulid();
            $user_id = Auth::id();

            DB::table('ai_chats')->insert([
                'id' => (string)$ulid,
                'user_id' => $user_id,
                'name' => $messages
            ]);

            InitiateChat::dispatch($ulid, $messages);

            return response()->json($ulid);
        }

        SendPrompt::dispatch($chatId, $threadId, $messages);
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
        $threads = DB::table('ai_chats')->select('id', 'name', 'thread_id', 'run_id')->get();
        $chat_data = DB::table('ai_chats')->where('user_id', Auth::id())->where('id', $id)->first();
        
        if($chat_data){
            return Inertia::render('AiChat/Index', [
                'threads'   => $threads,
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
        //
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
