<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar vista de registro
    public function indexRegister()
    {
        if (Auth::check()) {
            return redirect()->route('index.admin');
        }

        return view('auth.Register');
    }

    // Guardar el registro
    public function saveRegister(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'clave_institucional' => 'required|string|max:255|unique:users,clave_institucional',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->nombre,
            'clave_institucional' => $request->clave_institucional,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente. Inicia sesión ahora.');
    }

    // Mostrar vista de login
    public function indexLogin()
    {
        if (Auth::check()) {
            return redirect()->route('index.admin');
        }

        return view('auth.Auth');
    }

    // Procesar el login
    public function saveLogin(Request $request)
    {
        $request->validate([
            'clave_institucional' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = [
            'clave_institucional' => $request->clave_institucional,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('index.admin');
        }

        return back()->with('error', 'Las credenciales no coinciden con nuestros registros.')->onlyInput('clave_institucional');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
