<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    public static function getAllMenu(){
        // $menu_result        =   DB::table('menus')->where('menu_status', 1)->orderBy('menu_rank', 'asc')->get();
        // $sub_menus_result   =   DB::table('menus_sub')->where('menu_sub_status', 1)->orderBy('menu_sub_rank', 'asc')->get();
        // $menus              =   array();
        
        // foreach($menu_result as $key=>$menu){
        //     $menu_info['menu_icon']         =   $menu->menu_icon;
        //     $menu_info['menu_label']        =   $menu->menu_label;
        //     $menu_info['menu_route']        =   $menu->menu_route;
        //     $menu_info['menu_status']       =   $menu->menu_status;
        //     $menu_info['permission_name']   =   $menu->permission_name;
        //     $menus[$key]                    =   $menu_info;

        //     if(!empty($sub_menus_result)){
        //         $sub_menus                   =  array();
        //         foreach($sub_menus_result as $sub_key=>$sub_menu){
        //             if($sub_menu->menu_id == $menu->id){
        //                 $sub_menu_info['sub_menu_label']    =   $sub_menu->menu_sub_label;
        //                 $sub_menu_info['sub_menu_route']    =   $sub_menu->menu_sub_route;
        //                 $sub_menu_info['sub_menu_status']   =   $sub_menu->menu_sub_status;
        //                 $sub_menu_info['permission_name']   =   $sub_menu->permission_name;
        //                 $sub_menus[$sub_key]               =   $sub_menu_info;
        //             }
        //             $menus[$key]['sub_menu']       =   (object)$sub_menus;
        //         }
        //     }
        // }

        $data = DB::table('menu_sections')
                    ->leftJoin('menus', 'menu_sections.id', '=', 'menus.section_id')
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
                    ->orderBy('menu_sections.id')
                    ->orderBy('menus.menu_rank')
                    ->orderBy('menus_sub.menu_sub_rank')
                    ->get();

        $sections = array();
        $current_section = null;
        $current_menu = null;
        foreach ($data as $row) {
            // Check if section has changed
            if ($row->section_name !== $current_section) {
                $current_section = $row->section_name;
                $current_menu = null;
                $sections[$current_section] = array();
            }
            // Check if menu has changed
            if ($row->menu_id !== $current_menu) {
                $current_menu = $row->menu_id;
                $sections[$current_section][$current_menu]['menu_name'] = $row->menu_name;
                $sections[$current_section][$current_menu]['menu_icon'] = $row->menu_icon;
                $sections[$current_section][$current_menu]['menu_route'] = $row->menu_route;
                $sections[$current_section][$current_menu]['menu_permission'] = $row->menu_permission;
                $sections[$current_section][$current_menu]['sub_menu'] = array();
            }
            // Add submenu to current menu
            $sub_menu_info['sub_menu_id']  =   $row->sub_menu_id;
            $sub_menu_info['sub_menu_name']  =   $row->sub_menu_name;
            $sub_menu_info['sub_menu_route']  =   $row->sub_menu_route;
            $sub_menu_info['sub_menu_permission']  =   $row->sub_menu_permission;
            $sections[$current_section][$current_menu]['sub_menu'][] = $sub_menu_info;
        }
        return $sections ;
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
