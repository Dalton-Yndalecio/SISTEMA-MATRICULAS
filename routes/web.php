<?php
use App\Http\Controllers\OcupacionController;
use App\Http\Controllers\ApoderadoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\VacantesController;
use App\Models\Apoderado;
use App\Models\Matricula;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::view('/login', "auth.login")->name('login');
//Route::get('/selectGrado', [MatriculaController::class, 'selectGrado']);
//Route::get('/selectSeccion', [MatriculaController::class, 'selectSeccion']);

// Route::get('/login', function () {
//     if (Auth::check()) {
//         return redirect()->route('home.index');
//     } else {
//         return view('auth/login');
//     }
// });
Route::get('/', [MatriculaController::class, 'welcome']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/home', function () {
    return view('home/index');
})->middleware(['auth', 'verified'])->name('home');

//RUTA PARA EL CONTROALDOR DE USUARIOS¿

//RUTAS PARA EL CONTROALODR DE APODERADOS
Route::get('/apoderados', [ApoderadoController::class, 'index'])->middleware('auth');
Route::get('/home', [MatriculaController::class, 'dashboard'])->middleware('auth');
Route::get('/apoderados/listaocupaciones', [OcupacionController::class, 'index'])->middleware('auth');
Route::post('/apoderados/create', [ApoderadoController::class, 'store'])->middleware('auth');
Route::post('/apoderados/ocupacion', [OcupacionController::class, 'store'])->middleware('auth');
Route::get('/apoderados/combo', [ApoderadoController::class, 'comboOcupacion'])->middleware('auth');
Route::get('/apoderados/editar/{id}', [ApoderadoController::class, 'editar'])->middleware('auth');
Route::get('/apoderados/ocupacionEditar/{id}', [OcupacionController::class, 'editar'])->middleware('auth');
Route::post('/apoderados/actualizar/{id}', [ApoderadoController::class, 'update'])->middleware('auth');
Route::post('/apoderados/actualizarOcupacion/{id}', [OcupacionController::class, 'update'])->middleware('auth');


// RUTAS PARA EL MODULO ESTUDINATES 

Route::get('/estudiantes', [EstudianteController::class, 'index'])->middleware('auth');
Route::get('/estudiantes/select', [EstudianteController::class, 'selectApoderado'])->middleware('auth');
Route::post('/estudiantes/create', [EstudianteController::class, 'store'])->middleware('auth');
Route::get('/estudiantes/editar/{id}', [EstudianteController::class, 'editar'])->middleware('auth');
Route::post('/estudiantes/actualizar/{id}', [EstudianteController::class, 'update'])->middleware('auth');



// RUTAS PARA MATRICULA
Route::get('/matriculas/constancia/{id}', [MatriculaController::class, 'Constanciapdf'])->middleware('auth');
Route::get('/matriculas/detalles/{id}', [MatriculaController::class, 'detallesMatricula'])->middleware('auth');
Route::get('/matriculas', [MatriculaController::class, 'index'])->middleware('auth');
Route::get('//matriculas/chartEstudiantes', [MatriculaController::class, 'chartEstudiantesMatriculados'])->middleware('auth');
Route::get('/matriculas/select', [MatriculaController::class, 'selectEstudiantes'])->middleware('auth');
Route::get('/matriculas/selectGrado', [MatriculaController::class, 'selectGrado'])->middleware('auth');
Route::get('/matriculas/selectSeccion', [MatriculaController::class, 'selectSeccion'])->middleware('auth');
Route::get('/matriculas/buscardni/{id}', [MatriculaController::class, 'buscarDni'])->middleware('auth');
Route::get('/matriculas/buscardniMatriculado/{id}', [MatriculaController::class, 'buscarDniMatriculado'])->middleware('auth');
Route::post('/matriculas/create', [MatriculaController::class, 'store'])->middleware('auth');
Route::post('/matriculas/addgrado', [MatriculaController   ::class, 'agregar_grado'])->middleware('auth');
Route::post('/matriculas/addseccion', [MatriculaController   ::class, 'agregar_seccion'])->middleware('auth');

// RUTAS PARA VACANTES
//Route::get('/', [MatriculaController::class, 'listavacantes']);
Route::post('/vacantes/agregar', [VacantesController::class, 'store'])->middleware('auth');
Route::get('/vacantes/editar/{id}', [VacantesController::class, 'editar'])->middleware('auth');
Route::post('/vacantes/aumentar/{id}', [VacantesController::class, 'SumarVacante'])->middleware('auth');
Route::post('/vacantes/restar/{id}', [VacantesController::class, 'RestarVacante'])->middleware('auth');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

require __DIR__.'/../vendor/autoload.php';

