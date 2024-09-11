<?php

namespace App\Http\Controllers;

use App\Classes\ProgrammeHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        $allowed_centres    =   Inertia::getShared('allowed_centres');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to centres. Please contact support to gain access for centres."]);
        }
        $can_access_centre = $allowed_centres->search(function ($value) {
            return $value->ID == request('centre_id');
        });
        $request->merge([
            'centre_id' => $request->centre_id && $can_access_centre ? $request->centre_id : $allowed_centres[0]->ID
        ]);
        
        $results    =   DB::table('assessments')
                            ->join('programme_level_fees', 'assessments.programme_level_fee_id', '=', 'programme_level_fees.id')
                            ->join('programme_levels', 'programme_level_fees.programme_level_id', '=', 'programme_levels.id')
                            ->join('programmes', 'programme_levels.programme_id', '=', 'programmes.id')
                            ->join('students', 'assessments.student_id', '=', 'students.id')
                            ->join('children', 'students.children_id', '=', 'children.id')
                            ->join('centres', 'assessments.centre_id', '=', 'centres.ID')
                            ->when(request('search'), function ($query, $search) {
                                $query->where(function ($q) use ($search) {
                                    $q->where('children.name', 'LIKE', "%$search%");
                                });
                            })
                            ->where('assessments.centre_id', '=', $request->centre_id)
                            ->whereIn('programmes.id', [1, 4])
                            ->when(request('programme_id'), function ($query, $search) {
                                $query->where('programmes.id', request('programme_id'));
                            })
                            ->when(request('level'), function ($query, $search) {
                                $query->where('programme_levels.level', request('level'));
                            })
                            ->select('children.name as student_name', 'students.id as student_id', 'centres.label as centre_name', 'programmes.name as programme_name', 'programme_levels.level as programme_level', 'programme_level_fees.id as programme_level_fee_id', 'assessments.assessments', 'assessments.final_pre_score', 'assessments.final_post_score')
                            ->orderBy('student_name')
                            ->orderBy('programme_level')
                            ->paginate(10);

        $options['programmes'] =   ProgrammeHelper::programmes(null, [1, 4]);
        $options['levels']     =   ProgrammeHelper::distinctLevels();
        
        return Inertia::render('Assessments/Index', [
            'filter'        =>  request()->all('search', 'centre_id', 'programme_id', 'level'),
            'options'       =>  $options,
            'assessments'   =>  $results
        ]);
    }

    public function create($level){
        $units  =   DB::table('pr_math_units')
                        ->join('pr_math_terms_books', 'pr_math_units.term_book_id', '=', 'pr_math_terms_books.id')
                        ->join('pr_math_levels', 'pr_math_terms_books.level_id', '=', 'pr_math_levels.id')
                        ->where('pr_math_levels.level', $level)
                        ->select('pr_math_units.*')
                        ->get();
                        
        return $units;
    }

    public function store(Request $request){
        DB::table('assessments')
        ->where('student_id', $request->student_id)
        ->where('programme_level_fee_id', $request->programme_level_fee_id)
        ->update([
            'assessments'       => $request->assessments,
            'final_pre_score'   => $request->final_pre_score,
            'final_post_score'  => $request->final_post_score
        ]);

        return back()->with(['type'=>'success', 'message'=>'Data has been saved']);
    }
}
