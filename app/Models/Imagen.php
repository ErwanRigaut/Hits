<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'imagen',
        'id',
        'titulo',
        'autor',
        'duracion',
        'url',
        'active',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
