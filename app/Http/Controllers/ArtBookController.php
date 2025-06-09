<?php

namespace App\Http\Controllers;

use App\Classes\ArtBookHelper;
use App\Http\Controllers\Parent\ArtGalleryController;
use Barryvdh\DomPDF\Facade\Pdf;
use Billplz\Base\Bill\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ArtBookController extends Controller
{

    public function index()
    {
        $artbooks     =   DB::table('pr_art_themes')
                            ->join('art_levels', 'pr_art_themes.level_id', '=', 'art_levels.id')
                            ->select('art_levels.name as level_name', 'pr_art_themes.*')
                            ->where('pr_art_themes.art_book_active', true)
                            ->orderBy('pr_art_themes.id')
                            ->get()
                            ->groupBy('level_name')
                            ->toArray();
        return Inertia::render('ArtBook/Index',[
            'artbooks'    =>  $artbooks,
        ]);
    }

    public function generate(Request $request){
        $image_condition    =   DB::table('art_book_conditions')->where('theme_id', $request->theme_id)->get();

        $data['image_1']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 1)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 1)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();
                            
        $data['image_2']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 2)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 2)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();

        
        $data['image_3']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 3)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 3)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();
                            
        $data['image_4']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 4)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 4)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();

        $data['image_5']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 5)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 5)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();

        $data['image_6']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 6)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 6)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();

        $data['image_7']    =   DB::table('student_art_gallery')
                                    ->where('theme_id', $request->theme_id)
                                    ->where('lesson_id', $image_condition->where('artwork_number', 7)->pluck('lesson_id')->first())
                                    ->where('activity_id', $image_condition->where('artwork_number', 7)->pluck('activity_id')->first())
                                    ->where('student_id', $request->student_id)
                                    ->pluck('filename')
                                    ->first();

        $data['name']       =   Str::headline($request->student_nickname);
        $data['gender']     =   collect(DB::table('students')
                                    ->join('children', 'students.children_id', '=', 'children.id')
                                    ->join('genders', 'children.gender_id', '=', 'genders.id')
                                    ->where('students.id', $request->student_id)->select('genders.subject_pronoun', 'genders.object_pronoun', 'genders.possessive_adjective', 'genders.possessive_pronoun', 'genders.reflexive_pronoun')->first())->toArray();

        $folder             =   DB::table('art_themes')->where('id', $request->theme_id)->pluck('art_book_assets')->first();
        
        $pdf = PDF::setPaper(array(0,0,648,576))
                    ->setOption('fontDir', public_path('/fonts'))
                    ->loadView($folder.'template', compact('data'));
        return $pdf->stream();
    }

    // Update the setup method to only return conditions data
    public function setup()
    {
        // Get conditions with theme, lesson, and activity information with pagination
        $conditions = DB::table('art_book_conditions')
                        ->join('pr_art_themes', 'art_book_conditions.theme_id', '=', 'pr_art_themes.id')
                        ->join('pr_art_lessons', 'art_book_conditions.lesson_id', '=', 'pr_art_lessons.id')
                        ->join('pr_art_activities', 'art_book_conditions.activity_id', '=', 'pr_art_activities.id')
                        ->select(
                            'art_book_conditions.*',
                            'pr_art_themes.name as theme_name',
                            'pr_art_lessons.name as lesson_name',
                            'pr_art_activities.name as activity_name'
                        )
                        ->orderBy('art_book_conditions.theme_id')
                        ->orderBy('art_book_conditions.artwork_number')
                        ->paginate(10); // 10 items per page
        
        // Get themes for dropdown
        $themes = DB::table('pr_art_themes')
                    ->select('id', 'name')
                    ->orderBy('id')
                    ->get();
        
        return Inertia::render('ArtBook/Setup', [
            'themes' => $themes,
            'conditions' => $conditions,
        ]);
    }

    // Get lessons for a theme
    public function getLessons($themeId)
    {
        $lessons = DB::table('pr_art_lessons')
                    ->where('theme_id', $themeId)
                    ->orderBy('id')
                    ->get();
        
        return response()->json($lessons);
    }

    // Get activities for a lesson
    public function getActivities($lessonId)
    {
        $activities = DB::table('pr_art_activities')
                        ->where('lesson_id', $lessonId)
                        ->orderBy('id')
                        ->get();
        
        return response()->json($activities);
    }

    // Store a new condition
    public function storeCondition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_id' => 'required|exists:pr_art_themes,id',
            'lesson_id' => 'required|exists:pr_art_lessons,id',
            'activity_id' => 'required|exists:pr_art_activities,id',
            'artwork_number' => 'required|integer|min:1|max:7',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if condition with same theme_id and artwork_number already exists
        $existingCondition = DB::table('art_book_conditions')
                            ->where('theme_id', $request->theme_id)
                            ->where('artwork_number', $request->artwork_number)
                            ->first();
        
        if ($existingCondition) {
            return response()->json(['errors' => [
                'artwork_number' => ['A condition with this artwork number already exists for this theme']
            ]], 422);
        }

        DB::table('art_book_conditions')->insert([
            'theme_id' => $request->theme_id,
            'lesson_id' => $request->lesson_id,
            'activity_id' => $request->activity_id,
            'artwork_number' => $request->artwork_number,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Condition created successfully']);
    }

    // Update an existing condition
    public function updateCondition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:art_book_conditions,id',
            'theme_id' => 'required|exists:pr_art_themes,id',
            'lesson_id' => 'required|exists:pr_art_lessons,id',
            'activity_id' => 'required|exists:pr_art_activities,id',
            'artwork_number' => 'required|integer|min:1|max:7',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if condition with same theme_id and artwork_number already exists (excluding current one)
        $existingCondition = DB::table('art_book_conditions')
                            ->where('theme_id', $request->theme_id)
                            ->where('artwork_number', $request->artwork_number)
                            ->where('id', '!=', $request->id)
                            ->first();
        
        if ($existingCondition) {
            return response()->json(['errors' => [
                'artwork_number' => ['A condition with this artwork number already exists for this theme']
            ]], 422);
        }

        try {
            DB::table('art_book_conditions')
                ->where('id', $request->id)
                ->update([
                    'theme_id' => $request->theme_id,
                    'lesson_id' => $request->lesson_id,
                    'activity_id' => $request->activity_id,
                    'artwork_number' => $request->artwork_number,
                    'updated_at' => now(),
                ]);
                
                return redirect()->route('art_book.setup')->with('success', 'Condition updated successfully');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update condition',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Delete a condition
    public function deleteCondition($id)
    {
        DB::table('art_book_conditions')->where('id', $id)->delete();
        
        return response()->json(['message' => 'Condition deleted successfully']);
    }
}
