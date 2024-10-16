<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;
    // Agrega los campos que deseas permitir para la asignación masiva
    protected $fillable = ['name', 'description', 'price', 'stock', 'image'];
}
