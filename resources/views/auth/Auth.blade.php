<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Control Escolar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-indigo-50 via-white to-cyan-50 min-h-screen text-slate-800 font-sans antialiased">
    
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative">
            
            <!-- Barra superior decorativa -->
            <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-500"></div>

            <div class="p-8 sm:p-10">
                <div class="mb-8 text-center flex flex-col items-center">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg mb-4 text-xl">
                        CE
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Bienvenido de nuevo</h1>
                    <p class="mt-2 text-sm text-slate-500">Inicia sesión en tu cuenta de Control Escolar</p>
                </div>

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 flex items-start">
                        <svg class="h-5 w-5 text-rose-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        <div class="ml-3 text-sm text-rose-700">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

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

                <form action="{{ route('save.login') ?? '#' }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="clave_institucional" class="block text-sm font-semibold text-slate-700 mb-2">Clave institucional</label>
                        <input type="text" name="clave_institucional" id="clave_institucional" placeholder="Ej. A12345678" value="{{ old('clave_institucional') }}" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all shadow-sm">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all shadow-sm">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full group relative flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                            Iniciar sesión
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="text-center mt-6">
                        <p class="text-sm text-slate-500">¿No tienes una cuenta aún? 
                            <a href="{{ route('index.register') ?? '#' }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">Regístrate aquí</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
