<?php

namespace App\Http\Controllers;

use App\Enums\AiChatMessageStatus;
use App\Jobs\Ai\CreateChat;
use App\Jobs\Ai\SendPrompt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = DB::table('ai_chats')->select('id', 'name')->get();
        $programmes = DB::table('ai_programmes')->get();
        $user_has_children   =   collect(DB::table('children')
                                ->leftJoin('students', 'students.children_id', '=', 'children.id')
                                ->leftJoin('genders', 'children.gender_id', '=', 'genders.id')
                                ->where('parent_id', Auth::id())
                                ->select('students.id as student_id', 'children.id as child_id', 'children.name as child_name', 'genders.name as child_gender', 'children.date_of_birth as child_dob')
                                ->get());
                                           
        $children_classes   =   collect(DB::table('student_fees')
                                ->leftJoin('programme_level_fees', 'student_fees.fee_id', '=', 'programme_level_fees.id')
                                ->leftJoin('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                                ->leftJoin('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                                ->whereIn('student_fees.student_id', $user_has_children->pluck('student_id'))
                                ->whereYear('student_fees.created_at', Carbon::now()->format('Y'))
                                ->whereMonth('student_fees.created_at', Carbon::now()->format('m'))
                                ->whereNull('student_fees.status')
                                ->select('student_fees.student_id as student_id', 'programmes.id as programme_id', 'programmes.name as programme_name')
                                ->get());

        return Inertia::render('AiChat/Index', [
            'chats'             => $chats,
            'programmes'        => $programmes,
            'user_has_children' => $user_has_children,
            'children_classes'  => $children_classes,
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
                CreateChat::dispatchSync($id, Auth::id(), $latest_record->prompt);
                DB::table('ai_chat_messages')->where('id', $latest_record->id)->update([
                    'status' => AiChatMessageStatus::PROCESSING
                ]);
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
        SendPrompt::dispatch($id, Auth::id(), $request->thread_id, $request->messages);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('ai_chats')->where('id', $id)->delete();

        return back();
    }
}
