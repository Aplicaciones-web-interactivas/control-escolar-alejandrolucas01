@extends('layouts.app')

@section('title', 'Inscripciones - Control Escolar')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                Panel de Estudiante🎓
            </h1>
            <p class="mt-2 text-lg text-slate-500 text-center sm:text-left">
                Gestiona tus inscripciones y consulta tu carga académica.
            </p>
        </div>

        <div class="flex bg-slate-100 p-1 rounded-xl self-center md:self-end">
            <a href="{{ route('index.user') }}" 
               class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ Request::routeIs('index.user') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Inscribir
            </a>
            <a href="{{ route('my.inscripciones') }}" 
               class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ Request::routeIs('my.inscripciones') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                Mis Materias
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start">
            <svg class="h-5 w-5 text-emerald-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-emerald-800">¡Inscripción Exitosa!</h3>
                <div class="mt-1 text-sm text-emerald-700">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-8 p-4 rounded-xl bg-rose-50 border border-rose-100 flex items-start">
            <svg class="h-5 w-5 text-rose-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-3 text-sm text-rose-700">
                {{ session('error') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-8 p-4 rounded-xl bg-rose-50 border border-rose-100 flex items-start">
            <svg class="h-5 w-5 text-rose-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-3 text-sm text-rose-700">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Card con Tabla de Grupos Disponibles -->
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-lg font-bold text-slate-900 border-l-4 border-indigo-500 pl-3">Grupos Ofertados</h2>
                <p class="text-sm text-slate-500 mt-1 pl-4">Elige la materia y el horario que mejor se adapte a ti.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="table-th">Materia</th>
                        <th class="table-th">Grupo</th>
                        <th class="table-th">Horario</th>
                        <th class="table-th">Docente</th>
                        <th class="table-th text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($gruposDisponibles as $grupo)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $grupo->materia_nombre }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge-cyan">
                                    {{ $grupo->grupo_nombre }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-800">{{ $grupo->dia }}</span>
                                    <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($grupo->hora_inicio)->format('H:i') }}
                                        - {{ \Carbon\Carbon::parse($grupo->hora_fin)->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-indigo-600">
                                    {{ $grupo->docente_nombre ?? 'No asignado' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if (in_array($grupo->grupo_id, $misInscripciones))
                                    <!-- Botón de Dar de Baja -->
                                    <form action="{{ route('delete.my.inscripcion') }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas darte de baja de este grupo?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="grupo_id" value="{{ $grupo->grupo_id }}">
                                        <button type="submit" class="btn-secondary text-rose-700 border-rose-200 hover:bg-rose-50 px-3 py-1.5 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Dar de baja
                                        </button>
                                    </form>
                                @else
                                    <!-- Botón de Inscribir -->
                                    <form action="{{ route('save.inscripcion') }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        <input type="hidden" name="grupo_id" value="{{ $grupo->grupo_id }}">
                                        <button type="submit" class="btn-primary text-sm px-4 py-2">
                                            Inscribir
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4 group-hover:translate-x-0.5 transition-transform"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-slate-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-base font-medium text-slate-600">No hay grupos disponibles por el momento</span>
                                    <p class="text-sm mt-1">Vuelve más tarde cuando coordinación asigne horarios.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($gruposDisponibles->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                {{ $gruposDisponibles->links() }}
            </div>
        @endif
    </div>
@endsection
