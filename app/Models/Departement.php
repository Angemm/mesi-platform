<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    protected $fillable = ['nom', 'description', 'responsable_id', 'icone', 'couleur'];
    public function membres() { return $this->hasMany(Membre::class); }
    public function responsable() { return $this->belongsTo(Membre::class, 'responsable_id'); }
}
