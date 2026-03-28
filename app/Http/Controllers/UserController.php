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
            ->leftJoin('users', 'horarios.user_id', '=', 'users.id')
            ->select(
                'grupos.id as grupo_id',
                'grupos.nombre as grupo_nombre',
                'materias.nombre as materia_nombre',
                'horarios.dia',
                'horarios.hora_inicio',
                'horarios.hora_fin',
                'users.name as docente_nombre'
            )
            ->paginate(5);

        // Obtener inscripciones actuales del usuario para no mostrar el botón si ya está inscrito
        $misInscripciones = DB::table('inscripcions')
            ->where('usuario_id', Auth::id())
            ->pluck('grupo_id')
            ->toArray();

        return view('User.dashbordUser', compact('gruposDisponibles', 'misInscripciones'));
    }

    public function myInscripciones()
    {
        $userId = Auth::id();
        $inscripciones = DB::table('inscripcions')
            ->join('grupos', 'inscripcions.grupo_id', '=', 'grupos.id')
            ->join('horarios', 'grupos.horario_id', '=', 'horarios.id')
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->leftJoin('users as docentes', 'horarios.user_id', '=', 'docentes.id')
            ->leftJoin('calificacions', function ($join) use ($userId) {
                $join->on('grupos.id', '=', 'calificacions.grupo_id')
                    ->where('calificacions.usuario_id', '=', $userId);
            })
            ->where('inscripcions.usuario_id', $userId)
            ->select(
                'inscripcions.id as id',
                'grupos.id as grupo_id',
                'materias.nombre as materia',
                'grupos.nombre as grupo',
                'horarios.dia',
                'horarios.hora_inicio',
                'horarios.hora_fin',
                'docentes.name as docente',
                'calificacions.calificacion as nota'
            )
            ->paginate(5);

        return view('User.inscritas', compact('inscripciones'));
    }

    public function verActividades($grupo_id)
    {
        // Verificar inscripción
        $inscrito = DB::table('inscripcions')
            ->where('grupo_id', $grupo_id)
            ->where('usuario_id', Auth::id())
            ->exists();

        if (!$inscrito) {
            return back()->with('error', 'No estás inscrito en este grupo.');
        }

        $grupo = DB::table('grupos')->where('id', $grupo_id)->first();

        $actividades = DB::table('actividades')
            ->where('grupo_id', $grupo_id)
            ->paginate(5);

        foreach ($actividades as $actividad) {
            // Verificar si el alumno ya entregó y obtener calificacion
            $actividad->mi_entrega = DB::table('entregas')
                ->where('actividad_id', $actividad->id)
                ->where('usuario_id', Auth::id())
                ->first();
        }

        return view('User.misActividades', compact('actividades', 'grupo'));
    }

    public function verDetallesActividad($actividad_id)
    {
        $actividad = DB::table('actividades')->where('id', $actividad_id)->first();
        if (!$actividad) return back()->with('error', 'Actividad no encontrada.');

        // Verificar inscripción en el grupo de la actividad
        $inscrito = DB::table('inscripcions')
            ->where('grupo_id', $actividad->grupo_id)
            ->where('usuario_id', Auth::id())
            ->exists();

        if (!$inscrito) {
            return back()->with('error', 'No tienes acceso a esta actividad.');
        }

        $grupo = DB::table('grupos')
            ->join('horarios', 'grupos.horario_id', '=', 'horarios.id')
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->where('grupos.id', $actividad->grupo_id)
            ->select('grupos.*', 'materias.nombre as materia_nombre')
            ->first();
        
        $actividad->archivos = DB::table('archivos_actividad')
            ->where('actividad_id', $actividad->id)
            ->get();

        $actividad->mi_entrega = DB::table('entregas')
            ->where('actividad_id', $actividad->id)
            ->where('usuario_id', Auth::id())
            ->first();

        return view('User.detallesActividad', compact('actividad', 'grupo'));
    }

    public function saveEntrega(Request $request)
    {
        $request->validate([
            'actividad_id' => 'required|exists:actividades,id',
            'archivo' => 'required|mimes:pdf|max:10240',
        ]);

        // Guardar archivo
        $path = $request->file('archivo')->store('entregas/pdf', 'public');

        // Registrar entrega (Update or Create)
        DB::table('entregas')->updateOrInsert(
            [
                'actividad_id' => $request->actividad_id,
                'usuario_id' => Auth::id(),
            ],
            [
                'ruta_archivo' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Actividad entregada correctamente.');
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

    public function deleteInscripcion(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        $inscripcion = inscripcion::where('usuario_id', Auth::id())
            ->where('grupo_id', $request->grupo_id)
            ->first();

        if ($inscripcion) {
            $inscripcion->delete();

            return back()->with('success', 'Te has dado de baja del grupo correctamente.');
        }

        return back()->with('error', 'No se encontró tu inscripción en este grupo.');
    }
}
