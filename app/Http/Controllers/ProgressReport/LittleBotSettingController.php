<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LittleBotSettingController extends Controller
{
    /* Little Bot Levels*/
    public function littleBotLevels(){
        $levels     =   DB::table('pr_little_bot_levels')->get();
        return Inertia::render('ProgressReport/Settings/LittleBot/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function littleBotLevelsStore(Request $request){
        $level   =   DB::table('pr_little_bot_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report little bot level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleBotLevelsUpdate(Request $request){
        DB::table('pr_little_bot_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report little bot level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleBotLevelsDestroy($id){
        DB::table('pr_little_bot_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little bot level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Bot Levels */
    
    /* Little Bot Lessons*/
    public function littleBotLessons(Request $request){
        $lessons     =   DB::table('pr_little_bot_lessons')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/LittleBot/Lessons', [
            'level_id'      =>      $request->level_id,
            'lessons'       =>      $lessons
        ]);
    }

    public function littleBotLessonsStore(Request $request){
        $lesson   =   DB::table('pr_little_bot_lessons')->insertGetId([
            'level_id'  =>  $request->level_id,
            'name'      =>  $request->lesson_name
        ]);
        $log_data =   'Added progress report little bot lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleBotLessonsUpdate(Request $request){
        DB::table('pr_little_bot_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report little bot lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleBotLessonsDestroy($id){
        DB::table('pr_little_bot_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little bot lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Bot Lessons */
    
    /* Little Bot Topics*/
    public function littleBotTopics(Request $request){
        $topics     =   DB::table('pr_little_bot_topics')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/LittleBot/Topics', [
            'level_id'  =>  $request->level_id,
            'lesson_id' =>  $request->lesson_id,
            'topics'   =>  $topics
        ]);
    }

    public function littleBotTopicsStore(Request $request){
        $topic   =   DB::table('pr_little_bot_topics')->insertGetId([
            'lesson_id' =>  $request->lesson_id,
            'name'      =>  $request->topic_name
        ]);
        $log_data =   'Added progress report little bot topic ID '.$topic;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleBotTopicsUpdate(Request $request){
        DB::table('pr_little_bot_topics')->where('id', $request->id)->update([
            'name'  => $request->topic_name
        ]);
        $log_data =   'Updated progress report little bot topic ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleBotTopicsDestroy($id){
        DB::table('pr_little_bot_topics')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little bot topic ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Bot Topics */
    
    /* Little Bot Objectives*/
    public function littleBotObjectives(Request $request){
        $objectives     =   DB::table('pr_little_bot_objectives')->where('topic_id', $request->topic_id)->get();
        return Inertia::render('ProgressReport/Settings/LittleBot/Objectives', [
            'level_id'      =>  $request->level_id,
            'lesson_id'     =>  $request->lesson_id,
            'topic_id'      =>  $request->topic_id,
            'objectives'    =>  $objectives
        ]);
    }

    public function littleBotObjectivesStore(Request $request){
        $objective   =   DB::table('pr_little_bot_objectives')->insertGetId([
            'topic_id'  =>  $request->topic_id,
            'name'      =>  $request->objective_name
        ]);
        $log_data =   'Added progress report little bot objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleBotObjectivesUpdate(Request $request){
        DB::table('pr_little_bot_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report little bot objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleBotObjectivesDestroy($id){
        DB::table('pr_little_bot_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little bot objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Bot Objectives */
}
