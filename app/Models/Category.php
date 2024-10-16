<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use CrudTrait;
    protected $fillable = ['name', 'parent_id'];

    // Relación para las subcategorías
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relación para la categoría principal
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
