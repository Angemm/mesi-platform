<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actualite extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'slug', 'contenu', 'extrait', 'image', 'publie', 'categorie_id', 'auteur_id', 'en_vedette', 'vues'];
    protected $casts = ['publie' => 'boolean', 'en_vedette' => 'boolean'];
    public function getRouteKeyName() { return 'slug'; }
    public function categorie() { return $this->belongsTo(CategorieActualite::class, 'categorie_id'); }
    public function auteur() { return $this->belongsTo(User::class, 'auteur_id'); }
    public function scopePublie($q) { return $q->where('publie', true); }
}
