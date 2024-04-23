<?php

namespace App\Http\Controllers;

use App\Models\Apoderado;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabjar con procediminetos alamcenados
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            
            $estudiantes = Estudiante::with('apoderados')->get();
            //Log::alert($estudiantes);
            return DataTables::of($estudiantes)
                    ->addColumn('apoderados', function($estudiantes){
                         $apoderado = $estudiantes->apoderados->nombres .' ' .$estudiantes->apoderados->apellidos;
                         return $apoderado;
                    })
                    ->addColumn('action', function($estudiantes){
                        $editar = '<button class="btn btn-outline-warning btn-sm modal-Estudiante" modal-estudiante="Actualizar" data-id="'.$estudiantes->id.'" type="button"><i class="fas fa-edit"></i></button>';
                        return $editar;
                        
                    })
                    
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('Estudiante.index');
    }
    public function selectApoderado(){
        $apodeardos = Apoderado::all();
        return response()->json($apodeardos);
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
        $Existedni = Estudiante::where('dni', $dni)->first();
        if($Existedni){
            return response()->json(['success' => false, 'message' => 'Ya existe un Estudiante con el mismo DNI.']);
        } else {
            $estudiante = new Estudiante();
            $estudiante->apoderado_id = $request->input('apoderado_id');
            $estudiante->dni = $request->input('dni');
            $estudiante->nombres = $request->input('nombres');
            $estudiante->apellidos = $request->input('apellidos');
            $estudiante->direccion = $request->input('direccion');
            $estudiante->celular = $request->input('celular');
            $estudiante->fecha_nacimiento = $request->input('fecha_nacimiento');
            $estudiante->save();
            return response()->json(['success' => true, 'message' => 'Estudiante registrado correctamente.']);
        }   
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editar($id)
    {
        $estudiante = DB::select('CALL sp_editarEstudiante(?)', [$id]);
        return response()->json($estudiante);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $estudiante = Estudiante::find($id);
        Log::alert($estudiante);

        if (!$estudiante) {
            return response()->json(['success' => false, 'message' => 'El estudiante no existe.']);
        }
        $dniNuevo = $request->input('dni');
        $Existedni = Estudiante::where('dni', $dniNuevo)->where('id', '!=', $id)->first();
        if ($Existedni) {
            return response()->json(['success' => false, 'message' => 'Ya existe un estudiante con el mismo DNI.']);
        }
        $estudiante->apoderado_id = $request->input('apoderado_id');
        $estudiante->dni = $dniNuevo;
        $estudiante->nombres = $request->input('nombres');
        $estudiante->apellidos = $request->input('apellidos');
        $estudiante->direccion = $request->input('direccion');
        $estudiante->celular = $request->input('celular');
        $estudiante->fecha_nacimiento = $request->input('fecha_nacimiento');
        $estudiante->save();

        return response()->json(['success' => true, 'message' => 'Estudiante actualizado correctamente.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        //
    }
}
