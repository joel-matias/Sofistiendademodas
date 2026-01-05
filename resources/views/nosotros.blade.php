@extends('layouts.app')

@section('title', 'Nosotros | Tienda')

@section('content')
<section class="section">
    <h1 class="section__title">Nosotros</h1>
    <p class="section__subtitle">
        Somos una tienda enfocada en ofrecer ropa con estilo y comodidad. Esta sección es editable.
    </p>

    <div class="grid">
        <div class="highlight-card">
            <h3>Misión</h3>
            <p>Ofrecer productos con excelente relación calidad/precio.</p>
        </div>
        <div class="highlight-card">
            <h3>Visión</h3>
            <p>Convertirnos en una marca reconocida en moda urbana.</p>
        </div>
        <div class="highlight-card">
            <h3>Valores</h3>
            <p>Calidad, honestidad, atención al cliente.</p>
        </div>
    </div>
</section>
@endsection
