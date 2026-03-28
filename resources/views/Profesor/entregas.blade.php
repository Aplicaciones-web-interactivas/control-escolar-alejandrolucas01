@extends('layouts.app')

@section('title', 'Revisión de Entregas - Control Escolar')

@section('content')
    <!-- Header Section -->
    <div class="mb-10 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-center sm:text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                Revisión de Entregas 📥
            </h1>
            <p class="mt-2 text-lg text-slate-500 font-medium">
                Actividad: <span class="text-indigo-600 font-bold">{{ $actividad->titulo }}</span>
            </p>
        </div>
        <a href="{{ route('profesor.actividades', $grupo->id) }}"
            class="bg-white text-slate-700 px-5 py-2.5 rounded-2xl text-sm font-black border-2 border-slate-100 shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2 uppercase tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a Actividades
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card overflow-hidden shadow-xl shadow-slate-200/50">
        <div class="bg-slate-50 border-b border-slate-100 px-8 py-5 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Resumen del Grupo</h3>
                <p class="text-lg font-bold text-slate-700">{{ $grupo->materia_nombre }} - {{ $grupo->nombre }}</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm text-center">
                <div class="text-xl font-black text-indigo-600">{{ $entregas->total() }}</div>
                <div class="text-[9px] font-black uppercase text-slate-400 tracking-tighter">Entregas recibidas</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="table-th">Clave</th>
                        <th class="table-th">Estudiante</th>
                        <th class="table-th">Fecha de Entrega</th>
                        <th class="table-th text-center">Archivo</th>
                        <th class="table-th text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($entregas as $entrega)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                            <td class="py-5 px-8">
                                <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50/50 px-2 py-1 rounded">
                                    {{ $entrega->clave_institucional }}
                                </span>
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center font-black text-sm uppercase">
                                        {{ substr($entrega->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $entrega->name }}</span>
                                </div>
                            </td>
                            <td class="py-5 px-8">
                                <span class="text-xs text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($entrega->created_at)->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td class="py-5 px-8 text-center">
                                <a href="{{ Storage::url($entrega->ruta_archivo) }}" target="_blank"
                                    class="inline-flex items-center gap-2 bg-rose-50 text-rose-600 px-3 py-1.5 rounded-lg text-xs font-black border border-rose-100 hover:bg-rose-100 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    REVISAR PDF
                                </a>
                            </td>
                            <td class="py-5 px-8 text-right">
                                <form action="{{ route('profesor.saveTareaCalificacion') }}" method="POST" class="flex items-center justify-end gap-2">
                                    @csrf
                                    <input type="hidden" name="entrega_id" value="{{ $entrega->id }}">
                                    <div class="relative w-20">
                                        <input type="number" name="calificacion" step="0.1" min="0" max="10" 
                                            value="{{ $entrega->calificacion }}"
                                            placeholder="Nota"
                                            class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs font-bold text-indigo-600 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                                    </div>
                                    <button type="submit" class="bg-indigo-50 text-indigo-600 p-1.5 rounded-lg hover:bg-indigo-100 transition-all" title="Guardar nota">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <span class="text-xl font-black text-slate-400 uppercase tracking-widest">Bandeja Vacía</span>
                                    <p class="text-sm mt-1 font-medium text-slate-400">Ningún estudiante ha entregado esta actividad todavía.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($entregas->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                {{ $entregas->links() }}
            </div>
        @endif
    </div>
@endsection
