<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Alumno - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-blue-50 min-h-screen text-slate-800 font-sans antialiased">
    @include('layouts.navbar')

    <main class="max-w-[75%] mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-blue-100 border border-slate-100 overflow-hidden">
            <div class="h-2 w-full bg-linear-to-r from-indigo-500 to-blue-600"></div>
            
            <div class="p-8 sm:p-10">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Asignar Calificaciones</h1>
                    <p class="mt-2 text-slate-500">Registra el progreso académico para los 3 parciales.</p>
                </div>

                <!-- Info del Alumno -->
                <div class="mb-10 p-5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-4">
                    <div class="h-14 w-14 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-indigo-100">
                        {{ substr($inscripcion->usuario->name ?? '?', 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xs font-bold text-indigo-500 uppercase tracking-widest">Alumno</div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $inscripcion->usuario->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $inscripcion->grupo->horario->materia->nombre }} | {{ $inscripcion->grupo->nombre }}</p>
                    </div>
                </div>

                <form action="{{ route('save.calificacion') }}" method="POST" class="space-y-8">
                    @csrf
                    <input type="hidden" name="grupo_id" value="{{ $inscripcion->grupo_id }}">
                    <input type="hidden" name="usuario_id" value="{{ $inscripcion->usuario_id }}">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Parcial 1 -->
                        <div class="space-y-2">
                            <label for="parcial1" class="block text-sm font-bold text-slate-700">1er Parcial</label>
                            <input type="number" step="0.1" name="parcial1" id="parcial1" 
                                value="{{ old('parcial1', $notaActual->parcial1 ?? '0.0') }}"
                                class="grade-input w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-lg font-bold text-indigo-600 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-sm"
                                placeholder="0.0" min="0" max="10">
                        </div>

                        <!-- Parcial 2 -->
                        <div class="space-y-2">
                            <label for="parcial2" class="block text-sm font-bold text-slate-700">2do Parcial</label>
                            <input type="number" step="0.1" name="parcial2" id="parcial2" 
                                value="{{ old('parcial2', $notaActual->parcial2 ?? '0.0') }}"
                                class="grade-input w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-lg font-bold text-indigo-600 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-sm"
                                placeholder="0.0" min="0" max="10">
                        </div>

                        <!-- Parcial 3 -->
                        <div class="space-y-2">
                            <label for="parcial3" class="block text-sm font-bold text-slate-700">3er Parcial</label>
                            <input type="number" step="0.1" name="parcial3" id="parcial3" 
                                value="{{ old('parcial3', $notaActual->parcial3 ?? '0.0') }}"
                                class="grade-input w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-lg font-bold text-indigo-600 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-sm"
                                placeholder="0.0" min="0" max="10">
                        </div>
                    </div>

                    <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-black text-indigo-400 uppercase tracking-widest">Promedio Final Estimado</span>
                            <p class="text-xs text-slate-500 mt-1 font-medium">Se calcula automáticamente promediando los 3 parciales.</p>
                        </div>
                        <div class="text-right">
                            <span id="promedio-final" class="text-4xl font-black text-indigo-600 leading-none">0.0</span>
                        </div>
                    </div>

                    <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('view.inscripciones', $inscripcion->grupo_id) }}" 
                            class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-sm font-bold text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-100 transition-all text-center order-2 sm:order-1">
                            Cancelar
                        </a>
                        <button type="submit" 
                            class="w-full sm:flex-grow flex items-center justify-center gap-2 bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 transform hover:-translate-y-0.5 active:scale-95 order-1 sm:order-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar Calificaciones
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.grade-input');
            const totalDisplay = document.getElementById('promedio-final');

            const calculate = () => {
                let sum = 0;
                let count = 0;
                inputs.forEach(input => {
                    const val = parseFloat(input.value);
                    if (!isNaN(val)) {
                        sum += val;
                        count++;
                    }
                });
                const avg = count > 0 ? (sum / 3).toFixed(1) : '0.0';
                totalDisplay.textContent = avg;
            };

            inputs.forEach(input => {
                input.addEventListener('input', calculate);
            });

            // Initial calculate if there's data
            calculate();
        });
    </script>
</body>
</html>
