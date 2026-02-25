<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Mission extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'slug', 'description', 'pays', 'region', 'image', 'actif', 'objectif_don', 'dons_recus', 'responsable', 'date_debut', 'date_fin'];
    protected $casts = ['actif' => 'boolean', 'date_debut' => 'date', 'date_fin' => 'date'];
    public function getRouteKeyName() { return 'slug'; }
    public function scopeActif($q) { return $q->where('actif', true); }
}
