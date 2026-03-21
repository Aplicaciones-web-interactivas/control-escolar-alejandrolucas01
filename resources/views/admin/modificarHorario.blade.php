<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Horario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen text-slate-800 font-sans antialiased">
    @include('layouts.navbar')


    <main class="max-w-3xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8">
                <h1 class="text-2xl font-bold text-slate-900 mb-2">Modificar Horario</h1>
                <p class="text-slate-500 mb-8 text-sm">Actualiza los detalles del horario para la materia seleccionada.</p>

                <form action="{{ route('update.horario', $horario->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Asignar Docente/Usuario</label>
                        <select name="user_id" id="user_id" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 outline-none">
                            <option value="">Seleccione un usuario...</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $horario->user_id == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->clave_institucional }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Materia</label>
                        <select name="materia_id" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                            @foreach($materias as $materia)
                                <option value="{{ $materia->id }}" {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                                    {{ $materia->nombre }} ({{ $materia->clave }})
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Días de clase</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @php $diasActuales = explode(', ', $horario->dia); @endphp
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors shadow-sm">
                                    <input type="checkbox" name="dias[]" value="{{ $dia }}" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4" {{ in_array($dia, $diasActuales) ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-slate-700">{{ $dia }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hora de Inicio</label>
                            <input type="time" name="hora_inicio" value="{{ $horario->hora_inicio }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hora de Fin</label>
                            <input type="time" name="hora_fin" value="{{ $horario->hora_fin }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 transform hover:-translate-y-0.5">
                            Actualizar Horario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
