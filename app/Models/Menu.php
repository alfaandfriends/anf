<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    public static function getAllMenu(){
        $data = DB::table('menu_sections')
                    ->rightJoin('menus', 'menu_sections.id', '=', 'menus.section_id')
                    ->leftJoin('menus_sub', 'menus.id', '=', 'menus_sub.menu_id')
                    ->select(
                        'menu_sections.id as section_id', 
                        'menu_sections.name as section_name', 
                        'menus.id as menu_id', 
                        'menus.menu_label as menu_name', 
                        'menus.menu_icon as menu_icon', 
                        'menus.menu_route as menu_route', 
                        'menus.permission_name as menu_permission',
                        'menus_sub.id as sub_menu_id',
                        'menus_sub.menu_sub_label as sub_menu_name',
                        'menus_sub.menu_sub_route as sub_menu_route',
                        'menus_sub.permission_name as sub_menu_permission')
                    ->orderBy('menus.menu_rank')
                    ->orderBy('menus_sub.menu_sub_rank')
                    ->get();

        // Create a multi-level array for menus
        $menuArray = [];
        foreach ($data as $row) {
            $sectionIndex = array_search($row->section_id, array_column($menuArray, 'id'));
            if ($sectionIndex === false) {
                // Section not found in array, create new section array
                $sectionArray = [
                    'id' => $row->section_id,
                    'name' => $row->section_name,
                    'menus' => [],
                ];

                $menuArray[] = $sectionArray;
                $sectionIndex = count($menuArray) - 1;
            }

            $menuIndex = array_search($row->menu_id, array_column($menuArray[$sectionIndex]['menus'], 'id'));
            if ($menuIndex === false) {
                // Menu not found in section array, create new menu array
                $menuArray[$sectionIndex]['menus'][] = [
                    'id' => $row->menu_id,
                    'menu_name' => $row->menu_name,
                    'menu_icon' => $row->menu_icon,
                    'menu_route' => $row->menu_route,
                    'menu_permission' => $row->menu_permission,
                    'sub_menus' => [],
                ];

                $menuIndex = count($menuArray[$sectionIndex]['menus']) - 1;
            }

            if ($row->sub_menu_id) {
                // Submenu found, add to menu array
                $menuArray[$sectionIndex]['menus'][$menuIndex]['sub_menus'][] = [
                    'id' => $row->sub_menu_id,
                    'sub_menu_name' => $row->sub_menu_name,
                    'sub_menu_route' => $row->sub_menu_route,
                    'sub_menu_permission' => $row->sub_menu_permission,
                ];
            }
        }
        return $menuArray;
    }

    public static function getMenu($menu_id=''){

        if($menu_id != ''){
            $menu   =   DB::table('menus')->where('id', $menu_id)->first();
        }
        else{
            $menu   =   DB::table('menus')->orderBy('menu_rank', 'asc')->get();
        }

        return $menu;
    }

    public static function getSubMenu($menu_id, $by_parent_menu_id = true){

        if($by_parent_menu_id){
            $sub_menu   =   DB::table('menus_sub')->where('menu_id', $menu_id)->orderBy('menu_sub_rank', 'asc')->get();
        }
        else{
            $sub_menu   =   DB::table('menus_sub')->where('id', $menu_id)->first();
        }

        return $sub_menu;
    }

    public static function deleteMenu($menu_id){
        DB::table('menus_sub')->where('menu_id', $menu_id)->delete();
        DB::table('menus')->where('id', $menu_id)->delete();
    }

    public static function deleteSubMenu($sub_menu_id){
        DB::table('menus_sub')->where('id', $sub_menu_id)->delete();
    }
}
