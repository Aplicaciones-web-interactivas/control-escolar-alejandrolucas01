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
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                        CE
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Control Escolar</span>
                </div>
                <div>
                    <a href="{{ route('index.grupos') }}"
                        class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">Volver a
                        Grupos</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8 w-full">

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
                </div>
                <div class="bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100 text-center">
                    <div class="text-2xl font-black text-indigo-600 leading-none">{{ count($grupo->inscripciones) }}</div>
                    <div class="text-[10px] font-bold uppercase text-slate-400 mt-1 tracking-widest">Estudiantes</div>
                </div>
            </div>
        </div>

        <!-- Tabla de Estudiantes -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="py-4 px-8 text-xs font-bold text-slate-500 uppercase tracking-widest">Clave Institucional</th>
                            <th class="py-4 px-8 text-xs font-bold text-slate-500 uppercase tracking-widest">Nombre Completo</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-20 text-center">
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
