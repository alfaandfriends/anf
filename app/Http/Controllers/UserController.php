<?php

namespace App\Http\Controllers;

use App\Events\DatabaseTransactionEvent;
use App\Mail\ResetUserPassword;
use App\Mail\UserRegistration;
use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRoles;
use App\Notifications\UserRegistrationCredentials;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Illuminate\Support\Str;
use MikeMcLin\WpPassword\Facades\WpPassword;

class UserController extends Controller
{
    public $update_user_config = 8;

    public function index(Request $request)
    {
        $query  =   User::query();
        
        if(request('search')){
            $query  ->where('user_email', 'LIKE', '%'.request('search').'%')
                    ->orWhere('user_login', 'LIKE', '%'.request('search').'%')
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

        $roles          =   Role::get();
        $gender_list    =   DB::table('genders')->get();
        $countries      =   DB::table('countries')->get();

        return Inertia::render('Users/Create',[
            'roles'         => $roles,
            'gender_list'   => $gender_list,
            'countries' => $countries,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required:email',
            'username' => 'required',
            'full_name' => 'required',
            'country_id' => 'required',
            'calling_code' => 'required',
            'contact_number' => 'required',
            'country_state' => 'required',
            'address' => 'required',
        ]);
        
        $email_exists = User::where('user_email', $request->email)->exists();
        $username_exists = User::where('user_login', $request->username)->exists();
        if($email_exists){
            return back()->with(['type'=>'error', 'message'=>'Email address has been used.']);
        }
        if($username_exists){
            return back()->with(['type'=>'error', 'message'=>'Username has been taken.']);
        }
        if(empty($request->selected_roles)){
            return back()->with(['type'=>'error', 'message'=>'At least one (1) role is required.']);
        }
        
        $random_password        =   Str::random(20);
        $hashed_random_password =   '$wp$' . password_hash(base64_encode(hash_hmac('sha384', $random_password, 'wp-sha384', true)), PASSWORD_DEFAULT);

        try{
            DB::beginTransaction();
            $new_user_id    =   User::insertGetId([
                                    'user_login'            => $request->username,
                                    'user_pass'             => $hashed_random_password,
                                    'user_nicename'         => $request->username,
                                    'user_email'            => $request->email,
                                    'user_address'          => $request->address,
                                    'user_country_id'       => $request->country_id,
                                    'user_contact'          => $request->contact_number,
                                    'user_state'            => $request->country_state,
                                    'user_url'              => '',
                                    'user_registered'       => now(),
                                    'user_activation_key'   => '',
                                    'user_status'           => 0,
                                    'display_name'          => $request->full_name,
                                    'spam'                  => 0,
                                    'deleted'               => 0,
                                    'remember_token'        => '',
                                    'profile_updated'        => 1,
                                ]);   

            if($request->selected_roles){
                foreach($request->selected_roles as $key=>$role){
                    DB::table('user_has_roles')->insert([
                        'user_id' => $new_user_id, 
                        'role_id' => $role, 
                    ]);
                }
            }

            $user           =   User::where('ID', $new_user_id)->first();
            $credentials    =   [
                'email'     =>  $request->email,
                'username'  =>  $request->username,
                'password'  =>  $random_password,
            ];

            foreach($request->children as $key=>$children){
                DB::table('children')->insert([
                    'parent_id'     => $new_user_id,
                    'name'          => $children['name'],
                    'gender_id'     => $children['gender'],
                    'date_of_birth' => Carbon::parse($children['dob'])->format('Y-m-d'),
                ]);
            }

            Mail::to($user->user_email)->send(new UserRegistration($credentials));

            DB::commit();
                
            $log_data =   'Created user ID '.$new_user_id;
            event(new DatabaseTransactionEvent($log_data));

            return redirect(route('users'))->with(['type'=>'success', 'message'=>'Login details has been sent to the registered email.']);
        }
        catch(Exception $e){
            DB::rollback();
            return back()->with(['type'=>'error', 'message'=>'An error has occured, please try again.']);
        }
    }

    public function edit(Request $request)
    {
        $user_info  =   DB::table('wpvt_users')
                            ->leftJoin('countries', 'wpvt_users.user_country_id', '=', 'countries.id')
                            ->where('wpvt_users.id', $request->user_id)
                            ->select('wpvt_users.id as user_id', 'wpvt_users.user_email', 'wpvt_users.user_login', 'wpvt_users.display_name', 'wpvt_users.user_country_id', 'wpvt_users.user_state', 'wpvt_users.user_address', 
                                    'wpvt_users.user_contact', 'wpvt_users.user_photo', 'countries.name', 'countries.country_code', 'countries.currency_name', 
                                    'countries.currency_code', 'countries.currency_symbol', 'countries.calling_code')
                            ->first();
        
        $roles          =   Role::get();
        $user_roles     =   UserHasRoles::where('user_id', $request->user_id)->get('role_id')->keyBy('role_id');
        $gender_list    =   DB::table('genders')->get();
        $children       =   DB::table('children')->where('parent_id', $request->user_id)->get();
        $countries      =   DB::table('countries')->get();

        return Inertia::render('Users/Edit', [
            'user_info'     => $user_info,
            'roles'         => $roles,
            'user_roles'    => $user_roles,
            'gender_list'   => $gender_list,
            'children'      => $children,
            'countries'     => $countries,
        ]);
    }

    public function update(Request $request)
    {
        $user                           =   User::find($request->user_id);

        $admin_role                     =   array(1, 2);
        $can_view_all_centres_role      =   array(1, 2, 3, 9);

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
        // if(auth()->user()->is_admin == false){
        //     $data  =   array('approval_data' => $request->all());
        //     NotificationHelper::sendApprovalNotifications($this->update_user_config, $data);
        // }
        
        User::where('ID', $request->user_id)->update([
            'user_nicename'         => $request['form']['username'],
            'user_address'          => $request['form']['address'],
            'user_country_id'       => $request['form']['country_id'],
            'user_contact'          => $request['form']['contact_number'],
            'user_state'            => $request['form']['country_state'],
            'display_name'          => $request['form']['full_name'],
        ]);   
                
        $log_data =   'Updated user ID '.$request->user_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect(route('users'))->with(['type'=>'success', 'message'=>'Data has been saved.']);

    }

    public function destroy($user_id){
        User::where('ID', $user_id)->delete();
        DB::table('user_has_roles')->where('user_id', $user_id)->delete();
                
        $log_data =   'Deleted user ID '.$user_id;
        event(new DatabaseTransactionEvent($log_data));

        return redirect()->back()->with(['type'=>'success', 'message'=>'Data has been deleted.']);
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
        $hashed_random_password =   '$wp$' . password_hash(base64_encode(hash_hmac('sha384', $random_password, 'wp-sha384', true)), PASSWORD_DEFAULT);
        
        DB::table('wpvt_users')->where('ID', $request->data)->update(['user_pass' => $hashed_random_password]);   

        $user           =   User::where('ID', $request->data)->first();
        $credentials    =   [
            'new_password'  =>  $random_password,
        ];
        
        Mail::to($user->user_email)->send(new resetUserPassword($credentials));
                
        $log_data =   'Resetted password for user ID '.$request->data;
        event(new DatabaseTransactionEvent($log_data));

        return redirect()->back()->with(['type'=>'success', 'message'=>"New password has been set and sent to their email."]);
    }

    public function getUserInfo($user_id)
    {
        $user_info  =   User::where('ID', $user_id)->first();

        return $user_info;
    }

    public function getUsers(Request $request){
        $users  =   User::where('display_name', 'LIKE', '%'.$request->keyword.'%')->limit(10)->get();

        return $users;
    }
}
