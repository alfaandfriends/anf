<?php

namespace App\Http\Controllers\ProgressReport;

use App\Events\DatabaseTransactionEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MathSettingController extends Controller
{
    /* Math Levels */
    public function mathLevels(){
        $levels     =   DB::table('pr_math_levels')->get();
        return Inertia::render('ProgressReport/Settings/Math/Levels', [
            'levels'    =>  $levels
        ]);
    }

    public function mathLevelsStore(Request $request){
        $level   =   DB::table('pr_math_levels')->insertGetId([
            'name'      => $request->level_name
        ]);
        $log_data =   'Added progress report math level ID '.$level;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function mathLevelsUpdate(Request $request){
        DB::table('pr_math_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated progress report math level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function mathLevelsDestroy($id){
        DB::table('pr_math_levels')->where('id', $id)->delete();

        $log_data =   'Deleted progress report math level ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Math Levels */
    
    /* Math Terms Books*/
    public function mathTermsBooks(Request $request){
        $terms_books     =   DB::table('pr_math_terms_books')->where('level_id', $request->level_id)->get();
        return Inertia::render('ProgressReport/Settings/Math/TermsBooks', [
            'level_id'       =>     $request->level_id,
            'terms_books'    =>     $terms_books
        ]);
    }

    public function mathTermsBooksStore(Request $request){
        $term_book   =   DB::table('pr_math_terms_books')->insertGetId([
            'level_id'  => $request->level_id,
            'name'      => $request->term_book_name
        ]);
        $log_data =   'Added progress report math term book ID '.$term_book;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function mathTermsBooksUpdate(Request $request){
        DB::table('pr_math_terms_books')->where('id', $request->id)->update([
            'name'  => $request->term_book_name
        ]);
        $log_data =   'Updated progress report math term book ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function mathTermsBooksDestroy($id){
        DB::table('pr_math_terms_books')->where('id', $id)->delete();

        $log_data =   'Deleted progress report math term book ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Math Terms Books */
    
    /* Math Units*/
    public function mathUnits(Request $request){
        $units     =   DB::table('pr_math_units')->where('term_book_id', $request->term_book_id)->get();
        return Inertia::render('ProgressReport/Settings/Math/Units', [
            'level_id'      =>     $request->level_id,
            'term_book_id'  =>     $request->term_book_id,
            'units'         =>     $units
        ]);
    }

    public function mathUnitsStore(Request $request){
        $unit   =   DB::table('pr_math_units')->insertGetId([
            'term_book_id'  => $request->term_book_id,
            'name'          => $request->unit_name
        ]);
        $log_data =   'Added progress report math unit ID '.$unit;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function mathUnitsUpdate(Request $request){
        DB::table('pr_math_units')->where('id', $request->id)->update([
            'name'  => $request->unit_name
        ]);
        $log_data =   'Updated progress report math unit ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function mathUnitsDestroy($id){
        DB::table('pr_math_units')->where('id', $id)->delete();

        $log_data =   'Deleted progress report math unit ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Math Units */
    
    /* Math Lessons*/
    public function mathLessons(Request $request){
        $lessons     =   DB::table('pr_math_lessons')->where('unit_id', $request->unit_id)->get();
        return Inertia::render('ProgressReport/Settings/Math/Lessons', [
            'level_id'      =>     $request->level_id,
            'term_book_id'  =>     $request->term_book_id,
            'unit_id'       =>     $request->unit_id,
            'lessons'       =>     $lessons
        ]);
    }

    public function mathLessonsStore(Request $request){
        $lesson   =   DB::table('pr_math_lessons')->insertGetId([
            'unit_id'   => $request->unit_id,
            'name'      => $request->lesson_name
        ]);
        $log_data =   'Added progress report math lesson ID '.$lesson;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function mathLessonsUpdate(Request $request){
        DB::table('pr_math_lessons')->where('id', $request->id)->update([
            'name'  => $request->lesson_name
        ]);
        $log_data =   'Updated progress report math lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function mathLessonsDestroy($id){
        DB::table('pr_math_lessons')->where('id', $id)->delete();

        $log_data =   'Deleted progress report math lesson ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Math Lessons */
    
    /* Math Objectives*/
    public function mathObjectives(Request $request){
        $objectives     =   DB::table('pr_math_objectives')->where('lesson_id', $request->lesson_id)->get();
        return Inertia::render('ProgressReport/Settings/Math/Objectives', [
            'level_id'      =>     $request->level_id,
            'term_book_id'  =>     $request->term_book_id,
            'unit_id'       =>     $request->unit_id,
            'lesson_id'     =>     $request->lesson_id,
            'objectives'    =>     $objectives
        ]);
    }

    public function mathObjectivesStore(Request $request){
        $objective   =   DB::table('pr_math_objectives')->insertGetId([
            'lesson_id' => $request->lesson_id,
            'name'      => $request->objective_name
        ]);
        $log_data =   'Added progress report math objective ID '.$objective;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been added.']);
    }

    public function mathObjectivesUpdate(Request $request){
        DB::table('pr_math_objectives')->where('id', $request->id)->update([
            'name'  => $request->objective_name
        ]);
        $log_data =   'Updated progress report math objective ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been saved.']);
    }

    public function mathObjectivesDestroy($id){
        DB::table('pr_math_objectives')->where('id', $id)->delete();

        $log_data =   'Deleted progress report math objective ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
    }
    /* Math Objectives */

}
