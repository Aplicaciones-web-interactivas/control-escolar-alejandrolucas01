@extends('layouts.app')

@section('title', 'Detalles de la Actividad - Control Escolar')

@section('content')
    <!-- Header Section -->
    <div class="mb-10 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-center sm:text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                Detalles de Tarea 📝
            </h1>
            <p class="mt-2 text-lg text-slate-500 font-medium">
                Materia: <span class="text-indigo-600 font-bold uppercase">{{ $grupo->materia_nombre }}</span> | 
                Grupo: <span class="text-indigo-600 font-bold">{{ $grupo->nombre }}</span>
            </p>
        </div>
        <a href="{{ route('ver.actividades', $grupo->id) }}"
            class="bg-white text-slate-700 px-5 py-2.5 rounded-2xl text-sm font-black border-2 border-slate-100 shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2 uppercase tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a la lista
        </a>
    </div>

    @if (session('success'))
        <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start animate-in fade-in slide-in-from-top-4">
            <svg class="h-5 w-5 text-emerald-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <div class="ml-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Información de la Actividad (Izquierda) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-8">
                <div class="flex items-center gap-3 mb-6">
                    <span class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl shadow-sm border border-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <h2 class="text-3xl font-black text-slate-900 leading-tight">{{ $actividad->titulo }}</h2>
                </div>

                <div class="prose prose-slate max-w-none text-slate-600 mb-8 bg-slate-50 p-6 rounded-3xl border border-slate-100/50">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Instrucciones del Profesor:</h3>
                    <p class="whitespace-pre-line text-lg leading-relaxed">
                        {{ $actividad->descripcion ?: 'El profesor no ha proporcionado una descripción detallada.' }}
                    </p>
                </div>

                @if(count($actividad->archivos) > 0)
                    <div class="space-y-4">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Recursos y Material de Apoyo:</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($actividad->archivos as $archivo)
                                <a href="{{ Storage::url($archivo->ruta_archivo) }}" target="_blank"
                                    class="group flex items-center justify-between bg-white border border-slate-200 p-4 rounded-2xl hover:border-indigo-300 hover:shadow-md transition-all duration-300">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="p-2 bg-rose-50 text-rose-500 rounded-xl group-hover:bg-rose-100 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="font-bold text-slate-700 truncate text-sm">{{ $archivo->nombre_archivo ?: 'Documento de apoyo' }}</span>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Estado y Entrega (Derecha) -->
        <div class="lg:col-span-1">
            <div class="card p-8 bg-slate-50/50 sticky top-8">
                @if($actividad->mi_entrega)
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-1">¡Tarea Enviada!</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">
                            Entregado el {{ \Carbon\Carbon::parse($actividad->mi_entrega->created_at)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm mb-6">
                        @if($actividad->mi_entrega->calificacion !== null)
                            <div class="text-center">
                                <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Puntuación Final:</span>
                                <div class="text-4xl font-black {{ $actividad->mi_entrega->calificacion >= 6 ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ number_format($actividad->mi_entrega->calificacion, 1) }}
                                </div>
                                <div class="text-[10px] font-bold text-slate-400 mt-2">sobre 10.0</div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 justify-center text-amber-600 font-bold italic">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pendiente de calificar
                            </div>
                        @endif
                    </div>

                    <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100 mb-6 group">
                        <span class="text-[10px] font-black uppercase text-indigo-400 block mb-2 tracking-widest text-center">Tu Archivo:</span>
                        <a href="{{ Storage::url($actividad->mi_entrega->ruta_archivo) }}" target="_blank"
                            class="flex items-center gap-3 bg-white p-3 rounded-xl border border-indigo-100 group-hover:shadow-md transition-all">
                            <div class="p-2 bg-rose-50 text-rose-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-black text-indigo-600 underline">VER MI ENTREGA</span>
                        </a>
                    </div>
                @else
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-1">Sin Entregar</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Aún no has enviado el archivo</p>
                    </div>
                @endif

                <!-- Upload Form -->
                <div class="border-t border-slate-200 pt-8">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">
                        {{ $actividad->mi_entrega ? 'Actualizar mi entrega:' : 'Subir mi archivo:' }}
                    </h4>
                    
                    <form action="{{ route('save.entrega') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
                        
                        <div class="relative group">
                            <input type="file" name="archivo" accept=".pdf" required id="file-upload" class="hidden peer">
                            <label for="file-upload" class="flex flex-col items-center justify-center w-full p-6 border-2 border-dashed border-indigo-200 rounded-3xl bg-white text-indigo-600 text-center cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span class="text-xs font-black uppercase tracking-widest">Seleccionar PDF</span>
                                <span class="text-[9px] text-slate-400 mt-1 uppercase font-bold">Máximo 10MB</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary w-full py-4 flex items-center justify-center gap-3 font-black uppercase tracking-widest shadow-xl shadow-indigo-200">
                            {{ $actividad->mi_entrega ? 'Cambiar archivo' : 'Enviar tarea ahora' }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
