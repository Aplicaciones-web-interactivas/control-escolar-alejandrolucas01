<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes Inscritos - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f8fafc] text-[#1e293b] antialiased font-sans min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('layouts.navbar')


    <main class="max-w-[85%] mx-auto px-4 py-8 sm:px-6 lg:px-8 w-full">

        <!-- Header Section -->
        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                Lista de Inscritos 👩‍🎓👨‍🎓
            </h1>

            <div class="mt-6 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-6 items-center sm:items-start">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="flex-grow text-center sm:text-left">
                    <div class="flex flex-wrap justify-center sm:justify-start items-center gap-2 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-500">{{ $grupo->horario->materia->nombre ?? 'Materia' }}</span>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span class="px-2 py-0.5 rounded-full bg-cyan-100 text-cyan-800 text-xs font-bold">{{ $grupo->nombre }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-slate-800">Detalles del Grupo</h2>
                    <p class="text-slate-500 text-sm mt-1">
                        {{ $grupo->horario->dia }} | {{ date('H:i', strtotime($grupo->horario->hora_inicio)) }} - {{ date('H:i', strtotime($grupo->horario->hora_fin)) }}
                    </p>
                    <p class="mt-1.5 text-xs font-semibold text-indigo-600 flex items-center gap-1.5 justify-center sm:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Impartida por: <span class="font-bold underline decoration-indigo-200 decoration-2 underline-offset-2">{{ $grupo->horario->usuario->name ?? 'Sin asignar' }}</span>
                    </p>
                </div>
                <div class="bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100 text-center">
                    <div class="text-2xl font-black text-indigo-600 leading-none">{{ count($grupo->inscripciones) }}</div>
                    <div class="text-[10px] font-bold uppercase text-slate-400 mt-1 tracking-widest">Estudiantes</div>
                </div>
            </div>
        </div>

        <!-- Mensajes de Estado -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium text-rose-800">{{ $errors->first() }}</p>
            </div>
        @endif

        <!-- Tabla de Estudiantes -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="py-4 px-8 text-xs font-bold text-slate-500 uppercase tracking-widest">Clave Institucional</th>
                            <th class="py-4 px-8 text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre Completo</th>
                            <th class="py-4 px-8 text-xs font-bold text-slate-500 uppercase tracking-widest text-center">Calificación</th>
                            <th class="py-4 px-8 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($grupo->inscripciones as $inscripcion)
                            <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                <td class="py-4 px-8">
                                    <span class="font-mono text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">
                                        {{ $inscripcion->usuario->clave_institucional ?? '---' }}
                                    </span>
                                </td>
                                <td class="py-4 px-8">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                                            {{ substr($inscripcion->usuario->name ?? '?', 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-slate-700">{{ $inscripcion->usuario->name ?? '---' }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-8 text-center">
                                    @if($inscripcion->nota)
                                        <span class="text-lg font-black text-indigo-600">
                                            {{ number_format($inscripcion->nota->calificacion, 1) }}
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full border border-slate-200">
                                            Sin calificar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-8 text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        <!-- Botón Calificar -->
                                        <a href="{{ route('create.calificacion', $inscripcion->id) }}"
                                            class="text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-indigo-100 flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Calificar
                                        </a>

                                        <!-- Botón Dar de baja -->
                                        <form action="{{ route('delete.inscripcion', $inscripcion->id) }}" method="POST" 
                                              onsubmit="return confirm('¿Estás seguro de que deseas dar de baja a este alumno?')" 
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg text-xs font-bold transition-all border border-rose-100">
                                                Dar de baja
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="p-4 rounded-full bg-slate-50 mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-lg font-bold text-slate-600">No hay inscritos</span>
                                        <p class="text-sm mt-1">Este grupo aún no tiene estudiantes registrados.</p>
                                    </div>
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
