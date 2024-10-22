<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */

     public function index()
     {
         $products = \App\Models\Product::all();
         return view('dashboard', compact('products'));
     }
     
     
     
     
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        CRUD::column('codigo_producto')->label('Código del Producto');
        CRUD::column('nombre_producto')->label('Nombre del Producto');
        CRUD::column('codigo_subcategoria')->label('Código de Subcategoría');
        CRUD::column('nombre_subcategoria')->label('Nombre de Subcategoría');
        CRUD::column('codigo_categoria')->label('Código de Categoría');
        CRUD::column('nombre_categoria')->label('Nombre de Categoría');
        CRUD::column('precio')->label('Precio');
        CRUD::column('stock')->label('Stock');
        CRUD::column('imagen')->label('Imagen')->type('image');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        // Asegúrate de usar los nombres correctos según tu base de datos
        CRUD::field('codigo_producto')->label('Código del Producto')->type('text');
        CRUD::field('nombre_producto')->label('Nombre del Producto')->type('text');
        CRUD::field('codigo_subcategoria')->label('Código de Subcategoría')->type('text');
        CRUD::field('nombre_subcategoria')->label('Nombre de Subcategoría')->type('text');
        CRUD::field('codigo_categoria')->label('Código de Categoría')->type('text');
        CRUD::field('nombre_categoria')->label('Nombre de Categoría')->type('text');
        CRUD::field('descripcion')->label('Descripción')->type('textarea');
        CRUD::field('precio')->label('Precio')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('stock')->label('Stock')->type('number');
        CRUD::field('imagen')->label('Imagen')->type('upload')->upload(true)->disk('public');

        // Campo de selección para la categoría
        CRUD::field('codigo_categoria')->label('Categoría')->type('select')->entity('category')->model('App\Models\Category')->attribute('nombre_categoria')->options(function ($query) {
            return $query->whereNull('parent_id')->get(); // Solo mostrar categorías principales
        });
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
