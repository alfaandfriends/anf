<?php

namespace App\Http\Controllers;

use App\Classes\NotificationHelper;
use App\Models\Role;
use App\Models\UserHasRoles;
use App\Notifications\ResetUserPassword;
use App\Notifications\UserRegistrationCredentials;
use Carbon\Carbon;
use Corcel\Model\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public $update_user_config = 8;

    public function index()
    {
        $query  =   User::query();
        
        if(request('search')){
            $query  ->where('user_email', 'LIKE', '%'.request('search').'%')
                    ->orWhere('display_name', 'LIKE', '%'.request('search').'%');
        }
        $results    =   $query->orderBy('ID')->paginate(10);

        $user_has_role  =   UserHasRoles::get()->keyBy('user_id');
        $role_list      =   Role::get()->keyBy('id');

        return Inertia::render('Users/Index', [
            'filter'=>request()->all('search'),
            'user_list' => $results,
            'user_has_role' => $user_has_role,
            'role_list' => $role_list,
        ]);
    }

    public function create(){

        $roles      =   Role::get();

        return Inertia::render('Users/Create',[
            'roles'     => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'calling_code' => 'required',
            'contact_number' => 'required',
            'state' => 'required',
            'address' => 'required',
            'selected_roles' => 'required',
        ],
        [
            'selected_roles.required' => 'Please assign at least 1 role.'
        ]);
        
        $random_password        =   Str::random(20);
        $hashed_random_password =   Hash::make($random_password);
        $first_name             =   Str::of(Str::lower($request->first_name))->title();
        $last_name              =   Str::of(Str::lower($request->last_name))->title();
        $address                =   Str::of($request->address)->title();

        try{
            DB::beginTransaction();
            $new_user_id    =   DB::table('wpvt_users')->insertGetId([
                                    'user_login'            => $request->username,
                                    'user_pass'             => $hashed_random_password,
                                    'user_nicename'         => $request->username,
                                    'user_email'            => $request->email,
                                    'user_url'              => '',
                                    'user_registered'       => now(),
                                    'user_activation_key'   => '',
                                    'user_status'           => 0,
                                    'display_name'          => $first_name.' '.$last_name,
                                    'spam'                  => 0,
                                    'deleted'               => 0,
                                    'remember_token'        => '',
                                ]);   

            if($new_user_id){ 
                DB::table('user_basic_information')->insert([
                    'user_id'               => $new_user_id,
                    'user_first_name'       => $first_name,
                    'user_last_name'        => $last_name,
                    'user_address'          => $address,
                    'user_country'          => $request->country,
                    'user_country_code'     => $request->country_code,
                    'user_contact'          => $request->contact_number,
                    'user_state'            => $request->state,
                    'user_calling_code'     => $request->calling_code,
                ]);
            }
    
            // DB::table('wpvt_usermeta')->insert([
            //     ['user_id' => $new_user_id, 'meta_key' => 'first_name', 'meta_value' => $first_name],
            //     ['user_id' => $new_user_id, 'meta_key' => 'last_name', 'meta_value' => $last_name],
            // ]);
            
            foreach($request->selected_roles as $key=>$role){
                DB::table('user_has_roles')->insert([
                    'user_id' => $new_user_id, 
                    'role_id' => $role, 
                ]);
            }
            DB::commit();

            $user           =   User::where('ID', $new_user_id)->first();
            $credentials    =   [
                'email'     =>  $request->email,
                'username'  =>  $request->username,
                'password'  =>  $random_password,
            ];

            Notification::sendNow($user, new UserRegistrationCredentials($credentials));

            return redirect(route('users'))->with(['type'=>'success', 'message'=>'Credentials has been sent to the registered email !']);
        }
        catch(Exception $e){
            DB::rollback();
            return back()->with(['type'=>'error', 'message'=>'An error has occured, please try again !']);
        }
    }

    public function edit(Request $request)
    {
        $info = DB::table('user_basic_information')->where('user_id', $request->user_id)->first();
        
        $roles          =   Role::get();
        $user_roles     =   UserHasRoles::where('user_id', $request->user_id)->get('role_id')->keyBy('role_id');

        return Inertia::render('Users/Edit', [
            'info'          => $info,
            'user_id'       => $request->user_id,
            'roles'         => $roles,
            'user_roles'    => $user_roles,
        ]);
    }

    public function manageRolesStore(Request $request)
    {
        $user_exist =   $this->checkUserExist($request->user_id);
        
        /* If user exists */
        if(!$user_exist){
            DB::table('user_basic_information')
                ->insert([
                    'user_id'           => $request->user_id,
                    'user_first_name'   => $request->form['first_name'],
                    'user_last_name'    => $request->form['last_name'],
                    'user_calling_code' => $request->form['calling_code'],
                    'user_contact'      => $request->form['contact_number'],
                    'user_address'      => $request->form['address'],
                    'user_country'      => $request->form['country'],
                    'user_state'        => $request->form['country_state'],
                    'user_country_code' => $request->form['country_code'],
                ]);
        }
        /* If user not exists */
        else{
            DB::table('user_basic_information')
            ->where('user_id', $request->user_id)
            ->update([
                'user_first_name'   => $request->form['first_name'],
                'user_last_name'    => $request->form['last_name'],
                'user_calling_code' => $request->form['calling_code'],
                'user_contact'      => $request->form['contact_number'],
                'user_address'      => $request->form['address'],
                'user_country'      => $request->form['country'],
                'user_state'        => $request->form['country_state'],
                'user_country_code' => $request->form['country_code'],
                'updated_at'        => Carbon::now(),
            ]);
        }

        $user                           =   User::find($request->user_id);

        $admin_role                     =   array(1, 2);
        $can_view_all_centres_role      =   array(1, 2, 3);

        $user_is_admin                  =   false;
        $user_can_view_all_centres      =   false;

        UserHasRoles::where('user_id', $request->user_id)->delete();

        foreach($request->selected_roles as $key=>$role_id){
            DB::table('user_has_roles')->insert([
                'user_id'   =>  $request->user_id,
                'role_id'   =>  $role_id
            ]);
            if(in_array($role_id, $admin_role)){
                $user_is_admin  =   true;
            }
            
            if(in_array($role_id, $can_view_all_centres_role)){
                $user_can_view_all_centres  =   true;
            }
        }

        $user_is_admin ? $user->update(['is_admin' => true]) : $user->update(['is_admin' => false]);
        $user_can_view_all_centres ? $user->update(['can_view_all_centres' => true]) : $user->update(['can_view_all_centres' => false]);

        /* Send notification on user update */
        if(auth()->user()->is_admin == false){
            $data  =   array('approval_data' => $request->all());
            NotificationHelper::sendApprovalNotifications($this->update_user_config, $data);
        }

        return redirect(route('users'))->with(['type'=>'success', 'message'=>'Operation successfull !']);

    }

    public function destroy($user_id){
        User::where('ID', $user_id)->delete();
        DB::table('user_basic_information')->where('user_id', $user_id)->delete();
        DB::table('user_has_roles')->where('user_id', $user_id)->delete();

        return redirect()->back()->with(['type'=>'success', 'message'=>'User deleted successfully !']);
    }

    public function completedTour(Request $request){
        User::where('ID', $request->user_id)->update(['first_time_login' => false]);

        return back();
    }

    public function emailExist($email){
        $users = User::where('user_email', $email)->first();
        return collect($users);
    }

    public function usernameExist($username){
        $users = User::where('user_login', $username)->first();
        return collect($users);
    }

    public function resetUserPassword(Request $request){

        $random_password        =   Str::random(20);
        $hashed_random_password =   Hash::make($random_password);

        DB::table('wpvt_users')->where('ID', $request->data['user_id'])->update(['user_pass' => $hashed_random_password]);   

        $user           =   User::where('ID', $request->data['user_id'])->first();
        $credentials    =   [
            'new_password'  =>  $random_password,
        ];

        Notification::sendNow($user, new ResetUserPassword($credentials));

        return redirect()->back()->with(['type'=>'success', 'message'=>"User's password has been reset successfully! New password will be sent to their email."]);
    }

    public function checkUserExist($user_id)
    {
        $user_exist    =   DB::table('user_basic_information')
                            ->where('user_id', $user_id)
                            ->exists();

        return $user_exist;
    }

    public function getUserInfo($user_id)
    {
        $user_info  =   DB::table('user_basic_information')->where('user_id', $user_id)->first();

        return $user_info;
    }
}
