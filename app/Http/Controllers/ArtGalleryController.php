<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $levels     =   $this->getLevels();
        $themes     =   $this->getThemes();
        $results    =   DB::table('student_art_gallery')
                            ->join('art_levels', 'student_art_gallery.level_id', '=', 'art_levels.id')
                            ->join('art_themes', 'student_art_gallery.theme_id', '=', 'art_themes.id')
                            ->join('art_lessons', 'student_art_gallery.lesson_id', '=', 'art_lessons.id')
                            ->join('art_activities', 'student_art_gallery.activity_id', '=', 'art_activities.id')
                            ->leftJoin('students', 'student_art_gallery.student_id', '=', 'students.id')
                            ->leftJoin('children', 'students.children_id', '=', 'children.id')
                            ->when(request('search'), function($query, $search) {
                                $query->where(function ($q) use ($search) {
                                    $q->where('children.name', 'LIKE', "%$search%");
                                });
                            })
                            ->when(request('level'), function($query) {
                                $query->where('art_levels.id', request('level'));
                            })
                            ->when(request('theme'), function($query) {
                                $query->where('art_themes.id', request('theme'));
                            })
                            ->select(
                                'student_art_gallery.id as artwork_id',
                                'students.id as student_id',
                                'children.name as student_name',
                                'student_art_gallery.filename as art_file_location',
                                'art_levels.name as level',
                                'art_themes.name as theme',
                                'art_lessons.name as lesson',
                                'art_activities.name as activity',
                            )
                            ->orderBy('student_art_gallery.id')
                            ->orderBy('art_levels.id')
                            ->orderBy('art_themes.id')
                            ->orderBy('art_lessons.id')
                            ->orderBy('art_activities.id')
                            ->paginate(10);

        return Inertia::render('ArtGallery/Index', [
            'filter'    =>  request()->all('search', 'level', 'theme'),
            'levels'    =>  $levels,
            'themes'    =>  $themes,
            'arts'      =>  $results,
        ]);
    }

    public function create()
    {
        $levels =   DB::table('art_levels')->get();
        $themes =   DB::table('art_themes')->where('level_id', 1)->get();

        return Inertia::render('ArtGallery/Create',[
            'levels'  => $levels,
            'themes'  => $themes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'    => 'required',
            'level_id'      => 'required',
            'theme_id'      => 'required',
            'lesson_id'     => 'required',
            'activity_id'   => 'required',
            'artwork.file'  => 'required|file',
        ]);

        $file = $request->file('artwork.file');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        DB::table('student_art_gallery')->insert([
            'student_id'    => $request->student_id,
            'level_id'      => $request->level_id,
            'theme_id'      => $request->theme_id,
            'lesson_id'     => $request->lesson_id,
            'activity_id'   => $request->activity_id,
            'filename'      => $filename,
        ]);

        Storage::putFileAs('art_gallery',$file, $filename);

        $log_data =   'Added artwork for student ID '.$request->student_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('art_gallery'))->with(['type'=>'success', 'message'=>'Artwork uploaded successfully !']);
    }

    public function destroy($id)
    {
        $artwork_info   =   DB::table('student_art_gallery')->where('id', $id)->first();
        $file_deleted   =   Storage::delete('art_gallery/'.$artwork_info->filename);
        $record_deleted =   DB::table('student_art_gallery')->where('id', $id)->delete();

        if($record_deleted){
            return redirect(route('art_gallery'))->with(['type'=>'success', 'message'=>'Artwork deleted successfully !']);
        }
        $log_data =   'Deleted artwork ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('art_gallery'))->with(['type'=>'danger', 'message'=>'An error occured, please try again !']);

    }

    public function levels(){
        $levels = $this->getLevels();

        return Inertia::render('ArtGallery/Setting/Levels', [
            'levels' => $levels,
        ]);
    }

    public function themes(Request $request){
        $themes = $this->getThemes($request->level_id);

        return Inertia::render('ArtGallery/Setting/Themes', [
            'level_id'  => $request->level_id,
            'themes'    => $themes,
        ]);
    }

    public function lessons(Request $request){
        $lessons = $this->getLessons($request->theme_id);

        return Inertia::render('ArtGallery/Setting/Lessons', [
            'level_id'  => $request->level_id,
            'theme_id'  => $request->theme_id,
            'lessons'   => $lessons,
        ]);
    }

    public function activities(Request $request){
        $activities = $this->getActivities($request->lesson_id);

        return Inertia::render('ArtGallery/Setting/Activities', [
            'level_id'      => $request->level_id,
            'theme_id'      => $request->theme_id,
            'lesson_id'     => $request->lesson_id,
            'activities'    => $activities,
        ]);
    }

    /* Get Level, Theme, Lesson, Activity List */
    public function getLevels()
    {
        $levels =   DB::table('art_levels')->get();

        return $levels;
    }

    public function getThemes($level_id = '')
    {
        $themes =   DB::table('art_themes')
                    ->when($level_id, function($query) use ($level_id){
                        $query->where('level_id', $level_id);
                    })
                    ->get();

        return  $themes;
    }

    public function getLessons($theme_id)
    {
        $lessons =   DB::table('art_lessons')->where('theme_id', $theme_id)->get();

        return  $lessons;
    }

    public function getActivities($lesson_id)
    {
        $activities =   DB::table('art_activities')->where('lesson_id', $lesson_id)->get();

        return  $activities;
    }

    /* Store Level, Theme, Lesson, Activity */
    public function levelStore(Request $request)
    {
        $level_id   =   DB::table('art_levels')->insertGetId([
            'name'  => $request->level_name
        ]);
        $log_data =   'Added art level ID '.$level_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'New level has been added!']);
    }

    public function themeStore(Request $request)
    {
        $theme_id   =   DB::table('art_themes')->insertGetId([
            'level_id'  => $request->level_id,
            'name'      => $request->theme_name
        ]);
        $log_data =   'Added art theme ID '.$theme_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'New theme has been added!']);
    }

    public function lessonStore(Request $request)
    {
        $lesson_id   =   DB::table('art_lessons')->insertGetId([
            'theme_id'  => $request->theme_id,
            'name'      => $request->lesson_name
        ]);
        $log_data =   'Added art lesson ID '.$lesson_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'New lesson has been added!']);
    }

    public function activityStore(Request $request)
    {
        $activity_id   =   DB::table('art_activities')->insertGetId([
            'lesson_id' => $request->lesson_id,
            'name'      => $request->activity_name
        ]);
        $log_data =   'Added art activity ID '.$activity_id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'New activity has been added!']);
    }

    /* Update Level, Theme, Lesson, Activity */
    public function levelUpdate(Request $request)
    {
        DB::table('art_levels')->where('id', $request->id)->update([
            'name'  => $request->level_name
        ]);
        $log_data =   'Updated art level ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Level has been updated!']);
    }

    public function themeUpdate(Request $request)
    {
        DB::table('art_themes')->where('id', $request->id)->update([
            'name'      => $request->theme_name
        ]);
        $log_data =   'Updated art theme ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Theme has been updated!']);
    }

    public function lessonUpdate(Request $request)
    {
        DB::table('art_lessons')->where('id', $request->id)->update([
            'name'      => $request->lesson_name
        ]);
        $log_data =   'Updated art lesson ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Lesson has been updated!']);
    }

    public function activityUpdate(Request $request)
    {
        DB::table('art_activities')->where('id', $request->id)->update([
            'name'      => $request->activity_name
        ]);
        $log_data =   'Updated art activity ID '.$request->id;
        event(new DatabaseTransactionEvent($log_data));

        return back()->with(['type'=>'success', 'message'=>'Activity has been updated!']);
    }

    /* Delete Level, Theme, Lesson, Activity */
    public function levelDelete($id)
    {
        try {
            DB::beginTransaction();

            DB::table('art_levels')->where('id', $id)->delete();

            DB::commit();

            $log_data =   'Deleted art level ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return back()->with(['type'=>'success', 'message'=>'Level has been deleted!']);
        } 
        catch (Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'Cannot perform this action because there are items in this level!']);
        }
    }

    public function themeDelete($id)
    {
        try {
            DB::beginTransaction();

            DB::table('art_themes')->where('id', $id)->delete();

            DB::commit();

            $log_data =   'Deleted art theme ID '.$id;
            event(new DatabaseTransactionEvent($log_data));

            return back()->with(['type'=>'success', 'message'=>'Theme has been deleted!']);
        } 
        catch (Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'Cannot perform this action because there are items in this theme!']);
        }
    }

    public function lessonDelete($id)
    {
        try {
            DB::beginTransaction();

            DB::table('art_lessons')->where('id', $id)->delete();
            
            DB::commit();

            $log_data =   'Deleted art lesson ID '.$id;
            event(new DatabaseTransactionEvent($log_data));


            return back()->with(['type'=>'success', 'message'=>'Lesson has been deleted!']);
        } 
        catch (Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'Cannot perform this action because there are items in this lesson!']);
        }
    }

    public function activityDelete($id)
    {
        try {
            DB::beginTransaction();

            DB::table('art_activities')->where('id', $id)->delete();
            
            DB::commit();

            $log_data =   'Deleted art activity ID '.$id;
            event(new DatabaseTransactionEvent($log_data));


            return back()->with(['type'=>'success', 'message'=>'Activity has been deleted!']);
        } 
        catch (Exception $e) {
            DB::rollBack();
            return back()->with(['type'=>'error', 'message'=>'Cannot perform this action because there are items in this activity!']);
        }
    }
}
