<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AlbumVote;
use App\Models\Song;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'released_date',
        'cover_image'
    ];

    public function scopeId($query, $id){
        return $query->where('id', $id);
    }

    public function scopeSearch($query, $search){
        return $query->with('song')
            ->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%$search%")
                    ->orWhere('released_date', 'LIKE', "%$search%")
                    ->orWhere('artist', 'LIKE', "%$search%");
            })
            ->orWhereHas('song', function ($query) use ($search) {
                $query->where('title', 'LIKE', "%$search%")
                    ->orWhere('release_date', 'LIKE', "%$search%");
            })->get();
    }

    public function album(){
        return $this->belongsTo(Album::class);
    }

    public function userVotes()
    {
        $userId = auth()->id();

        return $this->hasMany(AlbumVote::class)->forUser($userId);
    }

    public function song(){
        return $this->hasMany(Song::class);
    }

    public function votes()
    {
        return $this->hasMany(AlbumVote::class);
    }

    public function deleteAlbumWithRelations()
    {
        $this->song()->delete();
        $this->userVotes()->delete();
        $this->delete();
    }

    public function scopeGetAlbumsOrderedByVotes($query){
        return $query->withCount('votes')
            ->orderByDesc('votes_count')
            ->orderBy('title', 'asc')
            ->paginate(5);
    }
}
