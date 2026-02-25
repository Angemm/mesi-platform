<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsletter extends Model
{
    protected $fillable = ['email', 'nom', 'actif', 'token'];
    protected $casts = ['actif' => 'boolean'];
}
