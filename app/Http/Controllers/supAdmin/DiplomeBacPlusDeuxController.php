<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\DiplomBac2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DiplomeBacPlusDeuxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data =  DiplomBac2::all();
            $table = DataTables::of($data);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                
                $modifLink = route('sup-admin.diplomebacplusdeux.edit',['diplomebacplusdeux' => $row->id]);
                
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
        return view('sup-admin.diplomebacplusdeux.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sup-admin.diplomebacplusdeux.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|max:200'
        ]);

        DiplomBac2::create($request->all());

        return redirect()->route('sup-admin.diplomebacplusdeux.index')->with('message','Vous avez crée le diplome avec succées');
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
    public function edit(DiplomBac2 $diplomebacplusdeux)
    {
        return view('sup-admin.diplomebacplusdeux.edit',compact('diplomebacplusdeux'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiplomBac2 $diplomebacplusdeux)
    {
        $request->validate([
            'nom' => 'required|max:200'
        ]);

        $diplomebacplusdeux->update($request->all());

        return redirect()->route('sup-admin.diplomebacplusdeux.index')->with('message','Vous avez modifié le diplome avec succées');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
