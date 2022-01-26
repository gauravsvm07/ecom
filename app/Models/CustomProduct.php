<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomProduct extends Model
{
    use HasFactory;
    protected $table = 'custom_products';
    public function custom_categories()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
