<?php

namespace App\Http\Controllers;

use App\Models\Right;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\role_right;
use App\Models\Menu;


class RightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::where('status','like','1')->orderBy('sort_order','asc')->get();
        return view('configuration.others.right',compact('roles'));
    }

    public function save_assign_right(Request $request)
    {
               
              $role_id=$request->role_id;

            $menus=Menu::get();
            $not=[]; 
            foreach ($menus as $me) {
                  
                  $index='r'.$me['id'];
                $r=$request->$index;
                     //print_r($r);
                if($r=='')
                  array_push($not, $me['id']);
                else
                {
                $right=role_right::where('right_id',$me['id'])->where('role_id',$role_id)->first();
                if($right=='')
                    $right=new role_right;

                $right->role_id=$role_id;


                $right->right_id=$me['id'];
                $right->save();
                }
            }
//die;
            $right=role_right::where('role_id',$role_id)->whereIn('right_id',$not)->get();

            foreach ($right as $k) {
               $k->delete();
            }

              
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Right  $right
     * @return \Illuminate\Http\Response
     */
    public function show(Right $right)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Right  $right
     * @return \Illuminate\Http\Response
     */
    public function edit(Right $right)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Right  $right
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Right $right)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Right  $right
     * @return \Illuminate\Http\Response
     */
    public function destroy(Right $right)
    {
        //
    }
}
