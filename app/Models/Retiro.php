<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
    use HasFactory;

    
    // Relación de un cliente a un retiro
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
