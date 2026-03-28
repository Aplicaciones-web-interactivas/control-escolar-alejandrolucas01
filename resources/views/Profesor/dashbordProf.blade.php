@extends('layouts.app')

@section('title', 'Panel del Profesor - Control Escolar')

@section('content')
    <!-- Welcome Teacher Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
            ¡Hola, Prof. {{ Auth::user()->name }}! 👋
        </h1>
        <p class="mt-2 text-lg text-slate-500 text-center sm:text-left">
            Aquí puedes gestionar tus grupos y actividades académicas.
        </p>
    </div>

    @if (session('error'))
        <div class="mb-8 p-4 rounded-xl bg-rose-50 border border-rose-100 flex items-start animate-in fade-in slide-in-from-top-4">
            <svg class="h-5 w-5 text-rose-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                    clip-rule="evenodd" />
            </svg>
            <div class="ml-3 text-sm font-medium text-rose-800">{{ session('error') }}</div>
        </div>
    @endif

    <!-- Card de Grupos Asignados -->
    <div class="card">
        <div class="card-header">
            <div>
                <h2 class="text-lg font-bold text-slate-900 border-l-4 border-indigo-500 pl-3">Mis Materias Asignadas</h2>
                <p class="text-sm text-slate-500 mt-1 pl-4">Grupos bajo tu coordinación en este ciclo escolar.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="table-th text-center">Grupo</th>
                        <th class="table-th">Materia</th>
                        <th class="table-th">Horario</th>
                        <th class="table-th text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($misGrupos as $grupo)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="py-4 px-6 text-center">
                                <span class="badge-cyan">
                                    {{ $grupo->grupo }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $grupo->materia }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-800">{{ $grupo->dia }}</span>
                                    <span class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($grupo->hora_inicio)->format('H:i') }}
                                        - {{ \Carbon\Carbon::parse($grupo->hora_fin)->format('H:i') }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right flex justify-end gap-2">
                                <a href="{{ route('profesor.alumnos', $grupo->id) }}" 
                                    class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-emerald-700 shadow transition-all flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    Alumnos
                                </a>
                                <a href="{{ route('profesor.actividades', $grupo->id) }}" 
                                    class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 shadow transition-all flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Actividades
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-base font-medium">Aún no tienes grupos asignados para este ciclo escolar.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        @if($misGrupos->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                {{ $misGrupos->links() }}
            </div>
        @endif
    </div>
@endsection
