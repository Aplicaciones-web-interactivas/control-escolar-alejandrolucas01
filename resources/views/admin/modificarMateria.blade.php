<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Materia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen text-slate-800 font-sans antialiased flex flex-col justify-center py-12">

    <!-- Navbar -->
    @include('layouts.navbar')


    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-16">

        <!-- Header Section -->
        <div class="mb-8 text-center">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 mb-4 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Modificar Materia</h1>
            <p class="mt-2 text-slate-500">Actualiza los datos de la asignatura seleccionada.</p>
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
                    <h3 class="text-sm font-medium text-rose-800">No se pudo actualizar la materia</h3>
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

        <!-- Formulario Modo Edición -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8 sm:p-10">

                <form action="{{ route('update.materia', $materia->id) }}" method="POST" class="space-y-6">
                    @csrf
                    {{-- Opcional, pero recomendable en Laravel --}}
                    {{-- @method('PUT') --}}

                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-slate-700 mb-2">Nombre de la
                            materia</label>
                        <input type="text" name="nombre" id="nombre"
                            value="{{ old('nombre', $materia->nombre) }}" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all shadow-sm">
                    </div>

                    <div>
                        <label for="clave" class="block text-sm font-semibold text-slate-700 mb-2">Clave</label>
                        <input type="text" name="clave" id="clave" value="{{ old('clave', $materia->clave) }}"
                            required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all shadow-sm">
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-4">
                        <a href="{{ route('index.materia') }}"
                            class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="group relative flex justify-center items-center gap-2 py-3 px-6 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                            Guardar Cambios
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </main>

</body>

</html>
