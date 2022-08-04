<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'suscripcions';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'nombre',
        'email',
        'fecha_sub'
    ];
}
