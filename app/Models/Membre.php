<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membre extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'prenom', 'email', 'telephone', 'photo', 'date_naissance', 'date_bapteme', 'departement_id', 'role', 'actif', 'user_id'];
    protected $casts = ['actif' => 'boolean', 'date_naissance' => 'date', 'date_bapteme' => 'date'];
    public function departement() { return $this->belongsTo(Departement::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function getFullNameAttribute() { return $this->prenom . ' ' . $this->nom; }
}
