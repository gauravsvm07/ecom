<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;
    protected $table = 'cms';

  public function page_category()
  {
    return $this->hasOne(PageCategory::class, 'id', 'category_id');  
  }

  public function page_section()
  {
  	return $this->hasOne(PageSection::class,'id','section_id');
  }

}


