<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class GeneralProduct extends Model
{
    use HasFactory;
    protected $table = 'general_products';

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
