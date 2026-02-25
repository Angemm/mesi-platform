<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VersetJour extends Model
{
    protected $fillable = ['texte', 'reference', 'traduction', 'actif', 'date'];
    protected $casts = ['actif' => 'boolean', 'date' => 'date'];
}
