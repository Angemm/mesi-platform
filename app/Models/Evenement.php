<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evenement extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'slug', 'description', 'date_debut', 'date_fin', 'heure', 'lieu', 'type', 'image', 'publie'];
    protected $casts = ['publie' => 'boolean', 'date_debut' => 'datetime', 'date_fin' => 'datetime'];
    public function getRouteKeyName() { return 'slug'; }
}
