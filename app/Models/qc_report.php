<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qc_report extends Model
{
    use HasFactory;

    public function parameters()
    {
        return $this->hasMany(qc_parameter::class,'report_id','id');
    }

    public function sampling()
    {
        return $this->hasOne(sampling::class,'id','sampling_id');
    }

    public static function get_qc_report($result_id)
    {
    	$rslt=qc_report::find($result_id);

    	$request=sampling::get_sampling($rslt['sampling_id']);

    	$result=array('id'=>$rslt['id'],'qa_sample_id'=>$rslt['qa_sample_id'],'qc_number'=>$rslt['qc_number'],'testing_specs'=>$rslt['testing_specs'],'tested_date'=>$rslt['tested_date'],'released_date'=>$rslt['released_date'],'released_time'=>$rslt['released_time'],'retest_date'=>$rslt['retest_date'],'is_active'=>$rslt['is_active'],'released'=>$rslt['released'],'remarks'=>$rslt['remarks'],'parameters'=>$rslt->parameters,'request'=>$request);

    	return $result;
    }


    

    
}
