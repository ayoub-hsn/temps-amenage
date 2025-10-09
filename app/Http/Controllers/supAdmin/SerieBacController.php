<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\SerieBac;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SerieBacController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data =  SerieBac::all();
            $table = DataTables::of($data);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                
                $modifLink = route('sup-admin.serie_bac.edit',['serie_bac' => $row->id]);
                
                $btn = "<a href=".$modifLink." class='btn btn-warning btn-sm mr-1'>Modifier</a>";
                
                
                return $btn;
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->editColumn('nom', function ($row) {
                return $row->nom ? $row->nom : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        return view('sup-admin.serie_bac.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sup-admin.serie_bac.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:200'
        ]);

        SerieBac::create($request->all());

        return redirect()->route('sup-admin.serie_bac.index')->with('message','Vous avez crée la série avec succées');
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
    public function edit(SerieBac $serie_bac)
    {
        return view('sup-admin.serie_bac.edit',compact('serie_bac'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SerieBac $serie_bac)
    {
        $request->validate([
            'nom' => 'required|max:200'
        ]);

        $serie_bac->update($request->all());

        return redirect()->route('sup-admin.serie_bac.index')->with('message','Vous avez modifié la série avec succées');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
