<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $table = 'inscripcions'; // Nombre exacto en BD según migración

    protected $fillable = ['usuario_id', 'grupo_id']; // Cambiar user_id por usuario_id

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function grupo()
    {
        return $this->belongsTo(grupo::class);
    }
}
