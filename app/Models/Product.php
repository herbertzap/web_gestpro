<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'vista_productos';

    public $timestamps = false;

    protected $fillable = [
        'codigo_categoria',       // FE
        'nombre_categoria',       // FERRETERIA
        'codigo_subcategoria',    // ADP
        'nombre_subcategoria',    // ADHESIVOS PISOS
        'codigo_producto',        
        'nombre_producto'         
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'codigo_categoria');
    }

    // ahora se obtienen de la vista
    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }
}
