<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portaria extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'numeroPortaria';

    protected $fillable = [
        'numeroPortaria',
        'dataCriacao',
        'dataEncerramento',
        'descricao',
        'isPrivate',
        'arquivo'
    ];
}
