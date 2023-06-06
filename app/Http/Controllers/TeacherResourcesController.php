<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TeacherResourcesController extends Controller
{
    public function index(Request $request)
    {
        $query =   DB::table('teacher_resources')
                                    ->join('programmes', 'teacher_resources.programme_id', '=', 'programmes.id')
                                    ->select('teacher_resources.id', 'teacher_resources.title', 
                                            'programmes.name as programme', 'teacher_resources.level', 'teacher_resources.media_type', 'teacher_resources.language_id', 
                                            'teacher_resources.content', 'teacher_resources.file_size', 'teacher_resources.download_count', 
                                            'teacher_resources.created_at', 'teacher_resources.updated_at');
        if($request->search){
            $query->where('teacher_resources.title', 'LIKE', '%'.request('search').'%');
        }
        
        if($request->programme_id){
            $query->where('programmes.id', $request->programme_id);
        }                   

        $programmes     =   DB::table('programmes')->get();
        
        return Inertia::render('TeacherResources/Index', [
            'filter'            =>  request()->all('search', 'programme_id'),
            'teacher_resources' =>  $query->paginate(10),
            'programmes'        =>  $programmes
        ]);
    }

    public function create()
    {
        $programmes     =   DB::table('programmes')->get();
        $languages      =   DB::table('languages')->get();
        $media_types    =   DB::table('teacher_resource_media_types')->get();

        return Inertia::render('TeacherResources/Create', [
            'programmes'    =>  $programmes,
            'languages'     =>  $languages,
            'media_types'     =>  $media_types
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'             =>  'required',
            'programme_id'      =>  'required',
            'level_id'          =>  'required',
            'language_id'       =>  'required',
            'media_type_id'     =>  'required',
            'embed_link'        =>  'required_if:media_type_id, 1',
            'embed_file'        =>  'required_if:media_type_id, 2, 3',
        ]);

        if($request->file('embed_file')){
            $file = $request->file('embed_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
        }

        DB::table('teacher_resources')->insert([
            'programme_id'  => $request->programme_id,
            'level'         => $request->level_id,
            'language_id'   => $request->language_id,
            'title'         => $request->title,
            'media_type'    => $request->media_type_id,
            'content'       => $request->file('embed_file') ? $filename : $request->embed_link,
            'file_size'     => $request->file('embed_file') ? $request->file('embed_file')->getSize() : null,
        ]);

        if($request->file('embed_file')){
            Storage::putFileAs('teacher_resources', $request->file('embed_file'), $filename);
        }

        return redirect(route('teacher_resources'))->with(['type'=>'success', 'message'=>'Teacher Resource added successfully !']);
    }

    public function edit(Request $request)
    {
        $programmes     =   DB::table('programmes')->get();
        $languages      =   DB::table('languages')->get();
        $media_types    =   DB::table('teacher_resource_media_types')->get();
        $resource_info  =   DB::table('teacher_resources')->where('id', $request->resource_id)->first();

        return Inertia::render('TeacherResources/Edit', [
            'programmes'    =>  $programmes,
            'languages'     =>  $languages,
            'media_types'   =>  $media_types,
            'resource_info'   =>  $resource_info
        ]);
    }

    public function getResource(Request $request)
    {
        $resource_data  =   DB::table('teacher_resources')
                                ->join('programmes', 'teacher_resources.programme_id', '=', 'programmes.id')
                                ->join('languages', 'teacher_resources.language_id', '=', 'languages.id')
                                ->join('teacher_resource_media_types', 'teacher_resources.media_type', '=', 'teacher_resource_media_types.id')
                                ->where('teacher_resources.id', $request->resource_id)
                                ->select('programmes.name as programme', 'teacher_resources.level', 'languages.name as language', 'teacher_resources.title', 
                                        'teacher_resources.media_type as media_type_id', 'teacher_resource_media_types.name as media_type_name', 
                                        'teacher_resources.content', 'teacher_resources.file_size', 'teacher_resources.download_count', 
                                        'teacher_resources.created_at', 'teacher_resources.updated_at')
                                ->first();

        return $resource_data;
    }
}
