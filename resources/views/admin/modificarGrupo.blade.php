<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Grupo - Control Escolar</title>
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
                        class="text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">Cancelar y Volver</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-12 sm:px-6 lg:px-8 w-full">

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8 sm:p-12">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-black text-slate-900 leading-tight">Editar Grupo</h1>
                        <p class="text-slate-500 text-sm">Modifica el nombre o el horario asignado al grupo.</p>
                    </div>
                </div>

                <form action="{{ route('update.grupo', $grupo->id) }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label for="nombre" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nombre del Grupo</label>
                            <input type="text" name="nombre" id="nombre" value="{{ $grupo->nombre }}" required 
                                class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 text-sm font-medium focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm shadow-slate-100/50"
                                placeholder="Ej. Grupo 101-A">
                        </div>

                        <div>
                            <label for="horario_id" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Horario Asignado</label>
                            <div class="relative group">
                                <select name="horario_id" id="horario_id" required 
                                    class="appearance-none w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 text-sm font-medium focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all shadow-sm shadow-slate-100/50">
                                    @foreach($horarios as $horario)
                                        <option value="{{ $horario->id }}" {{ $grupo->horario_id == $horario->id ? 'selected' : '' }}>
                                            {{ $horario->materia->nombre ?? 'N/A' }} — {{ $horario->dia }} ({{ date('H:i', strtotime($horario->hora_inicio)) }} - {{ date('H:i', strtotime($horario->hora_fin)) }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400 group-hover:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="flex-grow bg-indigo-600 text-white py-4 px-8 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 transform hover:-translate-y-1 active:translate-y-0 flex justify-center items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>
