<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    public static function getAllMenu(){
        $menu_result        =   DB::table('menus')->where('menu_status', 1)->orderBy('menu_rank', 'desc')->get();
        $sub_menus_result   =   DB::table('menus_sub')->where('menu_sub_status', 1)->get();

        foreach($menu_result as $key=>$menu){

            $menu_info['menu_icon']      =   $menu->menu_icon;
            $menu_info['menu_label']     =   $menu->menu_label;
            $menu_info['menu_route']     =   $menu->menu_route;
            $menu_info['menu_status']    =   $menu->menu_status;
            $menu_info['permission_name']   =   $menu->permission_name;
            $menus[$menu->id]            =   $menu_info;

            if(!empty($sub_menus_result)){
                $sub_menus                   =  array();
                foreach($sub_menus_result as $key=>$sub_menu){
                    if($sub_menu->menu_id == $menu->id){
                        $sub_menu_info['sub_menu_label']    =   $sub_menu->menu_sub_label;
                        $sub_menu_info['sub_menu_route']    =   $sub_menu->menu_sub_route;
                        $sub_menu_info['sub_menu_status']   =   $sub_menu->menu_sub_status;
                        $sub_menus[$sub_menu->id]           =   $sub_menu_info;
                    }
                    $menus[$menu->id]['sub_menu']       =   (object)$sub_menus;
                }
            }
        }

        return $menus;
    }

    public static function getMenu($menu_id=''){

        if($menu_id != ''){
            $menu   =   DB::table('menus')->where('id', $menu_id)->first();
        }
        else{
            $menu   =   DB::table('menus')->get();
        }

        return $menu;
    }

    public static function getSubMenu($menu_id, $by_parent_menu_id = true){

        if($by_parent_menu_id){
            $sub_menu   =   DB::table('menus_sub')->where('menu_id', $menu_id)->get();
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
