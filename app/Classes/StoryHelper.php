<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StoryHelper {
    
    public static function getStories($centre_id = null, $programme_id = null){
        $user_centres       =   DB::table('user_has_centres')->where('user_id', auth()->id())->get()->pluck('centre_id');
        $is_admin           =   (bool)auth()->user()->is_admin;

        $stories  =   DB::table('stories')
                        ->leftJoin('wpvt_users', 'stories.created_by', '=', 'wpvt_users.ID')
                        ->leftJoin('story_likes', 'story_likes.story_id', '=', 'stories.id')
                        ->select(
                            'stories.id as story_id',
                            'stories.title as story_title',
                            'stories.created_by as story_author',
                            'stories.created_at as story_date',
                            'wpvt_users.display_name as story_author_name',
                            DB::raw('count(story_likes.story_id) as reaction_count'),
                        )
                        ->when(!$is_admin, function($query) use ($user_centres){
                            $query->whereIn('stories.centre_id', $user_centres);
                        })
                        ->when($centre_id, function($query) use ($centre_id){
                            $query->where('stories.centre_id', $centre_id);
                        })
                        ->when($programme_id, function($query) use ($programme_id){
                            $query->where('stories.programme_id', $programme_id);
                        })
                        ->groupBy('stories.id')
                        // ->when(!$is_admin && $student_id, function($query) use ($student_id){
                        //     $query->where('story_students.student_id', $student_id);
                        // })
                        // ->when($is_admin, function($query){
                        //     $query->where('stories.created_by', auth()->id())->distinct('stories.id');
                        // })
                        ->paginate(10);
                        // dd($stories);

        return $stories;
    }

    public static function getPosts($student_id = null)
    {
        $permissions    =   Inertia::getShared('can');
        $is_admin       =   isset($permissions['create_posts']) ?? false; 

        if($student_id || $is_admin){
            $posts          =   DB::table('stories')
                                    ->leftJoin('wpvt_users', 'stories.created_by', '=', 'wpvt_users.ID')
                                    ->leftJoin('story_students', 'story_students.story_id', '=', 'stories.id')
                                    ->select(
                                        'stories.id as story_id',
                                        'stories.title as title',
                                        'stories.created_by as post_author',
                                        'stories.created_at as post_date',
                                        'wpvt_users.display_name as post_author_name')
                                    ->when(!$is_admin && $student_id, function($query) use ($student_id){
                                        $query->where('story_students.student_id', $student_id);
                                    })
                                    ->when($is_admin, function($query){
                                        $query->where('stories.created_by', auth()->id())->distinct('stories.id');
                                    })
                                    ->paginate(2);
    
            $post_ids       =   $posts->pluck('story_id');
            $images         =   DB::table('story_images')->whereIn('story_images.story_id', $post_ids)->get()->groupBy('story_id');
            $tags           =   DB::table('story_students')->whereIn('story_students.story_id', $post_ids)->get()->groupBy('story_id');
            $likes          =   DB::table('story_likes')->whereIn('story_likes.story_id', $post_ids)->whereNull('deleted_at')->get()->groupBy('story_id');
                             
            if($posts->isNotEmpty()){    
                foreach($posts as $post){
                    $info['story_id']            =   $post->story_id;
                    $info['title']         =   $post->title;
                    $info['post_author']        =   $post->post_author;
                    $info['post_author_name']   =   $post->post_author_name;
                    $info['post_date']          =   $post->post_date;
                    $info['post_images']        =   isset($images[$post->story_id]) ? $images[$post->story_id] : [];
                    $info['post_tags']          =   isset($tags[$post->story_id]) ? $tags[$post->story_id] : [];
                    $info['post_likes']         =   isset($likes[$post->story_id]) ? $likes[$post->story_id] : [];
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
            $story_id    =   DB::table('stories')->insertGetId([
                                'title'    =>  $request->caption,
                                'created_by'    =>  auth()->id(),
                            ]);

            /* Photos */
            foreach($request->photos as $photo){
                $file       =   $photo['file'];
                $extension  =   $file->getClientOriginalExtension(); // Get the image extension
                $filename   =   Str::uuid() . '.' . $extension;

                Storage::putFileAs('posts',$file, $filename);

                DB::table('story_images')->insert([
                    'story_id'           =>  $story_id,
                    'image_filename'    =>  $filename,
                ]);
            }

            /* Tags */
            foreach($request->tagged_students as $tag){
                DB::table('story_students')->insert([
                    'story_id'           =>  $story_id,
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

        // dd($request->story_id);
        DB::beginTransaction();

        try {
            if($request->to_delete){
                DB::table('story_likes')->where('story_id', $request->story_id)->where('liked_by', $student_id)->update([
                    'deleted_at'    =>  Carbon::now()
                ]);
            }
            else{
                DB::table('story_likes')->updateOrInsert(
                    ['story_id' => $request->story_id, 'liked_by' => $student_id],
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