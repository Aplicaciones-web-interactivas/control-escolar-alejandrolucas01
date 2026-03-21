<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Grupo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen text-slate-800 font-sans antialiased">
    @include('layouts.navbar')


    <main class="max-w-[75%] mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-slate-900">Crear Nuevo Grupo</h1>
                    <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                        <div class="p-2 rounded-lg bg-indigo-100 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Horario Seleccionado
                            </p>
                            <p class="font-semibold text-slate-800">{{ $horario->materia->nombre }}</p>
                            <p class="text-sm text-slate-500">{{ $horario->dia }} |
                                {{ date('H:i', strtotime($horario->hora_inicio)) }} -
                                {{ date('H:i', strtotime($horario->hora_fin)) }}</p>
                            <p class="mt-1 text-sm font-medium text-indigo-600">Docente:
                                {{ $horario->usuario->name ?? 'No asignado' }}
                                ({{ $horario->usuario->clave_institucional ?? '' }})</p>
                        </div>

                    </div>
                </div>

                <form action="{{ route('save.grupo') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="horario_id" value="{{ $horario->id }}">

                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nombre del
                            Grupo Sugerido</span>
                        <h2 class="text-4xl font-black text-indigo-600 tracking-tighter">{{ $previewNombre }}</h2>
                        <p class="mt-2 text-sm text-slate-500 italic">El nombre se genera automáticamente con el ID
                            consecutivo.</p>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row items-center gap-6">
                        <a href="{{ route('index.horario') }}"
                            class="w-full sm:w-auto px-6 py-2 rounded-xl text-sm font-bold text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-100 transition-all text-center order-2 sm:order-1">
                            Cancelar y volver
                        </a>
                        <button type="submit"
                            class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 transform hover:-translate-y-1 flex justify-center items-center gap-2 text-lg order-1 sm:order-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Confirmar y Crear Grupo
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </main>
</body>

</html>
