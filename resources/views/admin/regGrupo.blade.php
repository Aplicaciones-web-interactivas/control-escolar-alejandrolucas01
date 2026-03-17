<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Grupo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen text-slate-800 font-sans antialiased">
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md">CE</div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Control Escolar</span>
                </div>
                <div>
                    <a href="{{ route('index.horario') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">Volver a Horarios</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-slate-900">Crear Nuevo Grupo</h1>
                    <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-start gap-4">
                        <div class="p-2 rounded-lg bg-indigo-100 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Horario Seleccionado</p>
                            <p class="font-semibold text-slate-800">{{ $horario->materia->nombre }}</p>
                            <p class="text-sm text-slate-500">{{ $horario->dia }} | {{ date('H:i', strtotime($horario->hora_inicio)) }} - {{ date('H:i', strtotime($horario->hora_fin)) }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('save.grupo') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="horario_id" value="{{ $horario->id }}">

                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-slate-700 mb-2">Nombre del Grupo</label>
                        <input type="text" name="nombre" id="nombre" required placeholder="Ej. Grupo 101-A" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all" autofocus>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-emerald-600 text-white py-3.5 rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
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
