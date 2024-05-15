<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PostHelper {

    public static function getPosts()
    {
        $posts      =   DB::table('student_posts')
                            ->leftJoin('wpvt_users', 'student_posts.created_by', '=', 'wpvt_users.ID')
                            ->select(
                                'student_posts.id as post_id',
                                'student_posts.post_title as post_title',
                                'student_posts.created_by as post_author',
                                'student_posts.created_at as post_date',
                                'wpvt_users.display_name as post_author_name')
                            ->paginate(2);

        $post_ids   =   $posts->pluck('post_id');
        $images     =   DB::table('student_post_images')->whereIn('student_post_images.post_id', $post_ids)->get()->groupBy('post_id');
        $tags       =   DB::table('student_post_tags')->whereIn('student_post_tags.post_id', $post_ids)->get()->groupBy('post_id');
        $likes      =   DB::table('student_post_likes')->whereIn('student_post_likes.post_id', $post_ids)->whereNull('deleted_at')->get()->groupBy('post_id');
                         
        if($posts->isNotEmpty()){    
            foreach($posts as $post){
                $info['post_id']            =   $post->post_id;
                $info['post_title']         =   $post->post_title;
                $info['post_author']        =   $post->post_author;
                $info['post_author_name']   =   $post->post_author_name;
                $info['post_date']          =   $post->post_date;
                $info['post_images']        =   isset($images[$post->post_id]) ? $images[$post->post_id] : [];
                $info['post_tags']          =   isset($tags[$post->post_id]) ? $tags[$post->post_id] : [];
                $info['post_likes']         =   isset($likes[$post->post_id]) ? $likes[$post->post_id] : [];
                $data[]                     =   $info;
            }           
            return $data;
        }
        return [];
    }
}