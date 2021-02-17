<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelOrcamento extends Model
{
    protected $table="orcamentos";

    protected $fillable=[
        'cliente',
        'vendedor',
        'descricao',
        'data',
        'hora',
        'valor_orcado',
    ];

    use HasFactory;
}