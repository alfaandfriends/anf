<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LittleArtistSettingController extends Controller
{
    /* Little Artist Levels*/
    public function littleArtistLevels(){
        $levels     =   DB::table('pr_little_artist_levels')->get();
        return Inertia::render('ProgressReport/Settings/LittleArtist/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function littleArtistLevelsStore(Request $request){
        $level   =   DB::table('pr_little_artist_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report little artist level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleArtistLevelsUpdate(Request $request){
        DB::table('pr_little_artist_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report little artist level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleArtistLevelsDestroy($id){
        DB::table('pr_little_artist_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little artist level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Artist Levels */
    
    /* Little Artist Lessons*/
    public function littleArtistLessons(Request $request){
        $lessons     =   DB::table('pr_little_artist_lessons')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/LittleArtist/Lessons', [
            'level_id'      =>      $request->level_id,
            'lessons'       =>      $lessons
        ]);
    }

    public function littleArtistLessonsStore(Request $request){
        $lesson   =   DB::table('pr_little_artist_lessons')->insertGetId([
            'level_id'  =>  $request->level_id,
            'name'      =>  $request->lesson_name
        ]);
        $log_data =   'Added progress report little artist lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleArtistLessonsUpdate(Request $request){
        DB::table('pr_little_artist_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report little artist lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleArtistLessonsDestroy($id){
        DB::table('pr_little_artist_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little artist lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Artist Lessons */
    
    /* Little Artist Outcomes*/
    public function littleArtistOutcomes(Request $request){
        $outcomes     =   DB::table('pr_little_artist_outcomes')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/LittleArtist/Outcomes', [
            'level_id'  =>  $request->level_id,
            'lesson_id' =>  $request->lesson_id,
            'outcomes'   =>  $outcomes
        ]);
    }

    public function littleArtistOutcomesStore(Request $request){
        $outcome   =   DB::table('pr_little_artist_outcomes')->insertGetId([
            'lesson_id' =>  $request->lesson_id,
            'name'      =>  $request->outcome_name
        ]);
        $log_data =   'Added progress report little artist outcome ID '.$outcome;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleArtistOutcomesUpdate(Request $request){
        DB::table('pr_little_artist_outcomes')->where('id', $request->id)->update([
            'name'  => $request->outcome_name
        ]);
        $log_data =   'Updated progress report little artist outcome ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleArtistOutcomesDestroy($id){
        DB::table('pr_little_artist_outcomes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little artist outcome ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Artist Outcomes */
    
    /* Little Artist Objectives*/
    public function littleArtistObjectives(Request $request){
        $objectives     =   DB::table('pr_little_artist_objectives')->where('outcome_id', $request->outcome_id)->get();
        return Inertia::render('ProgressReport/Settings/LittleArtist/Objectives', [
            'level_id'      =>  $request->level_id,
            'lesson_id'     =>  $request->lesson_id,
            'outcome_id'      =>  $request->outcome_id,
            'objectives'    =>  $objectives
        ]);
    }

    public function littleArtistObjectivesStore(Request $request){
        $objective   =   DB::table('pr_little_artist_objectives')->insertGetId([
            'outcome_id'  =>  $request->outcome_id,
            'name'      =>  $request->objective_name
        ]);
        $log_data =   'Added progress report little artist objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function littleArtistObjectivesUpdate(Request $request){
        DB::table('pr_little_artist_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report little artist objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function littleArtistObjectivesDestroy($id){
        DB::table('pr_little_artist_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report little artist objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Little Artist Objectives */
}
