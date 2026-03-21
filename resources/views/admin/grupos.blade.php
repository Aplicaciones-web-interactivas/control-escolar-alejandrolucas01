<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Grupos - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f8fafc] text-[#1e293b] antialiased font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navbar')


    <main class="flex-grow max-w-[85%] mx-auto px-4 py-8 sm:px-6 lg:px-8 w-full">

        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                    Gestión de Grupos 👥
                </h1>
                <p class="mt-2 text-lg text-slate-500 text-center sm:text-left">
                    Administra los grupos escolares, sus horarios y consulta inscripciones.
                </p>
            </div>
            <a href="{{ route('index.user') }}"
                class="bg-rose-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-rose-200 hover:bg-rose-700 transition-all transform hover:-translate-y-0.5 flex items-center gap-2 border-2 border-rose-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Inscribir Materias
            </a>
        </div>

        @if (session('success'))
            <div
                class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start animate-in fade-in slide-in-from-top-4">
                <svg class="h-5 w-5 text-emerald-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
                <div class="ml-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            </div>
        @endif

        <!-- Card con Tabla de Grupos -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div
                class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 border-l-4 border-indigo-500 pl-3">Grupos Existentes
                    </h2>
                    <p class="text-sm text-slate-500 mt-1 pl-4">Lista completa de grupos asignados a materias y
                        horarios.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Materia
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Grupo
                            </th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Horario
                            </th>
                            <th
                                class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">
                                Docente
                            </th>
                            <th
                                class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($grupos as $grupo)
                            <tr class="hover:bg-slate-50 transition-colors duration-150 group">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900">
                                        {{ $grupo->horario->materia->nombre ?? 'N/A' }}</div>
                                    <div class="text-xs text-slate-400">{{ $grupo->horario->materia->clave ?? '' }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 border border-cyan-200">
                                        {{ $grupo->nombre }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-sm font-medium text-slate-800">{{ $grupo->horario->dia }}</span>
                                        <span
                                            class="text-xs text-slate-500 font-mono">{{ date('H:i', strtotime($grupo->horario->hora_inicio)) }}
                                            - {{ date('H:i', strtotime($grupo->horario->hora_fin)) }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex flex-col items-center">
                                        <span
                                            class="text-sm font-semibold text-indigo-600">{{ $grupo->horario->usuario->name ?? 'No asignado' }}</span>
                                        <span
                                            class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $grupo->horario->usuario->clave_institucional ?? '' }}</span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <!-- Ver Inscripciones -->
                                        <a href="{{ route('view.inscripciones', $grupo->id) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-all"
                                            title="Ver inscritos">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="hidden sm:inline">Inscritos</span>
                                        </a>

                                        <!-- Editar -->
                                        <a href="{{ route('modificar.grupo', $grupo->id) }}"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors border border-transparent hover:border-indigo-100"
                                            title="Editar grupo">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>

                                        <!-- Eliminar -->
                                        <form action="{{ route('delete.grupo', $grupo->id) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este grupo?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors border border-transparent hover:border-rose-100"
                                                title="Eliminar grupo">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-12 w-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    No hay grupos registrados todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>

</html>
