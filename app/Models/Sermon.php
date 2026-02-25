<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sermon extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'slug', 'predicateur', 'passage_biblique', 'audio_url', 'video_url', 'pdf_url', 'image', 'serie', 'description', 'date_predication', 'publie', 'telechargements'];
    protected $casts = ['publie' => 'boolean', 'date_predication' => 'date'];
    public function getRouteKeyName() { return 'slug'; }
}
