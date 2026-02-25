<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Contact extends Model
{
    protected $fillable = ['nom', 'email', 'telephone', 'sujet', 'message', 'lu', 'repondu'];
    protected $casts = ['lu' => 'boolean', 'repondu' => 'boolean'];
}
