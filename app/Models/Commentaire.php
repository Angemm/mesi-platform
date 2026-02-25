<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    protected $fillable = ['nom', 'email', 'contenu', 'culte_id', 'approuve'];
    protected $casts = ['approuve' => 'boolean'];
    public function culte() { return $this->belongsTo(Culte::class); }
}
