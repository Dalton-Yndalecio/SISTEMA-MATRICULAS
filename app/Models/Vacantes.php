<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacantes extends Model
{
    protected $table = 'vacantes';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'nro_vacante',
    ];

    public function grado(){
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }
    public function seccion(){
        return $this->belongsTo(Seccion::class, 'seccion_id', 'id');
    }
}
