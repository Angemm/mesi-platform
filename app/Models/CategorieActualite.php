<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieActualite extends Model
{
    protected $fillable = ['nom', 'slug', 'couleur'];
    public function actualites() { return $this->hasMany(Actualite::class, 'categorie_id'); }
}
