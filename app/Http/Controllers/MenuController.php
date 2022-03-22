<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;


class MenuController extends Controller
{
    public function index()
    {
        $parent_menus       =   Menu::where('menu_parent', null)->get();
        $show_child_menu    =   false;

        if(request('parent_id')){
            $show_child_menu    =   true;
            $child_menus        =   Menu::where('menu_parent', request('parent_id'))->get();
        }
        else{
            $show_child_menu    =   false;
            $child_menus        =   (object)array();
        }

        return Inertia::render('Menus/Index', [
            'parent_menus'      => $parent_menus,
            'show_child_menu'   => $show_child_menu,
            'child_menus'       => $child_menus,
        ]);
    }

    public function addMenu()
    {
        return Inertia::render('Menus/AddMenu', [
        ]);
    }

    public function storeMenu()
    {
        # code...
    }

    public function addSubMenu()
    {
        return Inertia::render('Menus/AddSubMenu', [
        ]);
    }

    public function storeSubmenu()
    {
        # code...
    }

    public function update()
    {
        # code...
    }

    public function destroy()
    {
        # code...
    }

    // public function getChildMenu(Request $request){

    //     return Inertia::render('Menus/Index', [
    //         'child_menus'  => $child_menus,
    //     ]);
    // }
}
