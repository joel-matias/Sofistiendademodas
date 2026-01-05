@extends('layouts.app')

@section('title', 'Contacto | Tienda')

@section('content')
<section class="section">
    <h1 class="section__title">Contacto</h1>
    <p class="section__subtitle">Déjanos un mensaje y te respondemos lo antes posible.</p>

    <form class="form">
        <label class="label">
            Nombre
            <input type="text" class="input" placeholder="Tu nombre">
        </label>

        <label class="label">
            Correo
            <input type="email" class="input" placeholder="tunombre@email.com">
        </label>

        <label class="label">
            Mensaje
            <textarea class="input" rows="5" placeholder="Escribe tu mensaje"></textarea>
        </label>

        <button type="submit" class="btn btn--primary">Enviar</button>
    </form>
</section>
@endsection
