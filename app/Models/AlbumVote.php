<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Album;

class AlbumVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'user_id'
    ];

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function scopeGetAlbumVotes($query, $userId){
        return $query->with('album')->where('user_id', $userId)->paginate(5);
    }
}
