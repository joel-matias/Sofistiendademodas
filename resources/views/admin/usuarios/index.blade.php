@extends('admin.layouts.app')
@section('title', 'Permisos de usuarios')
@section('page_title', 'Permisos de usuarios')
@section('page_subtitle', 'Gestión de roles')

@section('content')

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-gris">{{ $usuarios->count() }} usuarios registrados</p>
        <div class="flex items-center gap-3 text-xs text-gris">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-tinta inline-block"></span> Admin
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-gray-300 inline-block"></span> Usuario
            </span>
        </div>
    </div>

    {{-- Cards en móvil --}}
    <div class="space-y-2.5 sm:hidden">
        @foreach($usuarios as $usuario)
            <div class="card p-4 {{ $usuario->id === auth()->id() ? 'border-tinta/20 bg-crema/30' : '' }}">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-tinta flex items-center justify-center text-white text-sm font-semibold flex-shrink-0">
                        {{ strtoupper(substr($usuario->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="font-medium text-sm truncate">{{ $usuario->name }}</p>
                            @if($usuario->id === auth()->id())
                                <span class="text-[10px] text-gris bg-gray-100 px-1.5 py-0.5 rounded-full">Tú</span>
                            @endif
                        </div>
                        <p class="text-xs text-gris truncate">{{ $usuario->email }}</p>
                    </div>
                    @if($usuario->isAdmin())
                        <span class="badge-dark text-[11px]">Admin</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gris">Usuario</span>
                    @endif
                </div>

                @if($usuario->id !== auth()->id())
                    <div class="space-y-2">
                        @if($usuario->isAdmin())
                            <form method="POST" action="{{ route('admin.usuarios.role', $usuario) }}"
                                  data-confirm="¿Quitar permisos de administrador a {{ $usuario->name }}?"
                                  data-confirm-danger>
                                @csrf @method('PATCH')
                                <input type="hidden" name="role" value="user">
                                <button type="submit"
                                        class="w-full text-center px-3 py-2 rounded-xl text-xs font-medium text-red-500
                                               hover:text-red-700 hover:bg-red-50 border border-red-100 transition">
                                    Quitar acceso admin
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.usuarios.role', $usuario) }}"
                                  data-confirm="¿Ascender a {{ $usuario->name }} como administrador?">
                                @csrf @method('PATCH')
                                <input type="hidden" name="role" value="admin">
                                <button type="submit"
                                        class="w-full text-center px-3 py-2 rounded-xl text-xs font-medium text-tinta
                                               hover:bg-gray-100 border border-borde transition">
                                    Hacer administrador
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}"
                              data-confirm="¿Eliminar a {{ $usuario->name }}? Esta acción no se puede deshacer."
                              data-confirm-danger>
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full text-center px-3 py-2 rounded-xl text-xs font-medium text-red-500
                                           hover:text-red-700 hover:bg-red-50 border border-red-100 transition">
                                Eliminar usuario
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Tabla en desktop --}}
    <div class="card overflow-hidden hidden sm:block">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-borde bg-gray-50">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Usuario</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Email</th>
                        <th class="text-center px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Rol actual</th>
                        <th class="text-right px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Cambiar rol</th>
                        <th class="text-right px-5 py-3 text-xs uppercase tracking-widest text-gris font-medium">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-borde">
                    @foreach($usuarios as $usuario)
                        <tr class="hover:bg-gray-50 transition {{ $usuario->id === auth()->id() ? 'bg-crema/30' : '' }}">
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
                            <td class="px-5 py-3 text-gris">{{ $usuario->email }}</td>
                            <td class="px-5 py-3 text-center">
                                @if($usuario->isAdmin())
                                    <span class="badge-dark">Admin</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gris">Usuario</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                @if($usuario->id === auth()->id())
                                    <span class="text-xs text-gris italic">—</span>
                                @elseif($usuario->isAdmin())
                                    <form method="POST" action="{{ route('admin.usuarios.role', $usuario) }}"
                                          data-confirm="¿Quitar permisos de administrador a {{ $usuario->name }}?"
                                          data-confirm-danger>
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="role" value="user">
                                        <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                            Quitar admin
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.usuarios.role', $usuario) }}"
                                          data-confirm="¿Ascender a {{ $usuario->name }} como administrador?">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="role" value="admin">
                                        <button type="submit"
                                                class="text-xs text-tinta hover:underline transition font-medium">
                                            Hacer admin
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                @if($usuario->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}"
                                          data-confirm="¿Eliminar a {{ $usuario->name }}? Esta acción no se puede deshacer."
                                          data-confirm-danger>
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                            Eliminar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gris italic">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
