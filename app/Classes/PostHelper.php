<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PostHelper {

    public static function getPosts()
    {
        $posts =   DB::table('student_posts')
                        ->leftJoin('student_post_tags', 'student_post_tags.post_id', '=', 'student_posts.id')
                        ->leftJoin('student_post_likes', 'student_post_likes.post_id', '=', 'student_posts.id')
                        ->leftJoin('wpvt_users', 'student_posts.created_by', '=', 'wpvt_users.ID')
                        // ->where('student_posts.created_by', auth()->id())
                        // ->orWhere('student_post_tags.tagged_user', auth()->id())
                        ->select(
                            'student_posts.id as post_id',
                            'student_posts.post_title as post_title',
                            'student_posts.image_filename as post_image',
                            'student_posts.created_by as post_author',
                            'student_posts.created_at as post_date',
                            'wpvt_users.display_name as post_author_name',
                            'student_post_tags.id as tag_id',
                            'student_post_tags.post_id as tag_post_id',
                            'student_post_tags.tagged_user as tag_user_id',
                            'student_post_likes.id as liked_id',
                            'student_post_likes.post_id as liked_post_id',
                            'student_post_likes.liked_by as liked_user_id',
                        )
                        ->get();
                        
        $posts_collection = collect($posts);
        foreach($posts as $post){
            $info['post_id']            =   $post->post_id;
            $info['post_title']         =   $post->post_title;
            $info['post_image']         =   $post->post_image;
            $info['post_author']        =   $post->post_author;
            $info['post_author_name']   =   $post->post_author_name;
            $info['post_date']          =   $post->post_date;
            $info['tagged_users']       =   $posts_collection->where('tag_post_id', $post->post_id)->select('tag_id', 'tag_post_id', 'tag_user_id')->toArray();
            $info['liked_by']           =   $posts_collection->where('liked_post_id', $post->post_id)->select('liked_id', 'liked_post_id', 'liked_user_id')->toArray();
            $data[]                     =   $info;
        }
        return $data;
    }
}