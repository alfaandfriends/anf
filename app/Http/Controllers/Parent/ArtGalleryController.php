<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $levels     =   $this->getLevels();
        $themes     =   DB::table('art_themes')->where('level_id', 1)->get();

        return Inertia::render('Parent/ArtGallery/Index',[
            'levels'    =>  $levels,
            'themes'    =>  $themes
        ]);
    }

    public function store(Request $request)
    {
        if(!$request->session()->get('current_active_child.child_id')){
            return back()->with(['type'=>'error', 'header'=>'Sorry', 'message'=>'Please select a child first before proceed.']);
        }
        if(!$request->session()->get('current_active_child.student_id')){
            return back()->with(['type'=>'error', 'header'=>'Sorry', 'message'=>'Only students are allowed to upload artwork.']);
        }
        $file = $request->file('artwork_file');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;

        DB::table('student_art_gallery')->insert([
            'student_id'    => $request->session()->get('current_active_child.student_id'),
            'level_id'      => $request->level_id,
            'theme_id'      => $request->theme_id,
            'lesson_id'     => $request->lesson_id,
            'activity_id'   => $request->activity_id,
            'filename'      => $filename,
        ]);

        Storage::putFileAs('art_gallery',$file, $filename);

        return redirect()->route('parent.art_gallery')->with(['type'=>'success', 'header'=>'Success', 'message'=>'Artwork uploaded successfully !']);
    }
    public function destroy($id)
    {
        $artwork_info   =   DB::table('student_art_gallery')->where('id', $id)->first();
        $file_deleted   =   Storage::delete('art_gallery/'.$artwork_info->filename);
        $record_deleted =   DB::table('student_art_gallery')->where('id', $id)->delete();

        if($record_deleted){
            return redirect(route('parent.art_gallery'))->with(['type'=>'success', 'header'=>'Success', 'message'=>'Artwork deleted successfully !']);
        }

        return redirect(route('parent.art_gallery'))->with(['type'=>'danger', 'header'=>'Failed', 'message'=>'An error occured, please try again !']);
    }

    public function getLevels()
    {
        $levels =   DB::table('art_levels')->get();

        return $levels;
    }

    public function getThemes($level_id)
    {
        $themes =   DB::table('art_themes')->where('level_id', $level_id)->where('art_book_active', 1)->get();

        return $themes;
    }

    public function getArtworks(Request $request)
    {
        $result     =   DB::table('student_art_gallery')
                            ->join('art_levels', 'student_art_gallery.level_id', '=', 'art_levels.id')
                            ->join('art_themes', 'student_art_gallery.theme_id', '=', 'art_themes.id')
                            ->join('art_lessons', 'student_art_gallery.lesson_id', '=', 'art_lessons.id')
                            ->join('art_activities', 'student_art_gallery.activity_id', '=', 'art_activities.id')
                            ->where('student_art_gallery.level_id', $request->level_id)
                            ->where('student_art_gallery.theme_id', $request->theme_id)
                            ->where('student_art_gallery.student_id', $request->session()->get('current_active_child.student_id'))
                            ->select('student_art_gallery.id', 'art_levels.name as level', 'art_themes.name as theme', 'art_lessons.name as lesson', 'art_activities.name as activity', 'student_art_gallery.filename', 'art_themes.art_book_active')
                            ->get();
        $artworks   =   collect($result)->groupBy('lesson');
        
        return $artworks;
    }
}
