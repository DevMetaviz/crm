<?php

namespace App\Http\Controllers;

use App\Models\Allowance;

use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Configuration;
use Illuminate\Http\Request;


class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

     
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    public function menu()
    {
        $menu=Menu::where('super_id','like','0')->orderBy('sort_order','asc')->get();
        return view('configuration.menu',compact('menu'));
    }
   
   public function save_menu(Request $request)
    {
        if($request->get('super_menu_id')==0)
            $type='super_menu_item';
        else
            $type='sub_menu_item';

        $menu=new Menu;


        $menu->text=$request->get('text');
        $menu->link=$request->get('link');
        //$menu->type=$type;
        $menu->type=$request->get('type');
         $menu->super_id=$request->get('super_menu_id');
        $menu->sort_order=$request->get('sort_order');
       

        $menu->save();

     return redirect()->back()->with('success','Menu Item Added!');
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
