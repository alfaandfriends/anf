<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MathManipulativesController extends Controller
{
    public function index()
    {
        $math_manipulatives =   DB::table('math_manipulatives')->get();

        return Inertia::render('MathManipulatives/Index', [
            'math_manipulatives' => $math_manipulatives
        ]);
    }

    public function play(Request $request)
    {   
        return Inertia::render('MathManipulatives/Play', [
            'name'   =>  $request->name
        ]);
    }

    public function configuration()
    {
        $math_manipulatives =   DB::table('math_manipulatives')->paginate(10);
        
        return Inertia::render('MathManipulatives/Configuration/Index', [
            'math_manipulatives' => $math_manipulatives
        ]);
    }

    public function configurationCreate()
    {
        return Inertia::render('MathManipulatives/Configuration/Create');
    }

    public function configurationStore(Request $request)
    {
        $request->validate([
            'title'             =>  'required',
            // 'thumbnail'         =>  'required',
        ]);
        
        if($request->file('thumbnail.file') == null){
            return back()->with(['type'=>'error', 'message'=>'Thumbnail is required!']);
        }

        /* Thumbnail */
        $file = $request->file('thumbnail.file');
        $extension = $file->getClientOriginalExtension();
        $thumbnail = time() . '.' . $extension;

        Storage::putFileAs('math_manipulatives/thumbnails',$file, $thumbnail);

        /* HTML5 Folder */
        if (Storage::exists('math_manipulatives/'.key($request->folder))) {
            return back()->with(['type'=>'error', 'message'=>'Folder exists!']);
        }

        $this->uploadFolder($request->folder, 'math_manipulatives');

        $math_manipulative_id = DB::table('math_manipulatives')->insertGetId([
            'name'          => $request->title,
            'thumbnail'     => $thumbnail,
            'folder_name'   => key($request->folder),
        ]);

        $log_data =   'Added math manipulative ID '.$math_manipulative_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('math_manipulatives.configuration'))->with(['type'=>'success', 'message'=>'New item added successfully !']);
    }

    public function configurationDelete($id)
    {
        $info   =   DB::table('math_manipulatives')->where('id', $id)->first();

        Storage::deleteDirectory('math_manipulatives/'.$info->folder_name, true);
        Storage::delete('math_manipulatives/thumbnails'.$info->thumbnail);

        DB::table('math_manipulatives')->where('id', $id)->delete();

        $log_data =   'Deleted math manipulative ID '.$id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('math_manipulatives.configuration'))->with(['type'=>'success', 'message'=>'Math manipulative deleted successfully !']);
    }

    public function uploadFolder($array, $path = '') {
        foreach ($array as $folder => $file) {
            // Check if a file with this name was uploaded
            if(strpos($folder, '.') !== false){
                if (is_file($file[0])) {
                    Storage::putFileAs($path, $file[0], $file[0]->getClientOriginalName());
                }
            }
            else {
            // Create a new directory and call the function recursively
                $newPath = $path . '/' . $folder;
                if (!Storage::disk('public')->exists($newPath)) {
                    Storage::disk('public')->makeDirectory($newPath);
                }
                $this->uploadFolder($file, $newPath);
            }
        }
    }
}
