<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ArtTraditionalSettingController extends Controller
{
    /* Art Traditional Levels*/
    public function artTraditionalLevels(){
        $levels     =   DB::table('pr_art_traditional_levels')->get();
        return Inertia::render('ProgressReport/Settings/ArtTraditional/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function artTraditionalLevelsStore(Request $request){
        $level   =   DB::table('pr_art_traditional_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report art traditional level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artTraditionalLevelsUpdate(Request $request){
        DB::table('pr_art_traditional_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report art traditional level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artTraditionalLevelsDestroy($id){
        DB::table('pr_art_traditional_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art traditional level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Traditional Levels */
    
    /* Art Traditional Themes*/
    public function artTraditionalThemes(Request $request){
        $themes     =   DB::table('pr_art_traditional_themes')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtTraditional/Themes', [
            'level_id'      =>      $request->level_id,
            'themes'       =>      $themes
        ]);
    }

    public function artTraditionalThemesStore(Request $request){
        $theme   =   DB::table('pr_art_traditional_themes')->insertGetId([
            'level_id'  =>  $request->level_id,
            'name'      =>  $request->theme_name
        ]);
        $log_data =   'Added progress report art traditional theme ID '.$theme;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artTraditionalThemesUpdate(Request $request)
    {
        DB::table('pr_art_traditional_themes')->where('id', $request->id)->update([
            'name'  => $request->theme_name
        ]);
        $log_data =   'Updated progress report art traditional theme ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artTraditionalThemesDestroy($id){
        DB::table('pr_art_traditional_themes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art traditional theme ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Traditional Themes */
    
    /* Art Traditional Lessons*/
    public function artTraditionalLessons(Request $request){
        $lessons     =   DB::table('pr_art_traditional_lessons')->where('theme_id', $request->theme_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtTraditional/Lessons', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lessons'       =>      $lessons
        ]);
    }

    public function artTraditionalLessonsStore(Request $request){
        $lesson   =   DB::table('pr_art_traditional_lessons')->insertGetId([
            'theme_id'  =>  $request->theme_id,
            'name'      =>  $request->lesson_name
        ]);
        $log_data =   'Added progress report art traditional lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artTraditionalLessonsUpdate(Request $request){
        DB::table('pr_art_traditional_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report art traditional lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artTraditionalLessonsDestroy($id){
        DB::table('pr_art_traditional_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art traditional lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Traditional Lessons */
    
    /* Art Traditional Activities*/
    public function artTraditionalActivities(Request $request){
        $activities     =   DB::table('pr_art_traditional_activities')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtTraditional/Activities', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activities'    =>      $activities
        ]);
    }

    public function artTraditionalActivitiesStore(Request $request){
        $activity   =   DB::table('pr_art_traditional_activities')->insertGetId([
            'lesson_id' =>  $request->lesson_id,
            'name'      =>  $request->activity_name
        ]);
        $log_data =   'Added progress report art traditional activity ID '.$activity;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artTraditionalActivitiesUpdate(Request $request){
        DB::table('pr_art_traditional_activities')->where('id', $request->id)->update([
            'name'  => $request->activity_name
        ]);
        $log_data =   'Updated progress report art traditional activity ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artTraditionalActivitiesDestroy($id){
        DB::table('pr_art_traditional_activities')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art traditional activity ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Traditional Activities */
    
    /* Art Traditional Outcomes*/
    public function artTraditionalOutcomes(Request $request){
        $outcomes     =   DB::table('pr_art_traditional_outcomes')->where('activity_id', $request->activity_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtTraditional/Outcomes', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activity_id'   =>      $request->activity_id,
            'outcomes'      =>      $outcomes
        ]);
    }

    public function artTraditionalOutcomesStore(Request $request){
        $outcome   =   DB::table('pr_art_traditional_outcomes')->insertGetId([
            'activity_id'   =>  $request->activity_id,
            'name'          =>  $request->outcome_name
        ]);
        $log_data =   'Added progress report art traditional outcome ID '.$outcome;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artTraditionalOutcomesUpdate(Request $request){
        DB::table('pr_art_traditional_outcomes')->where('id', $request->id)->update([
            'name'  => $request->outcome_name
        ]);
        $log_data =   'Updated progress report art traditional outcome ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artTraditionalOutcomesDestroy($id){
        DB::table('pr_art_traditional_outcomes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art traditional outcome ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Traditional Outcomes */
    
    /* Art Traditional Objectives*/
    public function artTraditionalObjectives(Request $request){
        $objectives     =   DB::table('pr_art_traditional_objectives')->where('outcome_id', $request->outcome_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtTraditional/Objectives', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activity_id'   =>      $request->activity_id,
            'outcome_id'    =>      $request->outcome_id,
            'objectives'    =>      $objectives
        ]);
    }

    public function artTraditionalObjectivesStore(Request $request){
        $objective   =   DB::table('pr_art_traditional_objectives')->insertGetId([
            'outcome_id'    =>  $request->outcome_id,
            'name'          =>  $request->objective_name
        ]);
        $log_data =   'Added progress report art traditional objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artTraditionalObjectivesUpdate(Request $request){
        DB::table('pr_art_traditional_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report art traditional objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artTraditionalObjectivesDestroy($id){
        DB::table('pr_art_traditional_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art traditional objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Traditional Objectives */
    
}
