@extends('layouts.app')

@section('title', 'Catálogo | Tienda')

@section('content')
<section class="section">
    <div class="section__header">
        <div>
            <h1 class="section__title">Catálogo</h1>
            <p class="section__subtitle">Explora nuestros productos (vista responsive optimizada).</p>
        </div>

        <div class="filters">
            <select class="input">
                <option>Ordenar por</option>
                <option>Más nuevos</option>
                <option>Precio: menor a mayor</option>
                <option>Precio: mayor a menor</option>
            </select>
        </div>
    </div>

    <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
    @foreach ($productos as $producto)
        <x-product-card :producto="$producto" />
    @endforeach
    </div>

</section>
@endsection
