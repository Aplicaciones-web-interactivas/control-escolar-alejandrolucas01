<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante - Control Escolar</title>
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
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-slate-600 hidden sm:inline-block">Panel de Estudiante</span>

                    <form action="{{ route('logout') ?? '#' }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium text-rose-500 hover:text-rose-700 transition-colors bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="hidden sm:inline">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8 w-full">

        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                Hola, {{ Auth::user()->name ?? 'Estudiante' }} 🎓
            </h1>
            <p class="mt-2 text-lg text-slate-500 text-center sm:text-left">
                Revisa los grupos disponibles y realiza tu inscripción.
            </p>
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
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div
                class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 border-l-4 border-indigo-500 pl-3">Grupos Ofertados</h2>
                    <p class="text-sm text-slate-500 mt-1 pl-4">Elige la materia y el horario que mejor se adapte a ti.
                    </p>
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
                                class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">
                                Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($gruposDisponibles as $grupo)
                            <tr class="hover:bg-slate-50 transition-colors duration-150">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900">{{ $grupo->materia_nombre }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 border border-cyan-200">
                                        {{ $grupo->grupo_nombre }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-slate-800">{{ $grupo->dia }}</span>
                                        <span
                                            class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($grupo->hora_inicio)->format('H:i') }}
                                            - {{ \Carbon\Carbon::parse($grupo->hora_fin)->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if (in_array($grupo->grupo_id, $misInscripciones))
                                        <!-- Ya inscrito -->
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Inscrito
                                        </span>
                                    @else
                                        <!-- Botón de Inscribir -->
                                        <form action="{{ route('save.inscripcion') }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            <input type="hidden" name="grupo_id" value="{{ $grupo->grupo_id }}">
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl shadow-sm hover:shadow transition-all group active:scale-95">
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
                                <td colspan="4" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-slate-300"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-base font-medium text-slate-600">No hay grupos disponibles
                                            por el momento</span>
                                        <p class="text-sm mt-1">Vuelve más tarde cuando coordinación asigne horarios.
                                        </p>
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
