<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CodingRoboticSettingController extends Controller
{
    /* Coding Robotics Levels*/
    public function codingRoboticsLevels(){
        $levels     =   DB::table('pr_coding_levels')->get();
        return Inertia::render('ProgressReport/Settings/CodingRobotics/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function codingRoboticsLevelsStore(Request $request){
        $level   =   DB::table('pr_coding_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report coding robotics level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function codingRoboticsLevelsUpdate(Request $request){
        DB::table('pr_coding_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report coding robotics level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function codingRoboticsLevelsDestroy($id){
        DB::table('pr_coding_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report coding robotics level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Coding Robotics Levels */
    
    /* Coding Robotics Lessons*/
    public function codingRoboticsLessons(Request $request){
        $lessons     =   DB::table('pr_coding_lessons')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/CodingRobotics/Lessons', [
            'level_id'      =>      $request->level_id,
            'lessons'       =>      $lessons
        ]);
    }

    public function codingRoboticsLessonsStore(Request $request){
        $lesson   =   DB::table('pr_coding_lessons')->insertGetId([
            'level_id'  =>  $request->level_id,
            'name'      =>  $request->lesson_name
        ]);
        $log_data =   'Added progress report coding robotics lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function codingRoboticsLessonsUpdate(Request $request){
        DB::table('pr_coding_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report coding robotics lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function codingRoboticsLessonsDestroy($id){
        DB::table('pr_coding_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report coding robotics lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Coding Robotics Lessons */
    
    /* Coding Robotics Topics*/
    public function codingRoboticsTopics(Request $request){
        $topics     =   DB::table('pr_coding_topics')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/CodingRobotics/Topics', [
            'level_id'  =>  $request->level_id,
            'lesson_id' =>  $request->lesson_id,
            'topics'   =>  $topics
        ]);
    }

    public function codingRoboticsTopicsStore(Request $request){
        $topic   =   DB::table('pr_coding_topics')->insertGetId([
            'lesson_id' =>  $request->lesson_id,
            'name'      =>  $request->topic_name
        ]);
        $log_data =   'Added progress report coding robotics topic ID '.$topic;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function codingRoboticsTopicsUpdate(Request $request){
        DB::table('pr_coding_topics')->where('id', $request->id)->update([
            'name'  => $request->topic_name
        ]);
        $log_data =   'Updated progress report coding robotics topic ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function codingRoboticsTopicsDestroy($id){
        DB::table('pr_coding_topics')->where('id', $id)->delete();

        $log_data =   'Deleted progress report coding robotics topic ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Coding Robotics Topics */
    
    /* Coding Robotics Objectives*/
    public function codingRoboticsObjectives(Request $request){
        $objectives     =   DB::table('pr_coding_objectives')->where('topic_id', $request->topic_id)->get();
        return Inertia::render('ProgressReport/Settings/CodingRobotics/Objectives', [
            'level_id'      =>  $request->level_id,
            'lesson_id'     =>  $request->lesson_id,
            'topic_id'      =>  $request->topic_id,
            'objectives'    =>  $objectives
        ]);
    }

    public function codingRoboticsObjectivesStore(Request $request){
        $objective   =   DB::table('pr_coding_objectives')->insertGetId([
            'topic_id'  =>  $request->topic_id,
            'name'      =>  $request->objective_name
        ]);
        $log_data =   'Added progress report coding robotics objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function codingRoboticsObjectivesUpdate(Request $request){
        DB::table('pr_coding_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report coding robotics objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function codingRoboticsObjectivesDestroy($id){
        DB::table('pr_coding_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report coding robotics objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Coding Robotics Objectives */
    
    /* Coding Robotics Activities Procedures*/
    public function codingRoboticsActivitiesProcedures(Request $request){
        $activities_procedures     =   DB::table('pr_coding_activities_procedures')->where('objective_id', $request->objective_id)->get();
        return Inertia::render('ProgressReport/Settings/CodingRobotics/ActivitiesProcedures', [
            'level_id'              =>  $request->level_id,
            'lesson_id'             =>  $request->lesson_id,
            'topic_id'              =>  $request->topic_id,
            'objective_id'          =>  $request->objective_id,
            'activities_procedures' =>  $activities_procedures
        ]);
    }

    public function codingRoboticsActivitiesProceduresStore(Request $request){
        $activity_procedure   =   DB::table('pr_coding_activities_procedures')->insertGetId([
            'objective_id'  =>  $request->objective_id,
            'name'          =>  $request->activity_procedure_name
        ]);
        $log_data =   'Added progress report coding robotics activity procedure ID '.$activity_procedure;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function codingRoboticsActivitiesProceduresUpdate(Request $request){
        DB::table('pr_coding_activities_procedures')->where('id', $request->id)->update([
            'name'  => $request->activity_procedure_name
        ]);
        $log_data =   'Updated progress report coding robotics activity procedure ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function codingRoboticsActivitiesProceduresDestroy($id){
        DB::table('pr_coding_activities_procedures')->where('id', $id)->delete();

        $log_data =   'Deleted progress report coding robotics activity procedure ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Coding Robotics Activities Procedures */

}
