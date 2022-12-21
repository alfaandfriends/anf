<?php

namespace App\Http\Middleware;

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
            $user_has_notification  =   $this->userHasNotifications();
            $notifications          =   $this->userNotifications();
            $user_has_roles         =   $this->userHasRoles();
        }

        // if(empty($permissions) && Auth::user()->getImpersonatorID() != Auth::id()){
        //     return redirect('/');
        // }
        
        return array_merge(parent::share($request), [
            'app_name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
                'profile_photo' => $profile_picture ?? '',
                'first_time_login' => $request->user()->first_time_login ?? '',
                'profile_updated' => $request->user()->profile_updated ?? ''
            ],
            'flash' => [
                'type' => fn () => $request->session()->get('type'),
                'message' => fn () => $request->session()->get('message')
            ],
            'menu' => $menus ?? '',
            'can' => $permissions ?? '',
            'notifications' => $notifications ?? '',
            'user_has_notifications' => $user_has_notification ?? '',
            'allowed_centres' => $allowed_centres ?? '',
            'user_has_roles' => $user_has_roles ?? '',

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

        $permissions['is_impersonated'] = Auth::user()->isImpersonated();

        return $permissions;
    }

    public function userMenus()
    {
        $menus  =   Menu::getAllMenu();

        return $menus;
    }

    public function userProfilePicture()
    {
        $profile_picture    =   DB::table('user_basic_information')->where('user_id', Auth::id())->pluck('user_photo')->first();

        return $profile_picture;
    }

    public function userAllowedCentres()
    {
        if(Auth::user()->is_admin){
            $allowed_centres    =   DB::table('centres')->orderBy('id')->get(['centres.ID', 'centres.label']);
        }
        else{
            $allowed_centres    =   DB::table('user_has_centres')
                ->join('centres', 'user_has_centres.centre_id', '=', 'centres.ID')
                ->where('user_id', Auth::id())->orderBy('id')
                ->orderBy('id')
                ->get(['centres.ID', 'centres.label']);
        }

        return $allowed_centres;
    }

    public function userHasNotifications()
    {
        $user_has_roles =   $this->userHasRoles();
        $user_has_notifications  =   DB::table('notifications')
        ->whereIn('notifications.role_to_notify', $user_has_roles)
        ->orWhere('notifications.user_to_notify', Auth::id())
        ->where('seen', false)
        ->exists();
        // dd($user_has_notifications);

        return $user_has_notifications;
    }

    public function userNotifications()
    {
        $user_has_roles =   $this->userHasRoles();
        $notications    =   DB::table('notifications')
                            ->join('notification_types', 'notifications.type', '=', 'notification_types.id')
                            ->whereIn('notifications.role_to_notify', $user_has_roles)
                            ->orWhere('notifications.user_to_notify', Auth::id())
                            ->orderByDesc('notifications.id')
                            ->select(['notifications.id', 'notifications.user_to_notify', 'notifications.created_by', 'notifications.created_at', 'notification_types.icon', 'notification_types.content', 'notifications.seen'])
                            ->get(5);
                            
        return $notications;
    }

    public function userHasRoles()
    {
        $user_has_roles =   collect(UserHasRoles::where('user_id', Auth::id())->pluck('role_id'))->toArray();

        return $user_has_roles;
    }
}
