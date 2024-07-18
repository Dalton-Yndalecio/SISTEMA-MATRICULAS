<?php

namespace App\Http\Controllers;

use App\Models\Apoderado;
use App\Models\Ocupacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabjar con procediminetos alamcenados
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
class ApoderadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            
            $apoderados = Apoderado::with('ocupacion')->get();
            return DataTables::of($apoderados)
                    ->addColumn('ocupacion', function($apoderado){
                        return $apoderado->ocupacion->nombre;
                    })
                    ->addColumn('action', function($apoderados){
                        $editar = '<button class="btn btn-outline-warning btn-sm btn-modal" data-modal="Editar" data-id="'.$apoderados->id.'" type="button"><i class="fas fa-edit"></i></button>';
                        return $editar;
                        
                    })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Apoderado.index');
    }

    public function comboOcupacion(){
        $ocupaciones = Ocupacion::all();
        return response()->json($ocupaciones);
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
        $dni = $request->input('dni');
        $Existedni = Apoderado::where('dni', $dni)->first();
        if($Existedni){
            return response()->json(['success' => false, 'message' => 'Ya existe un apoderado con el mismo DNI.']);
        } else {
            $apoderado = new Apoderado();
            $apoderado->ocupacion_id = $request->input('ocupacion_id');
            $apoderado->dni = $request->input('dni');
            $apoderado->nombres = $request->input('nombres');
            $apoderado->apellidos = $request->input('apellidos');
            $apoderado->direccion = $request->input('direccion');
            $apoderado->celular = $request->input('celular');
            $apoderado->fecha_nacimiento = $request->input('fecha_nacimiento');
            $apoderado->save();
            return response()->json(['success' => true, 'message' => 'Apoderado  registrado correctamente.']);
        }   
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Apoderado $apoderado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        $apoderado = DB::select('CALL sp_editarApoderado(?)', [$id]);
        return response()->json($apoderado);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $apoderado = Apoderado::find($id);

        if (!$apoderado) {
            return response()->json(['success' => false, 'message' => 'El apoderado no existe.']);
        }
        $dniNuevo = $request->input('dni');
        $Existedni = Apoderado::where('dni', $dniNuevo)->where('id', '!=', $id)->first();
        if ($Existedni) {
            return response()->json(['success' => false, 'message' => 'Ya existe un apoderado con el mismo DNI.']);
        }
        $apoderado->ocupacion_id = $request->input('ocupacion_id');
        $apoderado->dni = $dniNuevo;
        $apoderado->nombres = $request->input('nombres');
        $apoderado->apellidos = $request->input('apellidos');
        $apoderado->direccion = $request->input('direccion');
        $apoderado->celular = $request->input('celular');
        $apoderado->fecha_nacimiento = $request->input('fecha_nacimiento');
        $apoderado->save();

        return response()->json(['success' => true, 'message' => 'Apoderado actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apoderado $apoderado)
    {
        //
    }
}
