<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calificacion extends Model
{
    protected $fillable = ['grupo_id', 'usuario_id', 'calificacion'];
}
