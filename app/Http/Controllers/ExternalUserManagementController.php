<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ExternalUserManagementController extends Controller
{
    public $division_manager_role_id, $centre_manager_role_id, $edupreneur_role_id;
    public $division_managers, $centre_managers, $edupreneurs;

    public function __construct(){
        $this->division_manager_role_id =   4;
        $this->centre_manager_role_id   =   5;
        $this->edupreneur_role_id       =   6;

        $this->division_managers    =   $this->getDivisionManagers()->toArray();
        $this->centre_managers      =   $this->getCentreManagers()->toArray();
        $this->edupreneurs          =   $this->getEdupreneurs()->toArray();
    }

    public function divisionManagerList(Request $request)
    {
        $allowed_centres    =   collect(Inertia::getShared('allowed_centres'))->pluck('ID');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to any centre. Please contact support to gain access for centres."]);
        }

        $query          =   DB::table('wpvt_users')
                                ->join('user_has_roles', 'wpvt_users.id', '=', 'user_has_roles.user_id')
                                ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                                ->select([  'wpvt_users.id as id', 
                                            'wpvt_users.display_name as name', 
                                            'wpvt_users.user_email as email', 
                                            'roles.display_name as role'])->where('user_has_roles.role_id', $this->division_manager_role_id);

        if($request->search){
            $query->where('wpvt_users.display_name', 'LIKE', '%'.$request->search.'%');
        }

        return Inertia::render('ExternalUserManagement/DivisionManagers/Index', [
            'filter'                => request()->all('search', 'centre_id'),
            'division_managers'     => $query->paginate(10),
        ]);
    }

    public function manageDivisionManager(Request $request)
    {
        if(in_array($request->user_id, $this->division_managers)){
            $user_info      =   DB::table('wpvt_users')->where('id', $request->user_id)->first();
            $user_centres   =   DB::table('user_has_centres')->where('user_id', $request->user_id)->get('centre_id')->keyBy('centre_id');

            return Inertia::render('ExternalUserManagement/DivisionManagers/ManageUser',[
                'user_id'       => $request->user_id,
                'user_info'     => $user_info,
                'user_centres'  => $user_centres,
            ]);
        }

        return redirect(route('division_manager'))->with(['type'=>'error', 'message'=>"You're not allowed to perform this action!"]);
    }

    public function manageDivisionManagerStore(Request $request)
    {
        DB::table('user_has_centres')->where('user_id', $request->user_id)->delete();

        foreach($request->selected_centres as $key=>$centre_id){
            DB::table('user_has_centres')->insert([
                'user_id'   =>  $request->user_id,
                'centre_id'   =>  $centre_id
            ]);
        }
        $log_data =   "Updated division manager's centre access for user ID ".$request->user_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('division_manager'))->with(['type'=>'success', 'message'=>'Operation successfull !']);
    }

    public function centreManagerList(Request $request)
    {
        $allowed_centres    =   collect(Inertia::getShared('allowed_centres'))->pluck('ID');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to any centre. Please contact support to gain access for centres."]);
        }
        
        $query          =   DB::table('wpvt_users')
                                ->join('user_has_roles', 'wpvt_users.id', '=', 'user_has_roles.user_id')
                                ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                                ->select([  'wpvt_users.id as id', 
                                            'wpvt_users.display_name as name', 
                                            'wpvt_users.user_email as email', 
                                            'roles.display_name as role'])->where('user_has_roles.role_id', $this->centre_manager_role_id);

        if(!auth()->user()->is_admin && !auth()->user()->can_view_all_centres){
            $query->join('user_has_centres', 'wpvt_users.id', '=', 'user_has_centres.user_id')
                    ->whereIn('user_has_centres.centre_id', $allowed_centres);
        }

        if($request->search){
            $query->where('wpvt_users.display_name', 'LIKE', '%'.$request->search.'%');
        }

        return Inertia::render('ExternalUserManagement/CentreManagers/Index', [
            'filter'                => request()->all('search'),
            'centre_managers'     => $query->paginate(10),
        ]);
    }

    public function manageCentreManager(Request $request)
    {
        if(in_array($request->user_id, $this->centre_managers)){
            $user_info      =   User::find($request->user_id);
            $user_centre    =   DB::table('user_has_centres')->where('user_id', $request->user_id)->first();

            return Inertia::render('ExternalUserManagement/CentreManagers/ManageUser',[
                'user_id'       => $request->user_id,
                'user_info'     => $user_info,
                'user_centre'     => $user_centre,
            ]);
        }

        return redirect(route('centre_manager'))->with(['type'=>'error', 'message'=>"You're not allowed to perform this action!"]);
    }

    public function manageCentreManagerStore(Request $request)
    {
        DB::table('user_has_centres')->where('user_id', $request->user_id)->delete();

        DB::table('user_has_centres')->insert([
            'user_id'   =>  $request->user_id,
            'centre_id'   =>  $request->centre_id
        ]);
        $log_data =   "Updated centre manager's centre access for user ID ".$request->user_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('centre_manager'))->with(['type'=>'success', 'message'=>'Operation successfull !']);
    }

    public function edupreneurList(Request $request)
    {
        $allowed_centres    =   collect(Inertia::getShared('allowed_centres'))->pluck('ID');
        if($allowed_centres->isEmpty()){
            return back()->with(['type'=>'error', 'message'=>"Sorry, you don't have access to any centre. Please contact support to gain access for centres."]);
        }
        
        $query          =   DB::table('wpvt_users')
                                ->join('user_has_roles', 'wpvt_users.id', '=', 'user_has_roles.user_id')
                                ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                                ->distinct()
                                ->select([  'wpvt_users.id as id', 
                                            'wpvt_users.display_name as name', 
                                            'wpvt_users.user_email as email', 
                                            'roles.display_name as role'])->where('user_has_roles.role_id', $this->edupreneur_role_id);

        if(!auth()->user()->is_admin && !auth()->user()->can_view_all_centres){
            $query->join('user_has_centres', 'wpvt_users.id', '=', 'user_has_centres.user_id')
                    ->whereIn('user_has_centres.centre_id', $allowed_centres);
        }

        if($request->search){
            $query->where('wpvt_users.display_name', 'LIKE', '%'.$request->search.'%');
        }

        return Inertia::render('ExternalUserManagement/Edupreneurs/Index', [
            'filter'        => request()->all('search'),
            'edupreneurs'     => $query->paginate(10),
        ]);
    }

    public function manageEdupreneur(Request $request)
    {
        if(in_array($request->user_id, $this->edupreneurs)){
            $user_info      =   DB::table('wpvt_users')->where('id', $request->user_id)->first();
            $user_centres   =   DB::table('user_has_centres')->where('user_id', $request->user_id)->get('centre_id')->keyBy('centre_id');

            return Inertia::render('ExternalUserManagement/Edupreneurs/ManageUser',[
                'user_id'       => $request->user_id,
                'user_info'     => $user_info,
                'user_centres'  => $user_centres,
            ]);
        }

        return redirect(route('edupreneurs'))->with(['type'=>'error', 'message'=>"You're not allowed to perform this action!"]);
    }

    public function manageEdupreneurStore(Request $request)
    {
        DB::table('user_has_centres')->where('user_id', $request->user_id)->delete();

        foreach($request->selected_centres as $key=>$centre_id){
            DB::table('user_has_centres')->insert([
                'user_id'   =>  $request->user_id,
                'centre_id'   =>  $centre_id
            ]);
        }
        $log_data =   "Updated edupreneurs's centre access for user ID ".$request->user_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('centre_manager'))->with(['type'=>'success', 'message'=>'Operation successfull !']);
    }


    // public function create()
    // {
    //     //External Staff
    //     $role_group =   2;
    //     $roles  =   DB::table('roles')
    //                     ->join('role_groups', 'roles.role_group_id', '=', 'role_groups.id')
    //                     ->where('roles.role_group_id', $role_group)
    //                     ->select(['roles.id', 'roles.display_name'])->get();
        
    //     return Inertia::render('CentreManagement/Users/Create', [
    //         'roles' =>  $roles
    //     ]);
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id'   => 'required',
    //         'centre_id' => 'required',
    //     ]);

    //     $user_exist =   !empty(DB::table('centre_users')->where('user_id', $request->user_id)->first()) ? true : false;

    //     if($user_exist){
    //         return back()->with(['type' => 'error', 'message' => 'User already exists!']);
    //     }

    //     DB::table('centre_users')->insert([
    //         'user_id'   => $request->user_id,
    //         'role_id'   => $request->role_id,
    //         'centre_id' => $request->centre_id
    //     ]);

    //     return back()->with(['type' => 'success', 'message' => 'New user added!']);
    // }

    // public function find(Request $request)
    // {
    //     $users   =   DB::table('wpvt_users')->where('display_name', 'LIKE', '%'.$request->keyword.'%')->select(['ID', 'display_name', 'user_email'])->get();
    //     return $users;
    // }

    public function getDivisionManagers()
    {
        $division_managers          =   DB::table('wpvt_users')
                                            ->join('user_has_roles', 'wpvt_users.id', '=', 'user_has_roles.user_id')
                                            ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                                            ->select([  'wpvt_users.id as id'])
                                            ->where('user_has_roles.role_id', $this->division_manager_role_id)
                                            ->pluck('id');

        return $division_managers;
    }

    public function getCentreManagers()
    {
        $centre_managers          =   DB::table('wpvt_users')
                                            ->join('user_has_roles', 'wpvt_users.id', '=', 'user_has_roles.user_id')
                                            ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                                            ->select([  'wpvt_users.id as id'])
                                            ->where('user_has_roles.role_id', $this->centre_manager_role_id)
                                            ->pluck('id');

        return $centre_managers;
    }

    public function getEdupreneurs()
    {
        $edupreneurs          =   DB::table('wpvt_users')
                                            ->join('user_has_roles', 'wpvt_users.id', '=', 'user_has_roles.user_id')
                                            ->join('roles', 'user_has_roles.role_id', '=', 'roles.id')
                                            ->select([  'wpvt_users.id as id'])
                                            ->where('user_has_roles.role_id', $this->edupreneur_role_id)
                                            ->pluck('id');

        return $edupreneurs;
    }
}
