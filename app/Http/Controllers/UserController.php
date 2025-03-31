<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Hash;


class UserController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'nullable',
            'name' => 'required|string|max:25'
        ]);

        $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password,
                    'role' => $request->role
                ]);

        return response()->json(['message' => $user]);
    }

    public function show(){
        $users = User::all()->map(function ($user){
            $user->image = $user->image ? asset($user->image) : null;
            return $user;
        });
        
        return response()->json(['message' => $users]);
    }

    public function update(Request $request, User $user){
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json(['message' => $user]);
    }

    public function login(Request $request){
        $credentials = $request->all();

        // if($user = User::findByEmail($credentials['email'])){
            $user = Auth::guard('web')->attempt($credentials);
            // $request->session()->regenerate();
        // }

        return response()->json(['message' => $user]);
    }
}
