<?php

namespace App\Classes;

use DateTime;
use Illuminate\Support\Facades\DB;

class ArtGalleryHelper {
    public static function getStudentArtworks($level)
    {
        
        $artworks     =   DB::table('student_art_gallery')
                            ->join('art_levels', 'student_art_gallery.level_id', '=', 'art_levels.id')
                            ->join('art_themes', 'student_art_gallery.theme_id', '=', 'art_themes.id')
                            ->join('art_lessons', 'student_art_gallery.lesson_id', '=', 'art_lessons.id')
                            ->join('art_activities', 'student_art_gallery.activity_id', '=', 'art_activities.id')
                            ->where('student_art_gallery.level_id', $level)
                            ->where('student_art_gallery.student_id', session('current_active_child.student_id'))
                            ->select('student_art_gallery.id', 'art_levels.name as level', 'art_themes.name as theme', 'art_lessons.name as lesson', 'art_activities.name as activity', 'student_art_gallery.filename', 'art_themes.art_book_active')
                            ->paginate(9);
                            
        return $artworks;
    }
}