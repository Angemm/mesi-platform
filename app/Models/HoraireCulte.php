<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HoraireCulte extends Model
{
    protected $fillable = ['jour', 'heure', 'type_culte', 'description', 'actif', 'ordre'];
    protected $casts = ['actif' => 'boolean'];
    public function scopeActif($q) { return $q->where('actif', true); }
}
