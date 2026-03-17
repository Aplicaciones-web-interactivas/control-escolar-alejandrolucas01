<?php

namespace App\Http\Controllers;

use App\Models\materia;
use App\Models\horario;
use App\Models\grupo;
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
            $materias = materia::all();
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
        $materiaeliminar = materia::find($id);
        if ($materiaeliminar != null) {
            $materiaeliminar->delete();
        } else {
            return redirect()->back()->withErrors('Materia no encontrada');
        }

        return redirect()->back();
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
        return view('admin.regHorario', compact('materia'));
    }

    public function saveHorario(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'dias' => 'required|array|min:1',
            'dias.*' => 'string',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $diasString = implode(', ', $request->dias);

        horario::create([
            'materia_id' => $request->materia_id,
            'user_id' => Auth::id(), // Guardamos el id del usuario que lo registra
            'dia' => $diasString,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('index.materia')->with('success', 'Horario registrado correctamente.');
    }

    public function indexHorario()
    {
        $horarios = horario::with('materia')
            ->join('materias', 'horarios.materia_id', '=', 'materias.id')
            ->orderBy('materias.nombre', 'asc')
            ->select('horarios.*')
            ->get();
        return view('admin.horario', compact('horarios'));
    }

    public function editHorario($id)
    {
        $horario = horario::find($id);
        $materias = materia::all();
        return view('admin.modificarHorario', compact('horario', 'materias'));
    }

    public function updateHorario(Request $request, $id)
    {
        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'dias' => 'required|array|min:1',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $horario = horario::find($id);
        $horario->update([
            'materia_id' => $request->materia_id,
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
        return view('admin.regGrupo', compact('horario'));
    }

    public function saveGrupo(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        grupo::create([
            'nombre' => $request->nombre,
            'horario_id' => $request->horario_id,
        ]);

        return redirect()->route('index.horario')->with('success', 'Grupo creado correctamente');
    }

    public function indexGrupos()
    {
        $grupos = grupo::with(['horario.materia'])->get();
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
        $grupo = grupo::with(['horario.materia', 'inscripciones.usuario'])->find($grupo_id);
        return view('admin.inscripciones', compact('grupo'));
    }
}
