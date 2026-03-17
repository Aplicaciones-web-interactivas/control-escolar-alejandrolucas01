<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Materias</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen text-slate-800 font-sans antialiased">

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
                    <a href="{{ route('index.admin') ?? '#' }}"
                        class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">Volver al
                        Dashboard</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Gestión de Materias</h1>
            <p class="mt-2 text-lg text-slate-500 max-w-2xl">Administra el catálogo de materias para el sistema de
                control escolar. Registra, modifica o elimina asignaturas fácilmente.</p>
        </div>

        <!-- Errors / Messages -->
        @if ($errors->any())
            <div class="mb-8 p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-rose-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-rose-800">Hubo un error con su solicitud</h3>
                    <div class="mt-2 text-sm text-rose-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Left Column: Form -->
            <div
                class="lg:col-span-4 bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-slate-200/60">
                <div class="p-6 sm:p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Registrar nueva materia
                    </h2>

                    <form action="{{ route('save.materia') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="nombre" class="block text-sm font-semibold text-slate-700 mb-2">Nombre de la
                                materia</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                                placeholder="Ej. Matemáticas Avanzadas"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all shadow-sm">
                        </div>

                        <div>
                            <label for="clave" class="block text-sm font-semibold text-slate-700 mb-2">Clave</label>
                            <input type="text" name="clave" id="clave" value="{{ old('clave') }}" required
                                placeholder="Ej. MAT-101"
                                class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all shadow-sm">
                        </div>

                        <button type="submit"
                            class="w-full group relative flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                            Guardar materia
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Table -->
            <div
                class="lg:col-span-8 bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div
                    class="p-6 sm:px-8 sm:py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-500" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Catálogo de Materias
                    </h2>
                    <span
                        class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                        {{ count($materias ?? []) }} registros
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col"
                                    class="py-4 pl-6 pr-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Materia</th>
                                <th scope="col"
                                    class="px-3 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Clave</th>
                                <th scope="col"
                                    class="py-4 pl-3 pr-6 text-right text-xs font-bold text-slate-500 uppercase tracking-wider relative">
                                    <span class="sr-only">Acciones</span> Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($materias ?? [] as $materia)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="whitespace-nowrap py-4 pl-6 pr-3 font-medium text-slate-900">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs uppercase">
                                                {{ substr($materia->nombre, 0, 1) }}
                                            </div>
                                            {{ $materia->nombre }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">
                                        <span
                                            class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">
                                            {{ $materia->clave }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                        <div
                                            class="flex justify-end items-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <!-- Agregar Horario -->
                                            <a href="{{ route('create.horario', $materia->id) }}"
                                                class="text-emerald-600 hover:text-emerald-900 bg-emerald-50 hover:bg-emerald-100 p-2 rounded-lg transition-colors"
                                                title="Añadir horario a materia">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                    <line x1="12" y1="14" x2="16" y2="18"></line>
                                                    <line x1="16" y1="14" x2="12" y2="18"></line>
                                                </svg>
                                            </a>
                                            <!-- Edit -->
                                            <a href="{{ route('modificar.materia', $materia->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors"
                                                title="Editar materia">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <!-- Delete -->
                                            <form action="{{ route('delete.materia', $materia->id) }}" method="post"
                                                class="inline-block m-0"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar esta materia?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-rose-600 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition-colors"
                                                    title="Eliminar materia">
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
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-slate-900">No hay materias registradas</h3>
                                        <p class="mt-1 text-sm text-slate-500">Comienza agregando una nueva materia en
                                            el formulario de la izquierda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>

</html>
