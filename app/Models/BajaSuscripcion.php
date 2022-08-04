<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BajaSuscripcion extends Model
{
    use HasFactory;

    protected $table = 'baja_suscripcions';
    protected $hidden = ['created_at', 'updated_at'];


    protected $fillable = [
        'suscripcion_id',
        'nombre',
        'email',
        'fecha_baja',
        'eliminado'
    ];



    public function getSupcrition_baja(){
        return $this->hasOne(Suscripcion::class, 'id', 'subscripciones_id');
    }
}
