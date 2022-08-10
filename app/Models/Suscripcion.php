<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suscripcion extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'suscripcions';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'nombre',
        'email',
        'fecha_sub'
    ];
}
