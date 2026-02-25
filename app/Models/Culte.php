<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Culte extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre', 'slug', 'description', 'date_culte', 'heure',
        'predicateur', 'passage_biblique', 'type', 'image',
        'lien_video', 'lien_live', 'est_live', 'est_a_venir',
        'publie', 'ordre', 'vues'
    ];
    protected $casts = ['est_live' => 'boolean', 'est_a_venir' => 'boolean', 'publie' => 'boolean', 'date_culte' => 'date'];
    public function getRouteKeyName() { return 'slug'; }
    public function commentaires() { return $this->hasMany(Commentaire::class); }
    public function scopePublie($q) { return $q->where('publie', true); }
    public function scopeLive($q) { return $q->where('est_live', true); }
}
