<?php

namespace App\Http\Controllers;

use App\Models\inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function indexUser()
    {
        // Traer materias, grupos y horarios disponibles
        // Grupos -> Horarios -> Materias
        $gruposDisponibles = DB::table('grupos')
            ->join('horarios', 'grupos.horario_id', '=', 'horarios.id')
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->select(
                'grupos.id as grupo_id',
                'grupos.nombre as grupo_nombre',
                'materias.nombre as materia_nombre',
                'horarios.dia',
                'horarios.hora_inicio',
                'horarios.hora_fin'
            )
            ->get();

        // Obtener inscripciones actuales del usuario para no mostrar el botón si ya está inscrito
        $misInscripciones = DB::table('inscripcions')
            ->where('usuario_id', Auth::id())
            ->pluck('grupo_id')
            ->toArray();

        return view('dashbordUser', compact('gruposDisponibles', 'misInscripciones'));
    }

    public function saveInscripcion(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        // Verificar si ya está inscrito
        $exists = inscripcion::where('usuario_id', Auth::id())
            ->where('grupo_id', $request->grupo_id)
            ->exists();

        if (! $exists) {
            inscripcion::create([
                'usuario_id' => Auth::id(),
                'grupo_id' => $request->grupo_id,
            ]);

            return back()->with('success', 'Inscripción realizada con éxito.');
        }

        return back()->with('error', 'Ya estás inscrito en este grupo.');
    }
}
