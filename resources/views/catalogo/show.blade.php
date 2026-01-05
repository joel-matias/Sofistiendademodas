@extends('layouts.app')

@section('title', $producto['nombre'] . ' | Tienda')

@section('content')
<section class="product-detail">
    <div class="product-detail__image">
        <img src="{{ $producto['imagen'] }}" alt="{{ $producto['nombre'] }}">
    </div>

    <div class="product-detail__info">
        <p class="badge">{{ $producto['categoria'] }}</p>
        <h1>{{ $producto['nombre'] }}</h1>
        <p class="price">${{ number_format($producto['precio'], 0) }} MXN</p>
        <p class="desc">{{ $producto['descripcion'] }}</p>

        <div class="product-detail__actions">
            <a href="{{ route('catalogo') }}" class="btn btn--ghost">Volver</a>
            <a href="{{ route('contacto') }}" class="btn btn--primary">Preguntar por WhatsApp</a>
        </div>
    </div>
</section>
@endsection
