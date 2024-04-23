<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function estudiante(){
        return $this->belongsTo(Estudiante::class, 'estudiante_id', 'id');
    }
    public function grado(){
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }
    public function seccion(){
        return $this->belongsTo(Seccion::class, 'seccion_id', 'id');
    }
}
