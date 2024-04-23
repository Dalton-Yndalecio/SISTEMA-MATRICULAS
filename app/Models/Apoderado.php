<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Apoderado extends Model
{
    protected $table = 'apoderados';
    public $timestamps = false;
    protected $primaryKey = 'id';


    public function ocupacion(){
        return $this->belongsTo(Ocupacion::class, 'ocupacion_id', 'id');
    }
}
