@extends('layouts.app')

@section('title', 'Inicio | Tienda')

@section('content')
<section class="hero">
    <div class="hero__text">
        <h1>Moda hecha para ti</h1>
        <p>Explora nuestro catálogo de ropa. Diseño limpio, rápido y optimizado para móvil.</p>

        <div class="hero__actions">
            <a href="{{ route('catalogo') }}" class="btn btn--primary">Ver catálogo</a>
            <a href="{{ route('contacto') }}" class="btn btn--ghost">Contacto</a>
        </div>
    </div>

    <div class="hero__image">
        <img src="assets/img/hero.jpg" alt="Moda">
    </div>
</section>

<section class="section">
    <h2 class="section__title">Destacados</h2>
    <p class="section__subtitle">Un vistazo rápido a lo más vendido.</p>

    <div class="grid">
        {{-- Cards ejemplo (podrás reemplazar por DB) --}}
        @foreach (range(1,4) as $i)
            <div class="highlight-card">
                <h3>Producto {{ $i }}</h3>
                <p>Descripción corta del producto.</p>
            </div>
        @endforeach
    </div>
</section>
@endsection
