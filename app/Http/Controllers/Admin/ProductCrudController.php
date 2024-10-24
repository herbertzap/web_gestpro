<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
// use DB;
use Illuminate\Support\Facades\DB;


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

    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

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

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::field('nombre_producto')->label('Nombre del Producto')->type('text');
        CRUD::field('codigo_subcategoria')->label('Código de Subcategoría')->type('text');
        CRUD::field('nombre_subcategoria')->label('Nombre de Subcategoría')->type('text');
        CRUD::field('codigo_categoria')->label('Código de Categoría')->type('text');
        CRUD::field('nombre_categoria')->label('Nombre de Categoría')->type('text');
        CRUD::field('descripcion')->label('Descripción')->type('textarea');
        CRUD::field('precio')->label('Precio')->type('number')->attributes(['step' => '0.01']);
        CRUD::field('stock')->label('Stock')->type('number');
        CRUD::field('imagen')->label('Imagen')->type('upload')->upload(true)->disk('public');

        CRUD::field('codigo_categoria')->label('Categoría')->type('select')->entity('category')->model('App\Models\Category')->attribute('nombre_categoria')->options(function ($query) {
            return $query->whereNull('parent_id')->get(); 
        });
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'codigo_categoria' => 'required|exists:categories,id',
        ]);

        $lastCode = DB::table('MAEPR')->latest('KOPRRA')->first()->KOPRRA ?? 0;
        $sku = $request->input('codigo_categoria') . substr($request->input('descripcion'), 0, 3) . str_pad($lastCode + 1, 6, '0', STR_PAD_LEFT);

        Product::create([
            'nombre_producto' => $validatedData['nombre_producto'],
            'descripcion' => $validatedData['descripcion'],
            'precio' => $validatedData['precio'],
            'stock' => $validatedData['stock'],
            'codigo_categoria' => $validatedData['codigo_categoria'],
            'sku' => $sku,
        ]);

        return redirect()->route('products.create')->with('success', 'Producto creado con éxito.');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
