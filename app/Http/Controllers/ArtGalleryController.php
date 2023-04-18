<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $query  =   DB::table('student_art_gallery')
                        ->join('art_levels', 'student_art_gallery.level_id', '=', 'art_levels.id')
                        ->join('art_themes', 'student_art_gallery.theme_id', '=', 'art_themes.id')
                        ->join('art_lessons', 'student_art_gallery.lesson_id', '=', 'art_lessons.id')
                        ->join('art_activities', 'student_art_gallery.activity_id', '=', 'art_activities.id')
                        ->leftJoin('students', 'student_art_gallery.student_id', '=', 'students.id')
                        ->leftJoin('children', 'students.children_id', '=', 'children.id')
                        ->select(
                            'student_art_gallery.id as artwork_id',
                            'students.id as student_id',
                            'children.name as student_name',
                            'student_art_gallery.filename as art_file_location',
                            'art_levels.name as level',
                            'art_themes.name as theme',
                            'art_lessons.name as lesson',
                            'art_activities.name as activity',
                        );
        
        if(request('search')){
            $query  ->where('children.name', 'LIKE', '%'.request('search').'%');
        }

        if(request('centre_id')){
            $query  ->where('students.centre_id', request('centre_id'));
        }
        
        $results    =   $query->orderBy('student_art_gallery.id')
                                ->orderBy('art_levels.id')
                                ->orderBy('art_themes.id')
                                ->orderBy('art_lessons.id')
                                ->orderBy('art_activities.id')
                                ->paginate(10);

        return Inertia::render('ArtGallery/Index', [
            'filter'=>request()->all('search', 'centre_id'),
            'arts' => $results,
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

        return redirect(route('art_gallery'))->with(['type'=>'danger', 'message'=>'An error occured, please try again !']);

    }

    public function getThemes($level_id)
    {
        $themes =   DB::table('art_themes')->where('level_id', $level_id)->get();

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
}
