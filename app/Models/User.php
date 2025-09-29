<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'login_name',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id','id');
    }

    public function role_text()
    {
        $names = '';

        $i=1; $count= count($this->roles);
        foreach ($this->roles as $item ) {
            
            $names  = $names . $item['name'] ;
             
             if( $i!= $count )
               $names  = $names . ' , ' ;

            $i++;
        }

        return $names ;
    }

    public function menu()
    {
        $menus=Menu::where('super_id',0)->where('status',1)->orderBy('sort_order')->get();

        return $menus;
    }

    public function have_sub_role($right_id)
    {   
        $ids=$this->roles->pluck('id');  
        $b=role_right::whereIn('role_id',$ids)->where('right_id',$right_id)->first();
        //return $ids;
        if($b!='')
            return true;
        else
            return false;
    }

    public function have_right($right_id)
    {
          $roles=$this->roles;

          foreach ($roles as $rl) {
            $right=role_right::where('right_id',$right_id)->where('role_id',$rl['id'])->first();
            if($right!='')
                return true;
          }
        return false;
    }

}
