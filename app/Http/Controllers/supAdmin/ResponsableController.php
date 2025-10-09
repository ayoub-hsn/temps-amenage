<?php

namespace App\Http\Controllers\supAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResponsableController extends Controller
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
        $request['role_id'] = 2; //responsable etablissements
        $request['active'] = 1;

        $request->validate([
            'name'      =>  'required|max:50',
            'telephone' =>  'required|max:10',
            'email'     =>  'required|max:50|unique:users,email',
            'password'  =>   'required',
            'role_id'   =>    'required',
            'active'    => 'required'
        ]);
        

        $user = User::create([
            'name'  => $request->name,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id,
            'active'    => $request->active
        ]);

        $option = '<option value="'.$user->id.'" selected>'.$user->name.'</option>';

        return response()->json([
            'message' => 'Nouveau responsable est ajouté',
            'option'  => $option
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
