<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlbumVote;

class AlbumVoteController extends Controller
{
    public function store(Request $request){
        $album_id = $request->id;
        $user_id = $request->user()->id;

        $albumVote = AlbumVote::create([
            'album_id' => $album_id,
            'user_id' => $user_id
        ]);

        return response()->json(['data' => $albumVote]);
    }

    public function destroy(AlbumVote $id){
        $result = $id->delete();
        return response()->json(['data' => $result]);
    }

    public function index(Request $request){
        // $albumVote = AlbumVote::with('album')->forUser($request->user()->id)->paginate(10);
        $albumVote = AlbumVote::getAlbumVotes($request->user()->id);

        return response()->json(['data' => $albumVote]);
    }
}
