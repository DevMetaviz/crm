<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    

    

    public function shifts()
    {
        return $this->belongsToMany(Shift::class,'configuration_type','configuration_id','type_id')->withPivot('attributes')->withTimestamps();
      
    }

    public function leaves()
    {
         return $this->hasMany('App\Models\Leave','leave_type_id','id');
    }

     public static function company_logo()
    {
      $path=Configuration::where('type','company_logo')->first();

      if($path=='')
        return '';
      else
         return $path->name;
    }


    public static function company_full_name()
    {
      $name=Configuration::where('type','company_full_name')->first();

      if($name=='')
      	return '';
      else
      	 return $name->name;
    }

    public static function company_short_name()
    {
      $name=Configuration::where('type','company_short_name')->first();

      if($name=='')
      	return '';
      else
      	 return $name->name;

      
    }
public static function company_abbreviation()
    {
      $name=Configuration::where('type','company_abbreviation')->first();

      if($name=='')
      	return '';
      else
      	 return $name->name;
    }

    public static function company_tag_line()
    {
      $name=Configuration::where('type','company_tag_line')->first();

      if($name=='')
        return '';
      else
         return $name->name;
    }


    public static function company_phone()
    {
    	$ph=Configuration::where('type','company_phone')->first();

      if($ph=='')
      	return '';
      else
      	 return $ph->name;

    }

    public static function company_mobile()
    {
    	$ph=Configuration::where('type','company_mobile')->first();

        if($ph=='')
      	return '';
      else
      	 return $ph->name;

    }

    public static function company_whats_app()
    {
      $ph=Configuration::where('type','company_whats_app')->first();

        if($ph=='')
        return '';
      else
         return $ph->name;

    }

    public static function company_fax()
    {
      $ph=Configuration::where('type','company_fax')->first();

        if($ph=='')
        return '';
      else
         return $ph->name;

    }


    public static function company_email()
    {
    	$ph=Configuration::where('type','company_email')->first();

        if($ph=='')
      	return '';
      else
      	 return $ph->name;

    }

    public static function company_head_office()
    {
    	$ph=Configuration::where('type','company_head_office')->first();

        if($ph=='')
      	return '';
      else
      	 return $ph->description;

    }

    public static function company_factory_address()
    {
    	$ph=Configuration::where('type','company_factory_address')->first();

         if($ph=='')
      	return '';
        else
      	 return $ph->description;

    }

    public static function transport_methods()
    {
        $methods=Configuration::where('type','transport_methods')->orderBy('sort_order')->get();


         return $methods;

    }



   


}
