<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ArtGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : Response
    {
        $levels     =   $this->getLevels();

        return Inertia::render('Parent/ArtGallery/Index',[
            'levels'    =>  $levels
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getLevels()
    {
        $levels =   DB::table('art_levels')->get();

        return $levels;
    }

    public function getThemes($level_id)
    {
        $themes =   DB::table('art_themes')->where('level_id', $level_id)->get();

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
                            ->select('art_levels.name as level', 'art_themes.name as theme', 'art_lessons.name as lesson', 'art_activities.name as activity', 'student_art_gallery.filename')
                            ->get();
        $artworks   =   collect($result)->groupBy('lesson');
        
        return $artworks;
    }
}
