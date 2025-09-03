<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
  protected $fillable = [
    'name',
    'slug',
    'status',
  ];

  // public function subCategory(){
  //   return $this->HasMany(SubCategory::class, 'id', 'category_id');
  // }
}
