<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f8fafc] text-[#1e293b] antialiased font-sans min-h-screen flex flex-col">

    <!-- Navbar (Misma estructura) -->
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
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-slate-600 hidden sm:inline-block">Panel de
                        Administración</span>

                    <!-- Botón Cerrar Sesión (Opcional, ya que tienes la ruta logout lista) -->
                    <form action="{{ route('logout') ?? '#' }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium text-rose-500 hover:text-rose-700 transition-colors bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg flex items-center gap-2">
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

    <main class="flex-grow max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8 w-full">

        <!-- Welcome Section -->
        <div class="mb-12">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl text-center sm:text-left">
                Hola, Administrador 👋
            </h1>
            <p class="mt-2 text-lg text-slate-500 text-center sm:text-left">
                Bienvenido al panel principal. ¿Qué deseas gestionar el día de hoy?
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Card Materias -->
            <a href="{{ route('index.materia') }}"
                class="group relative bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl border border-slate-100 border-b-4 border-b-indigo-500 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center sm:items-start text-center sm:text-left overlow-hidden">
                <div
                    class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-indigo-900" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 border border-indigo-100 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mb-2">Materias</h2>
                <p class="text-slate-500 text-sm mb-6 flex-grow relative z-10">Administra el catálogo de asignaturas,
                    claves y crea materias nuevas para el plan de estudios.</p>

                <div
                    class="mt-auto w-full inline-flex items-center justify-center sm:justify-start gap-2 text-indigo-600 font-semibold text-sm group-hover:text-indigo-700 transition-colors">
                    Gestionar Materias
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </a>

            <!-- Card Horarios -->
            <a href="{{ route('index.horario') }}"
                class="group relative bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl border border-slate-100 border-b-4 border-b-indigo-500 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center sm:items-start text-center sm:text-left overlow-hidden">
                <div
                    class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-indigo-900" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 border border-indigo-100 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mb-2">Horarios</h2>
                <p class="text-slate-500 text-sm mb-6 flex-grow relative z-10">Gestiona los horarios de las materias,
                    edita asignaciones y crea grupos escolares.</p>

                <div
                    class="mt-auto w-full inline-flex items-center justify-center sm:justify-start gap-2 text-indigo-600 font-semibold text-sm group-hover:text-indigo-700 transition-colors">
                    Gestionar Horarios
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </a>

            <!-- Card Grupos -->
            <a href="{{ route('index.grupos') }}"
                class="group relative bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl border border-slate-100 border-b-4 border-b-cyan-500 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center sm:items-start text-center sm:text-left overlow-hidden">
                <div
                    class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity transform group-hover:scale-110 duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-cyan-900" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>

                <div
                    class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-6 border border-cyan-100 shadow-inner group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-slate-900 mb-2">Grupos</h2>
                <p class="text-slate-500 text-sm mb-6 flex-grow relative z-10">Administra los grupos escolares, edita sus datos y consulta las listas de estudiantes inscritos.</p>

                <div
                    class="mt-auto w-full inline-flex items-center justify-center sm:justify-start gap-2 text-cyan-600 font-semibold text-sm group-hover:text-cyan-700 transition-colors">
                    Gestionar Grupos
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </a>

        </div>
    </main>

</body>

</html>
