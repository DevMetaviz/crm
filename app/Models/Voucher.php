<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Configuration;
use App\Models\Voucher;

class Voucher extends Model
{
    use HasFactory;

     protected $fillable = [
        'voucher_no',
        'voucher_date',
        'pay_method',
       'voucher_type_id',
        'remarks',
        'status',
        'category',
        'denominations',
        'notes',
        'company_id',
        'branch_id',
        'user_id',
        'updated_by'
    ];

    


     public function files()
    {
        return $this->hasMany(VoucherFile::class);
    }


    public function voucher_type()
    {
        return $this->belongsTo('App\Models\Configuration','voucher_type_id');
    }

     public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function last_updated_by()
    {
        return $this->belongsTo('App\Models\User','updated_by');
    }
     public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
     public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class,'account_voucher','voucher_id','account_id')->withPivot('id','account_voucherable_id','account_voucherable_type','remarks','cheque_no','cheque_date','debit','credit')->withTimestamps();
    }

    public function amount()
    {
        $total = 0;
        foreach ($this->accounts as $item ) {
            
            $total += $item['pivot']['credit']  ;
        }

        return $total ;
    }


    public function transections()
    {
        return $this->morphMany(Transection::class, 'account_voucherable');
    }

    public static function get_voucher_no($request)
    {
          $voucher_type_id=$request['voucher_type'];
         $voucher_type=Configuration::find($voucher_type_id);
         $voucher_type_code=$voucher_type['attributes'];
          
           $voucher_date=$request['voucher_date'];
            $let=explode('-', $voucher_date);
            $month=$let[1];
            $year=$let[0];

          $doc_no=$voucher_type_code."-".Date("y",strtotime($voucher_date))."-".$month."-";
           $num=1;

           $voucher=Voucher::where('voucher_type_id',$voucher_type['id'])->where('voucher_no','like',$doc_no.'%')->orderBy('voucher_no','desc')->first();

         
         if($voucher=='')
         {
              $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
         else
         {
            $let=explode($doc_no , $voucher['voucher_no']);
            $num=intval($let[1]) + 1;
            $let=sprintf('%03d', $num);
              $doc_no=$doc_no. $let;
         }
            //voucher type will use in Voucher
         $data=array('doc_no'=>$doc_no,'voucher_type'=>$voucher_type);

        return $data;


    }


    


}
