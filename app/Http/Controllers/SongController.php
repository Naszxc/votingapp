<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller
{
    public function store(Request $request){

        $song = Song::create([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'album_id' => $request->album_id
        ]);

        return response()->json(['data' => $song]);

    }

    public function index(){
        $songList = Song::with(['album.userVotes'])->paginate(10);

        return response()->json(['data' => $songList]);
    }

}
