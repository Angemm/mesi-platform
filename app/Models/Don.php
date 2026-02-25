<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Don extends Model
{
    protected $fillable = ['donateur_nom', 'donateur_email', 'donateur_telephone', 'montant', 'devise', 'motif', 'mission_id', 'transaction_id', 'statut', 'methode_paiement'];
    public function mission() { return $this->belongsTo(Mission::class); }
}
