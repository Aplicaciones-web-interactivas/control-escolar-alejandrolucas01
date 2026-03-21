<nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('index.admin') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md group-hover:bg-indigo-700 transition-colors">
                        CE
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Control Escolar</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('index.admin') }}" 
                        class="px-3 py-2 rounded-lg text-sm font-medium {{ Request::routeIs('index.admin') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }} transition-all">
                        Dashboard
                    </a>
                    <a href="{{ route('index.materia') }}" 
                        class="px-3 py-2 rounded-lg text-sm font-medium {{ Request::routeIs('index.materia') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }} transition-all">
                        Materias
                    </a>
                    <a href="{{ route('index.horario') }}" 
                        class="px-3 py-2 rounded-lg text-sm font-medium {{ Request::routeIs('index.horario') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }} transition-all">
                        Horarios
                    </a>
                    <a href="{{ route('index.grupos') }}" 
                        class="px-3 py-2 rounded-lg text-sm font-medium {{ Request::routeIs('index.grupos') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }} transition-all">
                        Grupos
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-sm font-medium text-rose-500 hover:text-rose-700 transition-colors bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg flex items-center gap-2 border border-rose-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
