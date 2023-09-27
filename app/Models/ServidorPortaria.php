<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServidorPortaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'numeroPortaria',
        'matriculaSiape',
    ];
}
