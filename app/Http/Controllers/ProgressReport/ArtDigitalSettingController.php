<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ArtDigitalSettingController extends Controller
{
    /* Art Digital Levels*/
    public function artDigitalLevels(){
        $levels     =   DB::table('pr_art_digital_levels')->get();
        return Inertia::render('ProgressReport/Settings/ArtDigital/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function artDigitalLevelsStore(Request $request){
        $level   =   DB::table('pr_art_digital_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report art digital level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artDigitalLevelsUpdate(Request $request){
        DB::table('pr_art_digital_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report art digital level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artDigitalLevelsDestroy($id){
        DB::table('pr_art_digital_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art digital level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Digital Levels */
    
    /* Art Digital Themes*/
    public function artDigitalThemes(Request $request){
        $themes     =   DB::table('pr_art_digital_themes')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtDigital/Themes', [
            'level_id'      =>      $request->level_id,
            'themes'       =>      $themes
        ]);
    }

    public function artDigitalThemesStore(Request $request){
        $theme   =   DB::table('pr_art_digital_themes')->insertGetId([
            'level_id'  =>  $request->level_id,
            'name'      =>  $request->theme_name
        ]);
        $log_data =   'Added progress report art digital theme ID '.$theme;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artDigitalThemesUpdate(Request $request)
    {
        DB::table('pr_art_digital_themes')->where('id', $request->id)->update([
            'name'  => $request->theme_name
        ]);
        $log_data =   'Updated progress report art digital theme ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artDigitalThemesDestroy($id){
        DB::table('pr_art_digital_themes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art digital theme ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Digital Themes */
    
    /* Art Digital Lessons*/
    public function artDigitalLessons(Request $request){
        $lessons     =   DB::table('pr_art_digital_lessons')->where('theme_id', $request->theme_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtDigital/Lessons', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lessons'       =>      $lessons
        ]);
    }

    public function artDigitalLessonsStore(Request $request){
        $lesson   =   DB::table('pr_art_digital_lessons')->insertGetId([
            'theme_id'  =>  $request->theme_id,
            'name'      =>  $request->lesson_name
        ]);
        $log_data =   'Added progress report art digital lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artDigitalLessonsUpdate(Request $request){
        DB::table('pr_art_digital_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report art digital lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artDigitalLessonsDestroy($id){
        DB::table('pr_art_digital_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art digital lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Digital Lessons */
    
    /* Art Digital Activities*/
    public function artDigitalActivities(Request $request){
        $activities     =   DB::table('pr_art_digital_activities')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtDigital/Activities', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activities'    =>      $activities
        ]);
    }

    public function artDigitalActivitiesStore(Request $request){
        $activity   =   DB::table('pr_art_digital_activities')->insertGetId([
            'lesson_id' =>  $request->lesson_id,
            'name'      =>  $request->activity_name
        ]);
        $log_data =   'Added progress report art digital activity ID '.$activity;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artDigitalActivitiesUpdate(Request $request){
        DB::table('pr_art_digital_activities')->where('id', $request->id)->update([
            'name'  => $request->activity_name
        ]);
        $log_data =   'Updated progress report art digital activity ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artDigitalActivitiesDestroy($id){
        DB::table('pr_art_digital_activities')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art digital activity ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Digital Activities */
    
    /* Art Digital Outcomes*/
    public function artDigitalOutcomes(Request $request){
        $outcomes     =   DB::table('pr_art_digital_outcomes')->where('activity_id', $request->activity_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtDigital/Outcomes', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activity_id'   =>      $request->activity_id,
            'outcomes'      =>      $outcomes
        ]);
    }

    public function artDigitalOutcomesStore(Request $request){
        $outcome   =   DB::table('pr_art_digital_outcomes')->insertGetId([
            'activity_id'   =>  $request->activity_id,
            'name'          =>  $request->outcome_name
        ]);
        $log_data =   'Added progress report art digital outcome ID '.$outcome;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artDigitalOutcomesUpdate(Request $request){
        DB::table('pr_art_digital_outcomes')->where('id', $request->id)->update([
            'name'  => $request->outcome_name
        ]);
        $log_data =   'Updated progress report art digital outcome ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artDigitalOutcomesDestroy($id){
        DB::table('pr_art_digital_outcomes')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art digital outcome ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Digital Outcomes */
    
    /* Art Digital Objectives*/
    public function artDigitalObjectives(Request $request){
        $objectives     =   DB::table('pr_art_digital_objectives')->where('outcome_id', $request->outcome_id)->get();
        return Inertia::render('ProgressReport/Settings/ArtDigital/Objectives', [
            'level_id'      =>      $request->level_id,
            'theme_id'      =>      $request->theme_id,
            'lesson_id'     =>      $request->lesson_id,
            'activity_id'   =>      $request->activity_id,
            'outcome_id'    =>      $request->outcome_id,
            'objectives'    =>      $objectives
        ]);
    }

    public function artDigitalObjectivesStore(Request $request){
        $objective   =   DB::table('pr_art_digital_objectives')->insertGetId([
            'outcome_id'    =>  $request->outcome_id,
            'name'          =>  $request->objective_name
        ]);
        $log_data =   'Added progress report art digital objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function artDigitalObjectivesUpdate(Request $request){
        DB::table('pr_art_digital_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report art digital objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function artDigitalObjectivesDestroy($id){
        DB::table('pr_art_digital_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report art digital objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Art Digital Objectives */
    
}
