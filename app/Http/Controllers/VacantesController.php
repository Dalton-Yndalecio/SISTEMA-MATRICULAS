<?php

namespace App\Http\Controllers;

use App\Models\Vacantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabjar con procediminetos alamcenados
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class VacantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $vacantes = Vacantes::with(['grado', 'seccion'])->get();

            return DataTables::of($vacantes)
                ->addColumn('grado', function ($vacantes) {
                    return $vacantes->grado->nombre;
                })
                ->addColumn('seccion', function ($vacantes) {
                    return $vacantes->seccion->nombre;
                })
                ->addColumn('action', function ($vacantes) {
                    $editar = '<button class="btn btn-outline-success btn-sm modal-vacante" data-modal="Agregar" data-id="' . $vacantes->id . '"><i class="fas fa-plus"></i></button>
                    <button class="btn btn-outline-danger btn-sm modal-vacante" data-modal="Restar" data-id="' . $vacantes->id . '"><i class="fas fa-minus"></i></button>';
                    return $editar;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('vacantes.index');
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_grado = $request->input('id_grado');
        $id_seccion = $request->input('id_seccion');
        $existe_grado_seccion = Vacantes::where('grado_id', $id_grado)->where('seccion_id', $id_seccion)->first();
        if($existe_grado_seccion){
            return response()->json(['success' => false, 'message' => 'Ya hay una vacante regisatrada para el grado y seccion proporcionada']);
        } else {
            $vacantes = new Vacantes();
            $vacantes->grado_id = $request->input('id_grado');
            $vacantes->seccion_id = $request->input('id_seccion');
            $vacantes->nro_vacante = $request->input('nroVacante');
            $vacantes->save();
            return response()->json(['success' => true, 'message' => 'Vacante registrada correctamente.']);
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        $vacantes = DB::select('CALL sp_editarVacantes(?)', [$id]);
        return response()->json($vacantes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function SumarVacante(Request $request, $id)
    {
        $vacante = Vacantes::findOrFail($id);
        $cantidadActual = $vacante->nro_vacante;
        $nuevaCantidad = $cantidadActual + $request->input('nuevaVacante');
        $vacante->update([
            'nro_vacante' => $nuevaCantidad,    
        ]);
        return response()->json(['success' => true, 'message' => 'Vacantes agregadas  correctamente']);
    }
    public function RestarVacante(Request $request, $id)
    {
        $vacante = Vacantes::findOrFail($id);
        $cantidadActual = $vacante->nro_vacante;
        $nuevaCantidad = $cantidadActual - $request->input('nuevaVacante');
    
        // Validar que la cantidad de vacantes a restar no sea mayor que la cantidad de vacantes actuales
        if ($nuevaCantidad < 0) {
            return response()->json(['success' => false, 'message' => 'La cantidad de vacantes a restar no puede ser mayor que la cantidad de vacantes actuales.']);
        }
    
        // Actualizar la cantidad de vacantes
        $vacante->update([
            'nro_vacante' => $nuevaCantidad,
        ]);
    
        // Devolver la respuesta
        return response()->json(['success' => true, 'message' => 'Vacantes restadas  correctamente']);
    }
     


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
