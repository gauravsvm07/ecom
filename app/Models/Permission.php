<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';

     public function role()
  {
    return $this->hasOne(Role::class, 'id', 'role_id');  
  }

   public function module()
  {
    return $this->hasOne(Module::class, 'id', 'module_id');  
  }
}
