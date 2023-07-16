<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::paginate(
            $request->get('per_page')
        );

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'lastname' => ['required', 'max:20'],
            'username' => ['required', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required|confirmed', 'max:255',
            'cellphone' => ['required'],
            'profile_image' 
        ]);

        if($request->hasFile('profile_image')){
            $file = $request->file('profile_image');
            
            $path = Storage::put('public/users', $file, 'public');
        }

        $user = User::create([
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'cellphone' => $request->get('cellphone'),
            'profile_image' => $path
        ]);

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id); 
        return UserResource::make($user);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'lastname' => ['required', 'max:20'],
            'username' => ['required', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'max:255'],
            'cellphone' => ['required']
        ]);

        $user = User::find($id);

        $user->update([
            'name' => $request->get('name'),
            'lastname' => $request->get('lastname'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'cellphone' => $request->get('cellphone')
        ]);

        return UserResource::make($user);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user ->delete();
        return $user;
    }
}
