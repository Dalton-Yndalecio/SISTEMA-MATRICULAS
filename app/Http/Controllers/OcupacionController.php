<?php

namespace App\Http\Controllers;


use App\Models\Ocupacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabjar con procediminetos alamcenados
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class OcupacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            
            $ocupaciones = Ocupacion::all();
            return DataTables::of($ocupaciones)
                    ->addColumn('action', function($ocupaciones){
                        $editar = '<button class="btn btn-outline-warning btn-sm editar-ocupacion" data-ocupacion="Actualizar" data-id="'.$ocupaciones->id.'" type="button"><i class="fas fa-edit"></i></button>';
                        return $editar;
                        
                    })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Ocupacion.index');
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
        $ocupacion = $request->input('nombre');
        $existeOcupacion = Ocupacion::where('nombre', $ocupacion)->first();
        if($existeOcupacion){
            return response()->json(['success' => false, 'message' => 'Ya existe una ocupación similar']);
        }
        else{
            $ocupaciones = new Ocupacion();
            $ocupaciones->nombre = $request->input('nombre');
            $ocupaciones->save();
            return response()->json(['success' => true, 'message' => 'Ocupacion registrado correctamente.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function buscarOcupacion(Request $request)
    {
        //
                // Obtiene las ocupaciones de la base de datos
        $ocupaciones = Ocupacion::all();

        // Devuelve los datos en formato JSON
        return response()->json($ocupaciones);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        $ocupacion = DB::select('CALL sp_editarOcupacion(?)', [$id]);
        return response()->json($ocupacion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ocupacion = Ocupacion::find($id);

        if (!$ocupacion) {
            return response()->json(['success' => false, 'message' => 'La ocupación no existe.']);
        }
        $nombreNuevo = $request->input('nombre');
        $Existenombre = Ocupacion::where('nombre', $nombreNuevo)->where('id', '!=', $id)->first();
        if ($Existenombre) {
            return response()->json(['success' => false, 'message' => 'Ya existe una ocupación similar.']);
        }
        $ocupacion->nombre = $nombreNuevo;
        $ocupacion->save();

        return response()->json(['success' => true, 'message' => 'Ocupación actualizada correctamente.']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ocupacion $ocupacion)
    {
        //
    }
}
