<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StoryHelper {
    
    public static function getAdminPosts(){

    }

    public static function getPosts($student_id = null)
    {
        $permissions    =   Inertia::getShared('can');
        $is_admin       =   isset($permissions['create_posts']) ?? false; 

        if($student_id || $is_admin){
            $posts          =   DB::table('student_posts')
                                    ->leftJoin('wpvt_users', 'student_posts.created_by', '=', 'wpvt_users.ID')
                                    ->leftJoin('student_post_tags', 'student_post_tags.post_id', '=', 'student_posts.id')
                                    ->select(
                                        'student_posts.id as post_id',
                                        'student_posts.post_title as post_title',
                                        'student_posts.created_by as post_author',
                                        'student_posts.created_at as post_date',
                                        'wpvt_users.display_name as post_author_name')
                                    ->when(!$is_admin && $student_id, function($query) use ($student_id){
                                        $query->where('student_post_tags.student_id', $student_id);
                                    })
                                    ->when($is_admin, function($query){
                                        $query->where('student_posts.created_by', auth()->id())->distinct('student_posts.id');
                                    })
                                    ->paginate(2);
    
            $post_ids       =   $posts->pluck('post_id');
            $images         =   DB::table('student_post_images')->whereIn('student_post_images.post_id', $post_ids)->get()->groupBy('post_id');
            $tags           =   DB::table('student_post_tags')->whereIn('student_post_tags.post_id', $post_ids)->get()->groupBy('post_id');
            $likes          =   DB::table('student_post_likes')->whereIn('student_post_likes.post_id', $post_ids)->whereNull('deleted_at')->get()->groupBy('post_id');
                             
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
        }
        return [];
    }

    public static function createPost(Request $request){

        DB::beginTransaction();

        try {
            /* Post */
            $post_id    =   DB::table('student_posts')->insertGetId([
                                'post_title'    =>  $request->caption,
                                'created_by'    =>  auth()->id(),
                            ]);

            /* Photos */
            foreach($request->photos as $photo){
                $file       =   $photo['file'];
                $extension  =   $file->getClientOriginalExtension(); // Get the image extension
                $filename   =   Str::uuid() . '.' . $extension;

                Storage::putFileAs('posts',$file, $filename);

                DB::table('student_post_images')->insert([
                    'post_id'           =>  $post_id,
                    'image_filename'    =>  $filename,
                ]);
            }

            /* Tags */
            foreach($request->tagged_students as $tag){
                DB::table('student_post_tags')->insert([
                    'post_id'           =>  $post_id,
                    'student_id' =>  $tag,
                ]);
            }

            DB::commit(); 

            return redirect(route('home'));
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    
    public static function likePost(Request $request){
        
        $student_id     =   request()->session()->get('current_active_child.student_id');

        // dd($request->post_id);
        DB::beginTransaction();

        try {
            if($request->to_delete){
                DB::table('student_post_likes')->where('post_id', $request->post_id)->where('liked_by', $student_id)->update([
                    'deleted_at'    =>  Carbon::now()
                ]);
            }
            else{
                DB::table('student_post_likes')->updateOrInsert(
                    ['post_id' => $request->post_id, 'liked_by' => $student_id],
                    ['deleted_at' => NULL]
                );
            }

            DB::commit(); 

            return redirect(route('home'));
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}