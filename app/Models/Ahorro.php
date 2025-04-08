<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahorro extends Model
{
    use HasFactory;

    // Relación de un cliente a un ahorro
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
