<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
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

        $programmes     =   ProgrammeHelper::programmes();
        
        return Inertia::render('TeacherResources/Index', [
            'filter'            =>  request()->all('search', 'programme_id'),
            'teacher_resources' =>  $query->paginate(10),
            'programmes'        =>  $programmes
        ]);
    }

    public function create()
    {
        $programmes     =   ProgrammeHelper::programmes();
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

        return redirect(route('teacher_resources'))->with(['type'=>'success', 'message'=>'Teacher resource added successfully !']);
    }

    public function edit(Request $request)
    {
        $programmes     =   ProgrammeHelper::programmes();
        $languages      =   DB::table('languages')->get();
        $media_types    =   DB::table('teacher_resource_media_types')->get();
        $resource_info  =   DB::table('teacher_resources')->where('id', $request->resource_id)->first();

        return Inertia::render('TeacherResources/Edit', [
            'id'                =>  $request->resource_id,
            'programmes'        =>  $programmes,
            'languages'         =>  $languages,
            'media_types'       =>  $media_types,
            'resource_info'     =>  $resource_info
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title'             =>  'required',
            'programme_id'      =>  'required',
            'level_id'          =>  'required',
            'language_id'       =>  'required',
            'media_type_id'     =>  'required',
            'embed_link'        =>  'required_if:media_type_id, 1',
        ]);

        if((($request->media_type_id === 2 || $request->media_type_id === 3) && (!$request->embed_link && !$request->embed_file))){
            $customErrors = new MessageBag([
                'embed_file' => ['File is required'],
            ]);
    
            return redirect()->back()->withErrors($customErrors)->withInput();
        }
        if($request->delete_previous_file){
            $previous_file  =   DB::table('teacher_resources')->where('id', $request->id)->pluck('content')->first();
            $file_deleted   =   Storage::delete('teacher_resources/'.$previous_file);
        }

        if($request->file('embed_file')){
            $file = $request->file('embed_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
        }

        DB::table('teacher_resources')->where('id', $request->id)->update([
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

        return redirect(route('teacher_resources'))->with(['type'=>'success', 'message'=>'Teacher resource updated successfully !']);
    }

    public function destroy($id)
    {
        
        $info  =   DB::table('teacher_resources')->where('id', $id)->first();

        if($info->media_type){
            Storage::delete('teacher_resources/'.$info->content);
        }

        DB::table('teacher_resources')->where('id', $id)->delete();
        
        return redirect(route('teacher_resources'))->with(['type'=>'success', 'message'=>'Teacher resource deleted successfully !']);
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
