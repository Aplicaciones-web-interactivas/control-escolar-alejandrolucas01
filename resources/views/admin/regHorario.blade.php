<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Horario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen text-slate-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-bold shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Horarios</span>
                </div>
                <div>
                    <a href="{{ route('index.materia') ?? '#' }}"
                        class="text-sm font-medium text-slate-500 hover:text-emerald-600 transition-colors">Volver a materias</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative">
            
            <div class="h-2 w-full bg-gradient-to-r from-emerald-400 to-teal-500"></div>

            <div class="p-8 sm:p-10">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Nuevo Horario</h1>
                    <p class="mt-2 text-sm text-slate-500">Asigna un horario para la materia de <strong class="text-slate-800">{{ $materia->nombre }}</strong></p>
                </div>

                <!-- Errores -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 flex items-start">
                        <svg class="h-5 w-5 text-rose-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
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

                <form action="{{ route('save.horario') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <input type="hidden" name="materia_id" value="{{ $materia->id }}">

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Días de la Semana</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                            <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-slate-50 p-4 shadow-sm hover:border-emerald-400 focus-within:ring-2 focus-within:ring-emerald-500/20 transition-all">
                                <span class="flex items-center gap-3">
                                    <input type="checkbox" name="dias[]" value="{{ $dia }}" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-600"
                                        {{ (is_array(old('dias')) && in_array($dia, old('dias'))) ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-slate-700">{{ $dia }}</span>
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="hora_inicio" class="block text-sm font-semibold text-slate-700 mb-2">Hora de Inicio</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 outline-none transition-all shadow-sm">
                        </div>

                        <div>
                            <label for="hora_fin" class="block text-sm font-semibold text-slate-700 mb-2">Hora de Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}" required
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 outline-none transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full group relative flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-md shadow-emerald-200 font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform hover:-translate-y-0.5 active:scale-95">
                            Crear Horario Universitario
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </main>
</body>
</html>
