<?php

namespace App\Classes;

use DateTime;
use Illuminate\Support\Facades\DB;

class ArtGalleryHelper {
    public static function getStudentArtworks($level)
    {
        
        $artworks     =   DB::table('student_art_gallery')
                            ->join('pr_art_levels', 'student_art_gallery.level_id', '=', 'pr_art_levels.id')
                            ->join('pr_art_themes', 'student_art_gallery.theme_id', '=', 'pr_art_themes.id')
                            ->join('pr_art_lessons', 'student_art_gallery.lesson_id', '=', 'pr_art_lessons.id')
                            ->join('pr_art_activities', 'student_art_gallery.activity_id', '=', 'pr_art_activities.id')
                            ->where('student_art_gallery.level_id', $level)
                            ->where('student_art_gallery.student_id', session('current_active_child.student_id'))
                            ->select('student_art_gallery.id', 'pr_art_levels.name as level', 'pr_art_themes.name as theme', 'pr_art_lessons.name as lesson', 'pr_art_activities.name as activity', 'student_art_gallery.filename', 'pr_art_themes.art_book_active')
                            ->paginate(9);
                            
        return $artworks;
    }
}