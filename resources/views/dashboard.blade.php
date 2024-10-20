@extends(backpack_view('layouts.top_left'))

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <div>
            {!! $chart->container() !!}
        </div>
    </div>
@endsection

@section('after_scripts')
    {!! $chart->script() !!}
@endsection
