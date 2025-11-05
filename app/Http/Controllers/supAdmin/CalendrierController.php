<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\Calendrier;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Http\Controllers\Controller;

class CalendrierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calendriers = Calendrier::with('etablissement')->get();
        return view('sup-admin.calendrier.index',compact('calendriers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etablissements = Etablissement::has('filiere')->get();
        return view('sup-admin.calendrier.create',compact('etablissements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'etablissement_id'      => 'required',
            'date_debut_master'     => 'required',
            'date_fin_master'       => 'required',
            'date_debut_passerelle' => 'required',
            'date_fin_passerelle'   => 'required',
            'date_debut_bachelier'  => 'required',
            'date_fin_bachelier'    => 'required'
        ]);
        Calendrier::create($request->all());

        return redirect()->route('sup-admin.calendrier.index')->with('message','Calendrier est crée avec succées');
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
    public function edit(Calendrier $calendrier)
    {
        $etablissements = Etablissement::has('filiere')->get();
        return view('sup-admin.calendrier.edit',compact('calendrier','etablissements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Calendrier $calendrier)
    {
        $request->validate([
            'etablissement_id'      => 'required',
            'date_debut_master'     => 'required',
            'date_fin_master'       => 'required',
            'date_debut_passerelle' => 'required',
            'date_fin_passerelle'   => 'required',
            'date_debut_bachelier'  => 'required',
            'date_fin_bachelier'    => 'required'
        ]);
        $calendrier->update($request->all());

        return redirect()->route('sup-admin.calendrier.index')->with('message','Calendrier est modifié avec succées');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
