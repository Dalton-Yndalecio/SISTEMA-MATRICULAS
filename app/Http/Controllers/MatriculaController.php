<?php

namespace App\Http\Controllers;

use App\Models\Apoderado;
use App\Models\Estudiante;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\Ocupacion;
use App\Models\Seccion;
use App\Models\Vacantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // para trabjar con procediminetos alamcenados
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\Input;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function dashboard(Request $request){

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
        $apoderados = Apoderado::all();
        $cantidadApoderados = $apoderados->count();

        $estudiantes = Estudiante::all();
        $totalEstudiantes = $estudiantes->count();

        $matriculas = Matricula::all();
        $totalMatriculas = $matriculas->count();

        $ocupaciones = Ocupacion::all();
        $totalOcupaciones = $ocupaciones->count();
    
        return view('home.index', ['cantidadApoderados' => $cantidadApoderados,
        'totalEstudiantes'=> $totalEstudiantes,
        'totalMatriculas'=> $totalMatriculas,
        'totalOcupaciones'=>$totalOcupaciones]);
    }
    public function welcome(){
        return view('welcome');
    }
    
    public function chartEstudiantesMatriculados()
    {
        $añoActual = date('Y');
        $añoAnterior = $añoActual - 1;

        // Obtener todos los grados disponibles
        $grados = Grado::all();

        // Obtener las matrículas del año actual y del año anterior
        $matriculasActual = Matricula::whereYear('fecha_registro', $añoActual)->get();
        $matriculasAnterior = Matricula::whereYear('fecha_registro', $añoAnterior)->get();

        // Calcular la cantidad total de alumnos matriculados en el año actual
        $totalAlumnos = $matriculasActual->count();

        // Contar la cantidad de matrículas por grado y año
        $estudiantesPorGrado = [];
        
        foreach ($grados as $grado) {
            $gradoNombre = $grado->nombre;
            $estudiantesPorGrado[$gradoNombre] = [
                'nombre' => $gradoNombre,
                'matriculas_actual' => $matriculasActual->where('grado_id', $grado->id)->count(),
                'matriculas_anterior' => $matriculasAnterior->where('grado_id', $grado->id)->count(),
            ];
        }

        // Crear un objeto JSON con la información
        $data = json_encode([
            'grados' => $grados,
            'estudiantesPorGrado' => array_values($estudiantesPorGrado), // Convierte el array asociativo a un array numérico
            'totalAlumnos' => $totalAlumnos, // Agregar el total de alumnos
        ]);

        // Devolvemos la cadena JSON como respuesta
        return response()->json($data);
    }






    public function index(Request $request)
    {
        $selectedYear = $request->input('selectedYear', date('Y')); // Año seleccionado, por defecto el actual
        $availableYears = Matricula::select(DB::raw('YEAR(fecha_registro) as year'))
                ->distinct()
                ->orderBy('year', 'desc')
                ->get();
        if ($request->ajax()) {
           
            $matriculas = Matricula::with(['estudiante', 'grado', 'seccion'])
                ->whereYear('fecha_registro', $selectedYear)
                ->get();

            // Obtén los años únicos de la columna fecha_registro
            

            return DataTables::of($matriculas)
                ->addColumn('estudiante', function ($matricula) {
                    return $matricula->estudiante->nombres . ' ' . $matricula->estudiante->apellidos;
                })
                ->addColumn('grado', function ($matricula) {
                    return $matricula->grado->nombre;
                })
                ->addColumn('seccion', function ($matricula) {
                    return $matricula->seccion->nombre;
                })
                ->addColumn('action', function ($matricula) {
                    $editar = '<button class="btn btn-outline-info btn-sm btn-detalles" data-modal="Detalles" data-id="' . $matricula->id . '"><i class="fas fa-eye"></i></button>';
                    $pdf = '<button class="btn btn-outline-danger btn-sm btn-constancia" data-id="' . $matricula->id . '"><i class="fas fa-file-pdf"></i></button>';
                    return $editar . ' ' . $pdf;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Matricula.index', ['availableYears' => $availableYears]);
    }

    public function selectEstudiantes(){
        $estudiantes = Estudiante::all();
        return response()->json($estudiantes);
    }
    public function selectGrado(){
        $grados = Grado::all();
        return response()->json($grados);
    }
    public function selectSeccion(){
        $secciones = Seccion::all();
        return response()->json($secciones);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function detallesMatricula($id)
    {
        $matriculas = Matricula::find($id);
        $id_est = $matriculas->estudiante_id;
        $estudiante = Estudiante::find($id_est);
        $id_apo = $estudiante->apoderado_id;
        $apoderado = Apoderado::find($id_apo);
        $detalles = [
            'id' => $matriculas->id,
            'estudiante' => [
                'nombre' => $estudiante->nombres,
                'apellido' => $estudiante->apellidos,
                'dni' => $estudiante->dni,
                'direccion'=> $estudiante->direccion,
                'celular' => $estudiante->celular
            ],
            'apoderado' => [
                'nombre' => $apoderado->nombres,
                'apellido' => $apoderado->apellidos
            ],
        ];
        return response()->json($detalles);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $añoActual = date('Y');
        $estudiante_id = $request->input('estudiante_id');

        // Verifica si el estudiante ya está matriculado en el año actual
        $existeEstudiante = Matricula::where('estudiante_id', $estudiante_id)
            ->whereYear('fecha_registro', $añoActual)
            ->first();

        if ($existeEstudiante) {
            return response()->json(['success' => false, 'message' => 'El alumno ya está matriculado en este año']);
        }

        $grado_id = $request->input('grado_id');
        $seccion_id = $request->input('seccion_id');

        // Obtén la información de la tabla "Vacantes" para el grado y sección seleccionados
        $vacantes = Vacantes::where('grado_id', $grado_id)
            ->where('seccion_id', $seccion_id)
            ->first();

        if (!$vacantes) {
            return response()->json(['success' => false, 'message' => 'No hay vacantes disponibles para este grado y sección']);
        }

        if ($vacantes->nro_vacante <= 0) {
            return response()->json(['success' => false, 'message' => 'No hay vacantes disponibles para este grado y sección']);
        }

        // Registra la matrícula
        $matricula = new Matricula();
        $matricula->estudiante_id = $estudiante_id;
        $matricula->grado_id = $grado_id;
        $matricula->seccion_id = $seccion_id;

        $observacion = $request->input('observacion');
        $matricula->observacion = $observacion ? $observacion : 'Sin observaciones';

        $matricula->save();

        // Reduce el contador de vacantes en 1
        $vacantes->decrement('nro_vacante');

        return response()->json(['success' => true, 'message' => 'Estudiante Matriculado correctamente.']);
    }



    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula)
    {
        //
    }
    public function buscarDni($dni){
        $buscar = DB::select('CALL sp_buscardniEstudiante(?)', [$dni]);
        if (!empty($buscar)) {
            return response()->json(['estudiante' => $buscar[0]]);
        } else {
            return response()->json(['error' => 'No se encontró ningún estudiante con el DNI proporcionado']);
        }
    }
    public function buscarDniMatriculado($dni){
        $buscar = DB::select('CALL sp_buscarEstudianteMatriculado(?)', [$dni]);
        $years = [];
    
    foreach ($buscar as $registro) {
        $year = date('Y', strtotime($registro->fecha_registro));
        $years[] = $year;
    }
    
    $unique_years = array_unique($years);
        Log::alert($buscar);
        if (!empty($buscar)) {
            return response()->json(['estudiante' => $buscar[0], 'years' => $unique_years]);
            //return response()->json(['estudiante' => json_encode($buscar[0])]);
        } else {
            return response()->json(['error' => 'No se encontró ningún estudiante con el DNI proporcionado']);
        }
    }
    public function agregar_grado(Request $request)
    {
        $gradoNombre = $request->input('gradoseccion');
        $existeGrado = Grado::where('nombre', $gradoNombre)->first();

        if ($existeGrado) {
            return response()->json(['success' => false, 'message' => 'Ya existe un grado similar']);
        } else {
            // Crear el grado
            $grado = new Grado();
            $grado->nombre = $gradoNombre;
            $grado->save();

            // Crear 25 vacantes para este grado con nro_vacantes en cada sección existente
            $secciones = Seccion::all();
            foreach ($secciones as $seccion) {
                $vacante = new Vacantes();
                $vacante->grado_id = $grado->id;
                $vacante->seccion_id = $seccion->id;
                $vacante->nro_vacante = 35;
                $vacante->save();
            }

            return response()->json(['success' => true, 'message' => 'Grado registrado correctamente.']);
        }
    }

    public function agregar_seccion(Request $request)
    {
        $seccionNombre = $request->input('gradoseccion');
        $existeSeccion = Seccion::where('nombre', $seccionNombre)->first();

        if ($existeSeccion) {
            return response()->json(['success' => false, 'message' => 'Ya existe una sección similar']);
        } else {
            // Crear la sección
            $seccion = new Seccion();
            $seccion->nombre = $seccionNombre;
            $seccion->save();

            // Crear 25 vacantes para esta sección con nro_vacantes en cada grado existente
            $grados = Grado::all();
            foreach ($grados as $grado) {
                $vacante = new Vacantes();
                $vacante->grado_id = $grado->id;
                $vacante->seccion_id = $seccion->id;
                $vacante->nro_vacante = 35;
                $vacante->save();
            }

            return response()->json(['success' => true, 'message' => 'Sección registrada correctamente.']);
        }
    }




    /**
     * Show the form for editing the specified resource.    
     */
    public function edit(Matricula $matricula)
    {
        //
    }
    public function Constanciapdf( $id){
        $matricula = Matricula::find($id);
        $estudiante = $matricula->estudiante_id;
        $grado = $matricula->grado_id;
        $seccion = $matricula->seccion_id;
        $estudiante = Estudiante::find($estudiante);
        $grado = Grado::find($grado);
        $seccion = Seccion::find($seccion);
        $datos = compact('matricula', 'estudiante', 'grado', 'seccion');
        //$estudiante = DB::select('CALL sp_constanciaAlumno(?)', [$id]);
        $pdf = Pdf::loadView('Matricula.Constanciapdf', compact('datos'));
        return $pdf->stream();  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $matricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        //
    }
}
