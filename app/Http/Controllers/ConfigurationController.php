<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\InventoryDepartment;
use App\Models\InventoryType;
use App\Models\InventoryCategory;
use App\Models\InventorySize;
use App\Models\InventoryColor;
use App\Models\Shape;
use App\Models\Origin;
use App\Models\Unit;
use App\Models\Account;

class ConfigurationController extends Controller
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

    public function account_types()
    {
        $types=Configuration::where('type','like','sub_sub_account_type')->orWhere('type','like','main_account_type')->get();

        return view('accounts.account_type',compact('types'));
    }

    public function account_type_save(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';
        $depart=new Configuration;

        $depart->name=$request->get('name');
        $depart->type=$request->get('type');
        $depart->description=$request->get('remarks');
    

        $depart->status=$status;

       

        $depart->save();

     return redirect()->back()->with('success','Type Added!');
    }

    public function organization_department()
    {
        $departments=Configuration::where('type','like','organization_department')->orderBy('sort_order','asc')->get();

        return view('configuration.organization_department',compact('departments'));
    }

    public function save_organization_department(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';
        $depart=new Configuration;

        $depart->name=$request->get('department');
        $depart->type='organization_department';
        $depart->description=$request->get('description');
        $depart->sort_order=$request->get('sort_order');

        $depart->status=$status;

       

        $depart->save();

     return redirect()->back()->with('success','Department Added!');
    }

    public function inventory_department(Request $request)
    {
        $departments=InventoryDepartment::orderBy('sort_order','asc')->get();
         $accounts=Account::where('type','detail')->orderBy('name','asc')->orderBy('created_at','desc')->get();
        return view('inventory.inventory_department',compact('departments','accounts'));
    }

public function save_inventory_department(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';
        $depart=new InventoryDepartment;

        $depart->name=$request->get('name');
        $depart->code=$request->get('code');
        $depart->account_id=$request->get('account_id');
        $depart->cgs_account_id=$request->get('cgs_account_id');
        $depart->sale_account_id=$request->get('sale_account_id');
        $depart->description=$request->get('description');
        $depart->sort_order=$request->get('sort_order');

        $depart->status=$status;

       

        $depart->save();

     return redirect()->back()->with('success','Department Added!');
    }

    public function inventory_department_edit(InventoryDepartment $department)
    {
        $departments=InventoryDepartment::orderBy('sort_order','asc')->get();
         $accounts=Account::where('type','detail')->orderBy('name','asc')->orderBy('created_at','desc')->get();
         //print_r($department);die;
        return view('inventory.config.inventory_department_edit',compact('departments','accounts','department'));
    }

public function update_inventory_department(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $depart=InventoryDepartment::find($request->get('id'));

        $depart->name=$request->get('name');
        $depart->code=$request->get('code');
        $depart->account_id=$request->get('account_id');
        $depart->cgs_account_id=$request->get('cgs_account_id');
        $depart->sale_account_id=$request->get('sale_account_id');
        $depart->description=$request->get('description');
        $depart->sort_order=$request->get('sort_order');

        $depart->status=$status;

       

        $depart->save();

     return redirect()->back()->with('success','Department Updated!');
    }

     public function inventory_type(Request $request)
    {
        $types=InventoryType::get();

        $categories=InventoryCategory::get();
         $shapes=Shape::orderBy('name','asc')->get();
        $sizes=InventorySize::orderBy('name','asc')->get();

        return view('inventory.inventory_type',compact('types','categories','shapes','sizes'));
    }

public function save_inventory_type(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $type=new InventoryType;
         $type->category_id=$request->get('category_id');
        $type->name=$request->get('name');
        $type->code=$request->get('code');
        $type->shape_id=$request->get('shape_id');
        $type->size_id=$request->get('size_id');

        //$type->status=$status;

       

        $type->save();

     return redirect()->back()->with('success','Type Added!');
    }

    public function inventory_category(Request $request)
    {
        $categories=InventoryCategory::orderBy('code','asc')->get();

        $cat= InventoryCategory::orderBy('code','desc')->latest()->first();

         $code=1;

        if(isset($cat['code']))
        $code = $cat['code']+1;

        return view('inventory.inventory_category',compact('categories','code'));
    }

public function save_inventory_category(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $category=new InventoryCategory;

        $category->name=$request->get('name');
        $category->code=$request->get('code');
       // $category->description=$request->get('description');
        //$category->sort_order=$request->get('sort_order');

        $category->status=$status;

       

        $category->save();

     return redirect()->back()->with('success','Category Added!');
    }

    public function inventory_size(Request $request)
    {
        $sizes=InventorySize::orderBy('name','asc')->get();
        return view('inventory.item_size',compact('sizes'));
    }

public function save_inventory_size(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $size=new InventorySize;

        $size->name=$request->get('name');
        
        /*$size->description=$request->get('description');
        $size->sort_order=$request->get('sort_order');

        $size->status=$status;*/

       

        $size->save();

     return redirect()->back()->with('success','Size Added!');
    }

    public function inventory_color(Request $request)
    {
        $colors=InventoryColor::orderBy('name','asc')->get();
        return view('inventory.item_color',compact('colors'));
    }

