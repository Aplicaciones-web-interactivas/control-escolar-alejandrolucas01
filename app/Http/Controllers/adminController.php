<?php

namespace App\Http\Controllers;

use App\Models\materia;
use App\Models\horario;
use App\Models\grupo;
use App\Models\User;
use App\Models\inscripcion;
use App\Models\calificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function indexAdmin()
    {
        return view('admin.dashboard');
    }

    public function indexMateria()
    {
        // Usamos try-catch por si la tabla 'materias' no existe aún
        try {
            $materias = materia::paginate(5);
        } catch (\Exception $e) {
            $materias = collect(); // Mandamos una lista vacía si falla la DB
        }

        return view('admin.materia', compact('materias'));
    }

    public function saveMateria(Request $request)
    {
        $materia = new materia;
        $materia->nombre = $request->nombre;
        $materia->clave = $request->clave;
        $materia->save();

        return redirect()->back();
    }

    public function deleteMateria($id)
    {
        $materia = materia::with('horarios.grupos.inscripciones')->find($id);
        
        if ($materia) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($materia) {
                foreach ($materia->horarios as $horario) {
                    foreach ($horario->grupos as $grupo) {
                        // Borrar todas las inscripciones del grupo
                        $grupo->inscripciones()->delete();
                        // Borrar el grupo
                        $grupo->delete();
                    }
                    // Borrar el horario
                    $horario->delete();
                }
                // Finalmente borrar la materia
                $materia->delete();
            });
        } else {
            return redirect()->back()->withErrors('Materia no encontrada');
        }

        return redirect()->back()->with('success', 'Materia y todos sus registros relacionados (horarios, grupos e inscripciones) han sido eliminados.');
    }


    public function editMateria($id)
    {
        $materia = materia::find($id);

        return view('admin.modificarMateria')->with('materia', $materia);
    }

    public function updateMateria(Request $request, $id)
    {
        $materiaEditar = materia::find($id);
        if ($materiaEditar != null) {
            $materiaEditar->nombre = $request->nombre;
            $materiaEditar->clave = $request->clave;
            $materiaEditar->save();
        } else {
            return redirect()->back()->withErrors('Materia no encontrada');
        }

        return redirect()->route('index.materia')->with('success', 'Materia modificada exitosamente');
    }

    public function createHorario($materia_id)
    {
        $materia = materia::find($materia_id);
        if (!$materia) {
            return redirect()->back()->withErrors('Materia no encontrada');
        }
        $usuarios = User::all();
        return view('admin.regHorario', compact('materia', 'usuarios'));
    }

    public function saveHorario(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'user_id' => 'required|exists:users,id',
            'dias' => 'required|array|min:1',
            'dias.*' => 'string',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $diasString = implode(', ', $request->dias);

        horario::create([
            'materia_id' => $request->materia_id,
            'user_id' => $request->user_id,
            'dia' => $diasString,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('index.materia')->with('success', 'Horario registrado correctamente.');
    }

    public function indexHorario()
    {
        $horarios = horario::with(['materia', 'usuario'])
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->orderBy('materias.nombre', 'asc')
            ->select('horarios.*')
            ->paginate(5);
        return view('admin.horario', compact('horarios'));
    }


    public function editHorario($id)
    {
        $horario = horario::find($id);
        $materias = materia::all();
        $usuarios = User::all();
        return view('admin.modificarHorario', compact('horario', 'materias', 'usuarios'));
    }

    public function updateHorario(Request $request, $id)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'user_id' => 'required|exists:users,id',
            'dias' => 'required|array|min:1',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $horario = horario::find($id);
        $horario->update([
            'materia_id' => $request->materia_id,
            'user_id' => $request->user_id,
            'dia' => implode(', ', $request->dias),
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('index.horario')->with('success', 'Horario actualizado correctamente');
    }

    public function deleteHorario($id)
    {
        horario::destroy($id);
        return redirect()->back()->with('success', 'Horario eliminado correctamente');
    }

    public function createGrupo($horario_id)
    {
        $horario = horario::with('materia')->find($horario_id);
        
        // Obtenemos el próximo ID aproximado para el preview
        $nextId = \Illuminate\Support\Facades\DB::select("SHOW TABLE STATUS LIKE 'grupos'")[0]->Auto_increment;
        $previewNombre = ($horario->materia->clave ?? 'MAT') . '-' . $nextId;

        return view('admin.regGrupo', compact('horario', 'previewNombre'));
    }

    public function saveGrupo(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
        ]);

        // Creamos el grupo con un nombre temporal
        $grupo = grupo::create([
            'nombre' => 'TEMPORAL',
            'horario_id' => $request->horario_id,
        ]);

        // Ahora que tenemos el ID real, actualizamos el nombre
        $horario = horario::with('materia')->find($request->horario_id);
        $nombreFinal = ($horario->materia->clave ?? 'MAT') . '-' . $grupo->id;
        
        $grupo->update(['nombre' => $nombreFinal]);

        return redirect()->route('index.horario')->with('success', "Grupo {$nombreFinal} creado correctamente");
    }

    public function indexGrupos()
    {
        $grupos = grupo::with(['horario.materia', 'horario.usuario'])->paginate(5);
        return view('admin.grupos', compact('grupos'));
    }


    public function editGrupo($id)
    {
        $grupo = grupo::find($id);
        $horarios = horario::with('materia')->get();
        return view('admin.modificarGrupo', compact('grupo', 'horarios'));
    }

    public function updateGrupo(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        $grupo = grupo::find($id);
        $grupo->update($request->all());

        return redirect()->route('index.grupos')->with('success', 'Grupo actualizado correctamente');
    }

    public function deleteGrupo($id)
    {
        grupo::destroy($id);
        return redirect()->back()->with('success', 'Grupo eliminado correctamente');
    }

    public function viewInscripciones($grupo_id)
    {
        $grupo = grupo::with(['horario.materia', 'horario.usuario'])->find($grupo_id);
        
        $inscripciones = inscripcion::with('usuario')
            ->where('grupo_id', $grupo_id)
            ->paginate(5);
            
        // Adjuntamos la calificación de este grupo a cada inscripción
        foreach ($inscripciones as $inscripcion) {
            $inscripcion->nota = calificacion::where('grupo_id', $grupo_id)
                                          ->where('usuario_id', $inscripcion->usuario_id)
                                          ->first();
        }

        return view('admin.inscripciones', compact('grupo', 'inscripciones'));
    }

    public function deleteInscripcion($id)
    {
        $inscripcion = inscripcion::find($id);
        
        if ($inscripcion) {
            $inscripcion->delete();
            return redirect()->back()->with('success', 'El alumno ha sido dado de baja del grupo correctamente.');
        }

        return redirect()->back()->withErrors('No se pudo encontrar la inscripción.');
    }

    public function createCalificacion($inscripcion_id)
    {
        $inscripcion = inscripcion::with(['usuario', 'grupo.horario.materia'])->find($inscripcion_id);
        
        if (!$inscripcion) {
            return redirect()->back()->withErrors('Inscripción no encontrada.');
        }

        // Cargar nota actual si existe para pre-rellenar los campos
        $notaActual = calificacion::where('grupo_id', $inscripcion->grupo_id)
                                 ->where('usuario_id', $inscripcion->usuario_id)
                                 ->first();

        return view('admin.calificar', compact('inscripcion', 'notaActual'));
    }

    public function saveCalificacion(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'usuario_id' => 'required|exists:users,id',
            'parcial1' => 'nullable|numeric|min:0|max:10',
            'parcial2' => 'nullable|numeric|min:0|max:10',
            'parcial3' => 'nullable|numeric|min:0|max:10',
        ]);

        $p1 = floatval($request->parcial1);
        $p2 = floatval($request->parcial2);
        $p3 = floatval($request->parcial3);

        // Calculamos el promedio para guardarlo en la columna única existente
        $promedio = ($p1 + $p2 + $p3) / 3;

        // Buscamos si ya existe una calificación o creamos una nueva
        calificacion::updateOrCreate(
            [
                'grupo_id' => $request->grupo_id,
                'usuario_id' => $request->usuario_id
            ],
            [
                'parcial1' => $p1,
                'parcial2' => $p2,
                'parcial3' => $p3,
                'calificacion' => $promedio
            ]
        );

        return redirect()->route('view.inscripciones', $request->grupo_id)
            ->with('success', 'Calificaciones guardadas y promedio actualizado exitosamente.');
    }
}
