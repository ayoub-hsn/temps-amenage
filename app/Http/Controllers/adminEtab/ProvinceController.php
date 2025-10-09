<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Province::all();
            
            $table = DataTables::of($data);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {

              

                $modifLink = route('sup-admin.province.edit',['province'=> $row->id]);
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

        return view('sup-admin.province.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('.province.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
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