public function save_inventory_color(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';
        $color=new InventoryColor;

        $color->name=$request->get('name');
        
        /*$color->description=$request->get('description');
        $color->sort_order=$request->get('sort_order');

        $color->status=$status;*/

       

        $color->save();

     return redirect()->back()->with('success','Shape Added!');
    }

    public function inventory_unit(Request $request)
    {
        $units=Unit::orderBy('sort_order','asc')->get();
        return view('inventory.unit',compact('units'));
    }

public function save_inventory_unit(Request $request)
    {
        $status=$request->get('status');

        if($status=='')
            $status='0';

        $unit=new Unit;

        $unit->name=$request->get('name');
        
        $unit->description=$request->get('description');
        $unit->sort_order=$request->get('sort_order');
            //$unit->decimal=$request->get('decimal');
        $unit->status=$status;

       

        $unit->save();

     return redirect()->back()->with('success','Unit Added!');
    }

    public function inventory_origin(Request $request)
    {
        $origins=Origin::orderBy('sort_order','asc')->get();
        return view('inventory.origin',compact('origins'));
    }

public function save_inventory_origin(Request $request)
    {
        $status=$request->get('status');
        if($status=='')
            $status='0';

        $origin=new Origin;

        $origin->name=$request->get('name');
        
        $origin->description=$request->get('description');
        $origin->sort_order=$request->get('sort_order');

        $origin->status=$statu

       

        $origin->save();

     return redirect()->back()->with('success','Origin Added!');
    }

    public function company_config(Request $request)
    {

        $name=Configuration::company_full_name();
        $short_name=Configuration::company_short_name();
        $abbreviation=Configuration::company_abbreviation();
        $phone=Configuration::company_phone();
        $mobile=Configuration::company_mobile();
         $whats_app=Configuration::company_whats_app();
        $email=Configuration::company_email();
         $fax=Configuration::company_fax();
        $head_office=Configuration::company_head_office();
        $factory_address=Configuration::company_factory_address();
        $logo=Configuration::company_logo();
        $tag_line=Configuration::company_tag_line();
        
        return view('configuration.company',compact('name','short_name','abbreviation','tag_line','phone','mobile','whats_app','fax','email','head_office','factory_address','logo'));
    }

    public function company_config_update(Request $request)
    {     
        
        if($request->hasfile('logo')) 
            { 
                $allowedfileExtension=['jpeg','jpg','png','gif'];

              $file = $request->file('logo');
              $extension = $file->getClientOriginalExtension(); // getting image extension
              $filename = $file->getClientOriginalName();

              //print_r($filename);die;

              $check=in_array($extension,$allowedfileExtension);
                if($check)
               {
                 $path ='public/images/logo/';

                   $config=Configuration::where('type','company_logo')->first();
                    if($config!='' && isset($config['name']) && $config['name']!='')
                        {  

                          unlink($config['name']); 

                           }
                        if($config=='')
                        {  $config=new Configuration;   }
                        $config->name=$path.$filename;
                        $config->type='company_logo';
                       // $config->description=$request->get('factory_address');
                        $config->save();

                  $file->move($path , $filename);
               }
               else
               {
                      return redirect()->back()->with('error','Kindly upload jpeg, jpg or png!');
               }

              
            }

     //return redirect()->back()->with('success','Logo Info updated!');

        $config=Configuration::where('type','company_full_name')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('comp_name');
        $config->type='company_full_name';
        $config->save();

        $config=Configuration::where('type','company_short_name')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('short_name');
        $config->type='company_short_name';
        $config->save();

        $config=Configuration::where('type','company_abbreviation')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('abbreviation');
        $config->type='company_abbreviation';
        $config->save();

        $config=Configuration::where('type','company_tag_line')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('tag_line');
        $config->type='company_tag_line';
        $config->save();



        $config=Configuration::where('type','company_phone')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('phone');
        $config->type='company_phone';
        $config->save();

        $config=Configuration::where('type','company_mobile')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('mobile');
        $config->type='company_mobile';
        $config->save();

        $config=Configuration::where('type','company_whats_app')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('whats_app');
        $config->type='company_whats_app';
        $config->save();

        $config=Configuration::where('type','company_email')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('email');
        $config->type='company_email';
        $config->save();

        $config=Configuration::where('type','company_fax')->first();
        if($config=='')
        $config=new Configuration;
        $config->name=$request->get('fax');
        $config->type='company_fax';
        $config->save();


        $config=Configuration::where('type','company_head_office')->first();
        if($config=='')
        $config=new Configuration;
        $config->name='Head Office Address';
        $config->type='company_head_office';
        $config->description=$request->get('head_office');
        $config->save();

        $config=Configuration::where('type','company_factory_address')->first();
        if($config=='')
        $config=new Configuration;
        $config->name='Factory Address';
        $config->type='company_factory_address';
        $config->description=$request->get('factory_address');
        $config->save();

       
       


     return redirect()->back()->with('success','Company Info updated!');
        
    }


    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function show(Configuration $configuration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function edit(Configuration $configuration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Configuration $configuration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Configuration $configuration)
    {
        //
    }
}
