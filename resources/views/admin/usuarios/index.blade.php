@extends('admin.layouts.app')
@section('title', 'Permisos de usuarios')
@section('page_title', 'Permisos de usuarios')
@section('page_subtitle', 'Gestión de roles')

@section('content')

    @if(session('error'))
        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-gris">{{ $usuarios->count() }} usuarios registrados</p>
        <div class="flex items-center gap-2 text-xs text-gris">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-tinta inline-block"></span> Admin
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-gray-300 inline-block"></span> Usuario
            </span>
        </div>
    </div>

    <div class="card overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-borde bg-gray-50">
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Usuario</th>
                    <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium hidden sm:table-cell">Email</th>
                    <th class="text-center px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Rol actual</th>
                    <th class="text-right px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Cambiar rol</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-borde">
                @foreach($usuarios as $usuario)
                    <tr class="hover:bg-gray-50 transition {{ $usuario->id === auth()->id() ? 'bg-crema/50' : '' }}">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-tinta flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-tinta">{{ $usuario->name }}</p>
                                    @if($usuario->id === auth()->id())
                                        <p class="text-[10px] text-gris">Tú</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gris hidden sm:table-cell">{{ $usuario->email }}</td>
                        <td class="px-5 py-3 text-center">
                            @if($usuario->isAdmin())
                                <span class="badge-dark">Admin</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gris">Usuario</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            @if($usuario->id === auth()->id())
                                <span class="text-xs text-gris italic">No editable</span>
                            @else
                                <form method="POST" action="{{ route('admin.usuarios.role', $usuario) }}">
                                    @csrf @method('PATCH')
                                    @if($usuario->isAdmin())
                                        <input type="hidden" name="role" value="user">
                                        <button type="submit"
                                            onclick="return confirm('¿Quitar permisos de administrador a {{ $usuario->name }}?')"
                                            class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                            Quitar admin
                                        </button>
                                    @else
                                        <input type="hidden" name="role" value="admin">
                                        <button type="submit"
                                            onclick="return confirm('¿Ascender a {{ $usuario->name }} como administrador?')"
                                            class="text-xs text-tinta hover:underline transition font-medium">
                                            Hacer admin
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
