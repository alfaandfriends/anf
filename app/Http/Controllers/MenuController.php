<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class MenuController extends Controller
{
    public function index()
    {
        $menus                =   Menu::getMenu();
        $sub_menus            =   array();
        $show_sub_menu        =   false;
        $menu_id              =   '';

        if(request('menu_id')){
            $sub_menus        =   Menu::getSubMenu(request('menu_id'));
            $show_sub_menu    =   true;
            $menu_id          =   request('menu_id');
        }

        return Inertia::render('Menus/Index', [
            'menus'           => $menus,
            'sub_menus'       => $sub_menus,
            'show_sub_menu'   => $show_sub_menu,
            'menu_id'         => $menu_id,
        ]);
    }

    public function addMenu()
    {
        return Inertia::render('Menus/AddMenu');
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'menu_label'    => 'required',
            'menu_icon'     => 'required'
        ]);

        $current_rank   =   Menu::orderBy('menu_rank', 'desc')->pluck('menu_rank')->first();
        $next_rank      =   $current_rank + 1;
        dd($next_rank);

        DB::table('menus')->insert([
            'menu_label' => $request->menu_label,
            'menu_route' => $request->menu_route,
            'menu_icon' => $request->menu_icon,
            'menu_rank' => $next_rank,
            'menu_status' => $request->menu_status
        ]);
        
        return redirect('menus')->with(['type'=>'success', 'message'=>'Menu added successfully !']);
    }

    public function addSubMenu()
    {
        return Inertia::render('Menus/AddSubMenu', [
            'menu_id'       =>   request('menu_id'),
            'url_redirect'  =>   url()->previous()
        ]);
    }

    public function storeSubmenu(Request $request)
    {
        $request->validate([
            'menu_sub_label' => 'required',
        ],
        [
            'menu_sub_label.required' => 'The sub menu label is required.'
        ]);
        
        DB::table('menus_sub')->insert([
            'menu_id'           => $request->menu_id,
            'menu_sub_label'    => $request->menu_sub_label,
            'menu_sub_route'    => $request->menu_sub_route,
            'menu_sub_status'   => $request->menu_sub_status
        ]);
        
        return redirect($request->url_redirect)->with(['type'=>'success', 'message'=>'Sub menu added successfully !']);
    }

    public function editMenu()
    {
        $menus  =   Menu::getMenu(request('menu_id'));

        return Inertia::render('Menus/EditMenu',[
            'menus'    =>  $menus
        ]);
    }

    public function updateMenu(Request $request)
    {
        $request->validate([
            'menu_label' => 'required',
            'menu_icon' => 'required'
        ]);

        DB::table('menus')
            ->where('id', $request->menu_id)
            ->update([
                'menu_icon' => $request->menu_icon,
                'menu_label' => $request->menu_label,
                'menu_route' => $request->menu_route,
                'menu_status' => $request->menu_status
            ]);

        return redirect('menus')->with(['type'=>'success', 'message'=>'Menu updated successfully !']);
    }

    public function editSubMenu()
    {
        $sub_menus          =   Menu::getSubMenu(request('menu_id'), $by_parent_menu_id=false);
        $url_redirect       =   url()->previous();

        return Inertia::render('Menus/EditSubMenu',[
            'sub_menus'    =>  $sub_menus,
            'url_redirect'    =>  $url_redirect
        ]);
    }

    public function updateSubMenu(Request $request)
    {
        $request->validate([
            'menu_sub_label' => 'required',
        ]);

        DB::table('menus_sub')
            ->where('id', $request->menu_id)
            ->update([
                'menu_sub_label' => $request->menu_sub_label,
                'menu_sub_route' => $request->menu_sub_route,
                'menu_sub_status' => $request->menu_sub_status
            ]);

        return redirect($request->url_redirect)->with(['type'=>'success', 'message'=>'Menu updated successfully !']);
    }

    public function destroyMenu($menu_id)
    {
        Menu::deleteMenu($menu_id);

        return redirect('menus')->with(['type'=>'success', 'message'=>'Menu deleted successfully !']);
    }

    public function destroySubMenu($sub_menu_id)
    {   
        Menu::deleteSubMenu($sub_menu_id);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Sub Menu deleted successfully !']);
    }

    public function swapMenuUp(Request $request){
        $current_rank   =   Menu::where('id', $request->menu_id)->pluck('menu_rank')->first();
        $next_rank      =   $current_rank - 1;

        DB::table('menus')->where('menu_rank', $next_rank)->update(['menu_rank'=> $current_rank]);
        DB::table('menus')->where('id', $request->menu_id)->update(['menu_rank'=> $next_rank]);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Menu order changed successfully !']);
    }

    public function swapMenuDown(Request $request){
        $current_rank   =   Menu::where('id', $request->menu_id)->pluck('menu_rank')->first();
        $next_rank      =   $current_rank + 1;

        DB::table('menus')->where('menu_rank', $next_rank)->update(['menu_rank'=> $current_rank]);
        DB::table('menus')->where('id', $request->menu_id)->update(['menu_rank'=> $next_rank]);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Menu order changed successfully !']);
    }

    public function swapSubMenuUp(Request $request){
        $current_rank   =   DB::table('menus_sub')->where('menu_id', $request->menu_id)
                                    ->where('id', $request->sub_menu_id)
                                    ->pluck('menu_sub_rank')
                                    ->first();
        $next_rank      =   (int)$current_rank - 1;

        DB::table('menus_sub')->where('menu_sub_rank', $next_rank)
                        ->where('menu_id', $request->menu_id)
                        ->update(['menu_sub_rank'=> $current_rank]);
        DB::table('menus_sub')->where('id', $request->sub_menu_id)->update(['menu_sub_rank'=> $next_rank]);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Menu order changed successfully !']);
    }

    public function swapSubMenuDown(Request $request){
        $current_rank   =   DB::table('menus_sub')->where('menu_id', $request->menu_id)
                                    ->where('id', $request->sub_menu_id)
                                    ->pluck('menu_sub_rank')
                                    ->first();
        $next_rank      =   (int)$current_rank + 1;

        DB::table('menus_sub')->where('menu_sub_rank', $next_rank)
                        ->where('menu_id', $request->menu_id)
                        ->update(['menu_sub_rank'=> $current_rank]);
        DB::table('menus_sub')->where('id', $request->sub_menu_id)->update(['menu_sub_rank'=> $next_rank]);

        return redirect()->back()->with(['type'=>'success', 'message'=>'Menu order changed successfully !']);
    }
}
