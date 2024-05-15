<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function createPost(Request $request){

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
                $filename  =   $photo['name'].'.'.$file->getClientOriginalExtension();

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
                    'tagged_student_id' =>  $tag,
                ]);
            }

            DB::commit(); 

            return redirect(route('home'));
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    
    public function likePost(Request $request){
        
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
