<?php

namespace App\Http\Middleware;

use Corcel\Model\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\UserHasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        if($request->user()){
            $permissions            =   $this->userPermissions();
            $menus                  =   $this->userMenus();
            $profile_picture        =   $this->userProfilePicture();
            $allowed_centres        =   $this->userAllowedCentres();
            $user_is_admin          =   $this->userIsAdmin();
            $user_has_notification  =   $this->userHasNotifications();
            $user_notifications     =   $this->userNotifications();
            $user_has_roles         =   $this->userHasRoles();
            $user_has_children      =   $this->userHasChildren();
        }
        
        if(!empty($user_has_children)){
            if (!$request->session()->has('current_active_child')) {
                $child_session_data =   [
                    'child_id'      =>  $user_has_children->pluck('child_id')->first(),
                    'child_name'    =>  $user_has_children->pluck('child_name')->first(),
                    'student_id'    =>  $user_has_children->pluck('student_id')->first()
                ]; 
                $request->session()->put('current_active_child', $child_session_data);
            }
            if($request->session()->has('current_active_child')){
                $child_session_data =   [
                    'child_id'      =>  $user_has_children->where('child_id', $request->session()->get('current_active_child.child_id'))->pluck('child_id')->first(),
                    'child_name'    =>  $user_has_children->where('child_id', $request->session()->get('current_active_child.child_id'))->pluck('child_name')->first(),
                    'student_id'    =>  $user_has_children->where('child_id', $request->session()->get('current_active_child.child_id'))->pluck('student_id')->first()
                ]; 
                $request->session()->put('current_active_child', $child_session_data);
            }
        }
        
        return array_merge(parent::share($request), [
            'app_name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
                'profile_photo' => $profile_picture ?? '',
                'first_time_login' => $request->user()->first_time_login ?? false,
                'profile_updated' => $request->user()->profile_updated ?? false
            ],
            'flash' => [
                'type' => fn () => $request->session()->get('type'),
                'header' => fn () => $request->session()->get('header'),
                'message' => fn () => $request->session()->get('message'),
            ],
            'menu' => $menus ?? '',
            'can' => $permissions ?? '',
            'user_is_admin' => $user_is_admin ?? false,
            'user_notifications' => $user_notifications ?? '',
            'user_has_notifications' => $user_has_notification ?? '',
            'allowed_centres' => $allowed_centres ?? '',
            'user_has_roles' => $user_has_roles ?? '',
            'user_has_children' => $user_has_children ?? '',
            'current_active_child' => $request->session()->get('current_active_child') ?? '',

        ]);
    }

    public function userPermissions(){
        $user_roles     =   collect(UserHasRoles::where('user_id', Auth::id())->get('role_id'));

        $roles          =   Permission::with('role_has_permissions')->whereHas('role_has_permissions', function ($q) use ($user_roles) {
                                $q->whereIn('role_id', $user_roles);
                            })->get();
        
        $permissions    =   array();
        if(!empty($roles)){
            foreach($roles as $key=>$role){
                $permissions[$role->name] = true;
            }
        }

        $permissions['is_impersonated'] = auth()->user()->isImpersonated();

        return $permissions;
    }

    public function userMenus()
    {
        $menus  =   Menu::getAllMenu();

        return $menus;
    }

    public function userProfilePicture()
    {
        $profile_picture    =   User::where('ID', Auth::id())->pluck('user_photo')->first();

        return $profile_picture;
    }

    public function userAllowedCentres()
    {
        if(auth()->user()->can_view_all_centres || auth()->user()->is_admin){
            $allowed_centres    =   DB::table('centres')->orderBy('id')->get(['centres.ID', 'centres.label']);
        }
        else{
            $allowed_centres    =   DB::table('user_has_centres')
                                    ->join('centres', 'user_has_centres.centre_id', '=', 'centres.ID')
                                    ->where('user_id', 0)->orderBy('id')
                                    ->orderBy('id')
                                    ->get(['centres.ID', 'centres.label']);
        }

        return $allowed_centres;
    }

    public function userHasNotifications()
    {
        $user_has_roles     =   $this->userHasRoles();
        $result             =   DB::table('notifications')
                                    ->where(function($query) use ($user_has_roles){
                                        $query->whereIn('notifications.role_to_notify', $user_has_roles);
                                        $query->orWhere('notifications.user_to_notify', Auth::id());
                                    })
                                    ->where('seen', false)
                                    ->count();
                                    
        $user_has_notifications =   $result > 0 ? true : false;

        return $user_has_notifications;
    }

    public function userNotifications()
    {
        $user_has_roles         =   $this->userHasRoles();
        $user_notifications     =   DB::table('notifications')
                                        ->join('notification_config_data', 'notifications.notification_config_data_id', '=', 'notification_config_data.id')
                                        ->whereIn('notifications.role_to_notify', $user_has_roles)
                                        ->orWhere('notifications.user_to_notify', Auth::id())
                                        ->orderByDesc('notifications.id')
                                        ->select([  'notifications.id', 
                                                    'notifications.user_to_notify', 
                                                    'notifications.created_by', 
                                                    'notifications.created_at', 
                                                    'notification_config_data.panel_icon', 
                                                    'notification_config_data.panel_content', 
                                                    'notifications.seen'])
                                        ->limit(5)
                                        ->get();                                    
        return $user_notifications;
    }

    public function userHasRoles()
    {
        $user_has_roles =   collect(UserHasRoles::where('user_id', Auth::id())->pluck('role_id'))->toArray();

        return $user_has_roles;
    }

    public function userIsAdmin()
    {
        $user_is_admin =   auth()->user()->is_admin;

        return $user_is_admin;
    }

    public function userHasChildren(){
        $user_has_children =   collect(DB::table('children')
                                ->leftJoin('students', 'students.children_id', '=', 'children.id')
                                ->where('parent_id', Auth::id())
                                ->select('students.id as student_id', 'children.id as child_id', 'children.name as child_name')
                                ->get());
        return $user_has_children;
    }
}
