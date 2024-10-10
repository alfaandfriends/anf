<?php

namespace App\Http\Controllers\Parent;

use App\Classes\ArtGalleryHelper;
use App\Http\Controllers\Controller;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ArtGalleryController extends Controller
{
    public function index(Request $request)
    {
        if(!session('current_active_programme.id')){
            return redirect(route('parent.home'))->with(['type' => 'error', 'message' => 'Unable to fetch class data']);
        }
        
        $levels     =   $this->getLevels();
        
        $artworks   =   ArtGalleryHelper::getStudentArtworks(1);
                            
        return Inertia::render('Parent/Class/ArtGallery',[
            'levels'    =>  $levels,
            'artworks'  =>  $artworks,
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
        $artworks     =   DB::table('student_art_gallery')
                            ->join('pr_art_levels', 'student_art_gallery.level_id', '=', 'pr_art_levels.id')
                            ->join('pr_art_themes', 'student_art_gallery.theme_id', '=', 'pr_art_themes.id')
                            ->join('pr_art_lessons', 'student_art_gallery.lesson_id', '=', 'pr_art_lessons.id')
                            ->join('pr_art_activities', 'student_art_gallery.activity_id', '=', 'pr_art_activities.id')
                            ->where('student_art_gallery.level_id', $request->level_id)
                            ->where('student_art_gallery.student_id', $request->session()->get('current_active_child.student_id'))
                            ->select('student_art_gallery.id', 'pr_art_levels.name as level', 'pr_art_themes.name as theme', 'pr_art_lessons.name as lesson', 'pr_art_activities.name as activity', 'student_art_gallery.filename', 'pr_art_themes.art_book_active')
                            ->get();

        return response()->json($artworks); // Ensure the response is JSON
    }
}
