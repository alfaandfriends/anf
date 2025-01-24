<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DigitalArtSettingController extends Controller
{
    /* Digital Art Levels*/
    public function digitalArtLevels(){
        $levels     =   DB::table('pr_art_levels')->get();
        return Inertia::render('ProgressReport/Settings/DigitalArt/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function digitalArtLevelsStore(Request $request){
        $level   =   DB::table('pr_art_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report digital art level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function digitalArtLevelsUpdate(Request $request){
        DB::table('pr_art_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report digital art level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function digitalArtLevelsDestroy($id){
        DB::table('pr_art_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report digital art level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Digital Art Levels */
    
    /* Digital Art Themes*/
    public function digitalArtThemes(Request $request){
        $themes     =   DB::table('pr_art_themes')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/DigitalArt/Themes', [
            'level_id'      =>      $request->level_id,
            'themes'       =>      $themes
        ]);
    }

    public function digitalArtThemesStore(Request $request){
        $theme   =   DB::table('pr_art_themes')->insertGetId([
            'level_id'  =>  $request->level_id,
            'name'      =>  $request->theme_name
        ]);
        $log_data =   'Added progress report digital art theme ID '.$theme;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function digitalArtThemesUpdate(Request $request)
    {
        DB::table('pr_art_themes')->where('id', $request->id)->update([
            'name'  => $request->theme_name
        ]);
        $log_data =   'Updated progress report digital art theme ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function digitalArtThemesDestroy($id){
        DB::table('pr_art_themes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report digital art theme ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Digital Art Themes */
    
    /* Digital Art Lessons*/
    public function digitalArtLessons(Request $request){
        $lessons     =   DB::table('pr_art_lessons')->where('theme_id', $request->theme_id)->get();
        return Inertia::render('ProgressReport/Settings/DigitalArt/Lessons', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lessons'       =>      $lessons
        ]);
    }

    public function digitalArtLessonsStore(Request $request){
        $lesson   =   DB::table('pr_art_lessons')->insertGetId([
            'theme_id'  =>  $request->theme_id,
            'name'      =>  $request->lesson_name
        ]);
        $log_data =   'Added progress report digital art lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function digitalArtLessonsUpdate(Request $request){
        DB::table('pr_art_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report digital art lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function digitalArtLessonsDestroy($id){
        DB::table('pr_art_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report digital art lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Digital Art Lessons */
    
    /* Digital Art Activities*/
    public function digitalArtActivities(Request $request){
        $activities     =   DB::table('pr_art_activities')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/DigitalArt/Activities', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activities'    =>      $activities
        ]);
    }

    public function digitalArtActivitiesStore(Request $request){
        $activity   =   DB::table('pr_art_activities')->insertGetId([
            'lesson_id' =>  $request->lesson_id,
            'name'      =>  $request->activity_name
        ]);
        $log_data =   'Added progress report digital art activity ID '.$activity;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function digitalArtActivitiesUpdate(Request $request){
        DB::table('pr_art_activities')->where('id', $request->id)->update([
            'name'  => $request->activity_name
        ]);
        $log_data =   'Updated progress report digital art activity ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function digitalArtActivitiesDestroy($id){
        DB::table('pr_art_activities')->where('id', $id)->delete();

        $log_data =   'Deleted progress report digital art activity ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Digital Art Activities */
    
    /* Digital Art Outcomes*/
    public function digitalArtOutcomes(Request $request){
        $outcomes     =   DB::table('pr_art_outcomes')->where('activity_id', $request->activity_id)->get();
        return Inertia::render('ProgressReport/Settings/DigitalArt/Outcomes', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activity_id'   =>      $request->activity_id,
            'outcomes'      =>      $outcomes
        ]);
    }

    public function digitalArtOutcomesStore(Request $request){
        $outcome   =   DB::table('pr_art_outcomes')->insertGetId([
            'activity_id'   =>  $request->activity_id,
            'name'          =>  $request->outcome_name
        ]);
        $log_data =   'Added progress report digital art outcome ID '.$outcome;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function digitalArtOutcomesUpdate(Request $request){
        DB::table('pr_art_outcomes')->where('id', $request->id)->update([
            'name'  => $request->outcome_name
        ]);
        $log_data =   'Updated progress report digital art outcome ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function digitalArtOutcomesDestroy($id){
        DB::table('pr_art_outcomes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report digital art outcome ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Digital Art Outcomes */
    
    /* Digital Art Objectives*/
    public function digitalArtObjectives(Request $request){
        $objectives     =   DB::table('pr_art_objectives')->where('outcome_id', $request->outcome_id)->get();
        return Inertia::render('ProgressReport/Settings/DigitalArt/Objectives', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activity_id'   =>      $request->activity_id,
            'outcome_id'    =>      $request->outcome_id,
            'objectives'    =>      $objectives
        ]);
    }

    public function digitalArtObjectivesStore(Request $request){
        $objective   =   DB::table('pr_art_objectives')->insertGetId([
            'outcome_id'    =>  $request->outcome_id,
            'name'          =>  $request->objective_name
        ]);
        $log_data =   'Added progress report digital art objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function digitalArtObjectivesUpdate(Request $request){
        DB::table('pr_art_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report digital art objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function digitalArtObjectivesDestroy($id){
        DB::table('pr_art_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report digital art objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Digital Art Objectives */
    
}
