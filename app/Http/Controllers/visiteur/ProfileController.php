<?php

namespace App\Http\Controllers\visiteur;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('visiteur.profile',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::whereId(Auth::id())->first();
        $request->validate([
            'name'      =>  'required|max:50',
            'telephone' =>  'required|max:10'
        ]);

        if($request->email != $user->email){
            $request->validate([
                'email'     =>  'required|max:50|unique:users,email'
            ]);
        }
        
        $user->update([
            'name' => $request->name,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);

        if($request->password){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
        return back()->with('message','Votre compte est modifié avec succée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
