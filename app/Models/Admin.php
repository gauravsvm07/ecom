<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
     protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
   

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     public function role()
  {
    return $this->hasOne(Role::class, 'id', 'role_id');  
  }


  public function RoleData()
    {
        return $this->hasOne('App\Models\Role', 'id','role_id');        
    }
    public function can($module = '', $check = '')
    {
        $role_id = $this->role_id;
        if($this->id==1 && $role_id==1) return true;
          
        $permisssion = Permission::where('role_id', $role_id)
        ->whereHas('module', function($query) use($module){
                $query->where('key', $module);
        })->first();
        //dd($permisssion);
        $allow = false;
        if($permisssion) {
            switch ($check) {
                case 'add':
                    $allow = $permisssion->can_add;
                    break;
                case 'view':
                    $allow = $permisssion->can_view;
                    break;
                case 'delete':
                    $allow = $permisssion->can_delete;
                    break;
                case 'update':
                    $allow = $permisssion->can_update;
                    break;
                case 'any':
                        $allow =  $permisssion->can_view || $permisssion->can_add || $permisssion->can_edit || $permisssion->can_delete || $permisssion->can_update;
                    break;
            }
        }
        return $allow;
    }

}
