<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfesorController extends Controller
{
    public function indexProfesor()
    {
        $misGrupos = DB::table('grupos')
            ->join('horarios', 'grupos.horario_id', '=', 'horarios.id')
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->where('horarios.user_id', Auth::id())
            ->select(
                'grupos.id',
                'grupos.nombre as grupo',
                'materias.nombre as materia',
                'horarios.dia',
                'horarios.hora_inicio',
                'horarios.hora_fin'
            )
            ->paginate(5);

        return view('Profesor.dashbordProf', compact('misGrupos'));
    }

    public function verAlumnos($grupo_id)
    {
        $grupo = \App\Models\grupo::with(['horario.materia', 'horario.usuario'])->find($grupo_id);
        
        if (!$grupo || $grupo->horario->user_id != Auth::id()) {
            return back()->with('error', 'No tienes acceso a este grupo.');
        }

        $inscripciones = \App\Models\inscripcion::with('usuario')
            ->where('grupo_id', $grupo_id)
            ->paginate(5);

        foreach ($inscripciones as $inscripcion) {
            $inscripcion->nota = \App\Models\calificacion::where('grupo_id', $grupo_id)
                                          ->where('usuario_id', $inscripcion->usuario_id)
                                          ->first();
        }

        return view('admin.inscripciones', compact('grupo', 'inscripciones'));
    }

    public function verActividades($grupo_id)
    {
        $grupo = $this->checkGrupoPropiedad($grupo_id);
        if (!$grupo) return back()->with('error', 'No tienes acceso a este grupo.');

        $actividades = DB::table('actividades')
            ->where('grupo_id', $grupo_id)
            ->paginate(5);

        foreach($actividades as $actividad) {
            $actividad->archivos = DB::table('archivos_actividad')
                ->where('actividad_id', $actividad->id)
                ->get();
                
            // Contar cuántas entregas hay
            $actividad->total_entregas = DB::table('entregas')
                ->where('actividad_id', $actividad->id)
                ->count();
        }

        return view('Profesor.actividades', compact('actividades', 'grupo'));
    }

    public function verEntregas($actividad_id)
    {
        $actividad = DB::table('actividades')->where('id', $actividad_id)->first();
        if (!$actividad) return back()->with('error', 'Actividad no encontrada.');

        $grupo = $this->checkGrupoPropiedad($actividad->grupo_id);
        if (!$grupo) return back()->with('error', 'No tienes acceso a esta actividad.');

        $entregas = DB::table('entregas')
            ->join('users', 'entregas.usuario_id', '=', 'users.id')
            ->where('actividad_id', $actividad_id)
            ->select('entregas.*', 'users.name', 'users.clave_institucional')
            ->paginate(5);

        return view('Profesor.entregas', compact('entregas', 'actividad', 'grupo'));
    }

    public function saveCalificacion(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required',
            'usuario_id' => 'required',
            'parcial1' => 'nullable|numeric|min:0|max:10',
            'parcial2' => 'nullable|numeric|min:0|max:10',
            'parcial3' => 'nullable|numeric|min:0|max:10',
        ]);

        $p1 = floatval($request->parcial1);
        $p2 = floatval($request->parcial2);
        $p3 = floatval($request->parcial3);

        DB::table('calificacions')->updateOrInsert(
            ['grupo_id' => $request->grupo_id, 'usuario_id' => $request->usuario_id],
            [
                'parcial1' => $p1,
                'parcial2' => $p2,
                'parcial3' => $p3,
                'calificacion' => ($p1 + $p2 + $p3) / 3,
                'updated_at' => now()
            ]
        );

        return back()->with('success', 'Calificación asignada correctamente.');
    }

    public function saveTareaCalificacion(Request $request)
    {
        $request->validate([
            'entrega_id' => 'required|exists:entregas,id',
            'calificacion' => 'nullable|numeric|min:0|max:10'
        ]);

        DB::table('entregas')
            ->where('id', $request->entrega_id)
            ->update([
                'calificacion' => $request->calificacion,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Calificación de la tarea guardada.');
    }

    public function deleteInscripcion($inscripcion_id)
    {
        DB::table('inscripcions')->where('id', $inscripcion_id)->delete();
        return back()->with('success', 'Alumno dado de baja del grupo.');
    }

    public function saveActividad(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'grupo_id' => 'required|exists:grupos,id',
            'archivos.*' => 'nullable|mimes:pdf|max:10240',
        ]);

        $actividadId = DB::table('actividades')->insertGetId([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'grupo_id' => $request->grupo_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $path = $file->store('actividades/pdf', 'public');
                DB::table('archivos_actividad')->insert([
                    'actividad_id' => $actividadId,
                    'ruta_archivo' => $path,
                    'nombre_archivo' => $file->getClientOriginalName(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Actividad publicada.');
    }

    private function checkGrupoPropiedad($grupo_id) {
        return DB::table('grupos')
            ->join('horarios', 'grupos.horario_id', '=', 'horarios.id')
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->where('grupos.id', $grupo_id)
            ->where('horarios.user_id', Auth::id())
            ->select(
                'grupos.*',
                'materias.nombre as materia_nombre',
                'horarios.dia',
                'horarios.hora_inicio',
                'horarios.hora_fin'
            )
            ->first();
    }
}
