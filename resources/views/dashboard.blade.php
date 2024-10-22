@extends(backpack_view('layouts.top_left'))

@section('content')
    <div class="container">
        <h1>Lista de Productos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Código del Producto</th>
                    <th>Nombre del Producto</th>
                    <th>Código de Subcategoría</th>
                    <th>Nombre de Subcategoría</th>
                    <th>Código de Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->codigo_producto }}</td>
                        <td>{{ $product->nombre_producto }}</td>
                        <td>{{ $product->codigo_subcategoria }}</td>
                        <td>{{ $product->nombre_subcategoria }}</td>
                        <td>{{ $product->codigo_categoria }}</td>
                        <td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
