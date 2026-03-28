@extends('layouts.app')

@section('title', 'Mis Actividades - Control Escolar')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                Actividades de {{ $grupo->nombre }} 📝
            </h1>
            <p class="mt-2 text-lg text-slate-500 text-center sm:text-left font-medium">
                Consulta tus tareas pendientes y realiza tus entregas.
            </p>
        </div>
        <a href="{{ route('my.inscripciones') }}"
            class="bg-white text-slate-700 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200 shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a mis materias
        </a>
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

    <!-- Tabla de Actividades -->
    <div class="card shadow-xl shadow-slate-200/50">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="table-th">Actividad</th>
                        <th class="table-th text-center">Fecha Asignada</th>
                        <th class="table-th text-center">Calificación</th>
                        <th class="table-th text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($actividades as $actividad)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="py-5 px-8">
                                <div class="flex items-center gap-3">
                                    <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </span>
                                    <span class="font-bold text-slate-900 text-lg">{{ $actividad->titulo }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-8 text-center">
                                <span class="text-sm font-medium text-slate-500">
                                    {{ \Carbon\Carbon::parse($actividad->created_at)->format('d \d\e M, Y') }}
                                </span>
                            </td>
                            <td class="py-5 px-8 text-center">
                                @if($actividad->mi_entrega && $actividad->mi_entrega->calificacion !== null)
                                    <span class="inline-flex items-center px-4 py-1 rounded-full text-base font-black {{ $actividad->mi_entrega->calificacion >= 6 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800 shadow-sm shadow-rose-100' }}">
                                        {{ number_format($actividad->mi_entrega->calificacion, 1) }}
                                    </span>
                                @elseif($actividad->mi_entrega)
                                    <span class="text-xs font-black uppercase text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
                                        Pendiente revisar
                                    </span>
                                @else
                                    <span class="text-xs font-black uppercase text-slate-300 bg-slate-50 px-3 py-1 rounded-full italic">
                                        Sin entregar
                                    </span>
                                @endif
                            </td>
                            <td class="py-5 px-8 text-right">
                                <a href="{{ route('ver.detallesActividad', $actividad->id) }}"
                                   class="btn-primary text-xs px-5 py-2.5 font-black uppercase tracking-widest inline-flex items-center gap-2">
                                    Revisar Tarea
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="text-xl font-black text-slate-400 uppercase tracking-widest mb-1">Cronograma vacío</p>
                                    <p class="text-sm font-medium">No se han publicado actividades para este grupo aún.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($actividades->hasPages())
            <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/30">
                {{ $actividades->links() }}
            </div>
        @endif
    </div>
@endsection
