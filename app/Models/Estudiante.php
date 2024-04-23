<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    public $timestamps = false;
    protected $primaryKey = 'id';
    
    public function apoderados(){
        return $this->belongsTo(Apoderado::class, 'apoderado_id', 'id');
    }
}
