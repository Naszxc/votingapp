<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Album;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_date',
        'album_id'
    ];

    public function album(){
        return $this->belongsTo(Album::class);
    }
    
}
