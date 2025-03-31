<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AlbumController extends Controller
{
    public function store(Request $request){

        $imagePath = $request->file('image')->store('user_images', 'public');
        $imageUrl = Storage::url($imagePath);

        $album = Album::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'released_date' => $request->release_date,
            'cover_image' => $imageUrl
        ]);

        return response()->json(['data' => $album]);

    }

    public function index(){

        $albums = Album::getAlbumsOrderedByVotes();
        return response()->json(['data' => $albums]);

    }

    public function show(Request $request){

        $albumSongs = Album::with(['song', 'userVotes'])->id($request->id)->paginate(10);
        return response()->json(['data' => $albumSongs]);

    }

    public function destroy(Album $id){
        $result = $id->deleteAlbumWithRelations();
        return response()->json(['data' => $result]);
    }

    public function search(Request $request){
        $input = $request->query('search');
        $searchResult = Album::search($input);
        return response()->json(['data' => $searchResult]);
    }
}
