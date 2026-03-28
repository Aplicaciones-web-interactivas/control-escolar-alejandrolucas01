@extends('layouts.app')

@section('title', 'Mis Materias Inscritas - Control Escolar')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                Mi Carga Académica 📚
            </h1>
            <p class="mt-2 text-lg text-slate-500 text-center sm:text-left">
                Consulta las materias en las que estás inscrito y tus calificaciones.
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
        <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start animate-in fade-in slide-in-from-top-4">
            <svg class="h-5 w-5 text-emerald-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Card con Tabla de Materias Inscritas -->
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-lg font-bold text-slate-900 border-l-4 border-indigo-500 pl-3">Materias Inscritas</h2>
                <p class="text-sm text-slate-500 mt-1 pl-4">Listado detallado de tus materias para este ciclo.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="table-th">Materia</th>
                        <th class="table-th text-center">Grupo</th>
                        <th class="table-th">Horario</th>
                        <th class="table-th">Docente</th>
                        <th class="table-th text-center">Calificación</th>
                        <th class="table-th text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($inscripciones as $inscripcion)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $inscripcion->materia }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="badge-cyan">
                                    {{ $inscripcion->grupo }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-800">{{ $inscripcion->dia }}</span>
                                    <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($inscripcion->hora_inicio)->format('H:i') }}
                                        - {{ \Carbon\Carbon::parse($inscripcion->hora_fin)->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm font-medium text-slate-700">
                                    {{ $inscripcion->docente ?? 'Por asignar' }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($inscripcion->nota !== null)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $inscripcion->nota >= 6 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ number_format($inscripcion->nota, 1) }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400 italic">Pendiente</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('ver.actividades', $inscripcion->grupo_id) }}" 
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 shadow-md transition-all flex items-center gap-2 w-fit ml-auto">
                                    Ver Actividades
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-base font-medium">Aún no tienes materias inscritas.</span>
                                    <a href="{{ route('index.user') }}" class="mt-4 text-indigo-600 font-bold hover:underline">Ir a inscripciones</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($inscripciones->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                {{ $inscripciones->links() }}
            </div>
        @endif
    </div>
@endsection
