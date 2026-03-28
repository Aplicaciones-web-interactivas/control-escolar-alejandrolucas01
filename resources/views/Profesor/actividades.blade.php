@extends('layouts.app')

@section('title', 'Gestión de Tareas - Control Escolar')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                Tareas de {{ $grupo->nombre }} 📝
            </h1>
            <p class="mt-2 text-lg text-slate-500 text-center sm:text-left font-medium">
                Crea, edita y consulta las actividades asignadas al grupo.
            </p>
        </div>
        <a href="{{ route('index.profesor') }}"
            class="bg-white text-slate-700 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200 shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Formulario (Izquierda/Arriba) -->
        <div class="card lg:col-span-1 border-indigo-100 shadow-xl shadow-indigo-100/20">
            <div class="card-header bg-slate-50 border-b border-slate-100">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Asignar Tarea
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('save.actividad') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" name="grupo_id" value="{{ $grupo->id }}">
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Título de la actividad</label>
                        <input type="text" name="titulo" placeholder="Ej. Tarea 1: Resumen de la Unidad 1" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Instrucciones</label>
                        <textarea name="descripcion" rows="4" placeholder="Describe los requisitos..."
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Archivos PDF (puedes subir varios)</label>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-indigo-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-3 text-indigo-500 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <p class="text-[11px] font-bold text-slate-500 uppercase">Subir Documentos</p>
                            </div>
                            <input type="file" name="archivos[]" multiple accept=".pdf" class="hidden" />
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full py-3.5 flex items-center justify-center gap-2 font-black shadow-lg shadow-indigo-200 uppercase tracking-widest text-xs">
                        Publicar Actividad
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Lista de Actividades (Derecha) -->
        <div class="lg:col-span-2 space-y-4">
            <h3 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-4">Cronograma de tareas</h3>
            @forelse($actividades as $actividad)
                <div class="card p-6 border-l-8 border-l-indigo-500 shadow-lg shadow-slate-100 hover:shadow-xl transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h4 class="text-xl font-black text-indigo-900 mb-1 font-sans">{{ $actividad->titulo }}</h4>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter bg-slate-100 px-2 py-0.5 rounded-md">Publicado: {{ \Carbon\Carbon::parse($actividad->created_at)->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <p class="text-slate-600 text-sm mb-6 leading-relaxed italic bg-indigo-50/30 p-4 rounded-xl border border-indigo-100/50">
                        {{ $actividad->descripcion ?: 'Sin instrucciones adicionales.' }}
                    </p>

                    @if(count($actividad->archivos) > 0)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($actividad->archivos as $archivo)
                                <a href="{{ Storage::url($archivo->ruta_archivo) }}" target="_blank"
                                    class="bg-white border border-rose-100 text-rose-600 px-3 py-1.5 rounded-lg text-xs font-black shadow-sm hover:bg-rose-50 transition-all flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    PDF: {{ $archivo->nombre_archivo }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="border-t border-slate-100 pt-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full {{ $actividad->total_entregas > 0 ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                            <span class="text-xs font-bold text-slate-500">{{ $actividad->total_entregas }} {{ $actividad->total_entregas == 1 ? 'entrega' : 'entregas' }} recibidas</span>
                        </div>
                        <a href="{{ route('profesor.entregas', $actividad->id) }}" 
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-black transition-all flex items-center gap-2 shadow-md shadow-indigo-100 uppercase tracking-widest">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver y Revisar Entregas
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl p-16 text-center text-slate-400">
                    <p class="text-sm font-black uppercase tracking-widest">No hay actividades publicadas aún.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($actividades->hasPages())
                <div class="mt-8 bg-white p-4 rounded-xl shadow-sm border border-slate-100">
                    {{ $actividades->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
