<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data =  User::whereNotIn('role_id',[1,4])->with(['etablissement','filiere.etablissement'])->get();
            $table = DataTables::of($data);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                
                $modifLink = route('sup-admin.user.edit',['user' => $row->id]);
                $activeUserLink = 'activerUser('.$row->id.')';
                $desactiveUserLink = 'desactiverUser('.$row->id.')';
               
            
                $btn = "<a href=".$modifLink." class='btn btn-warning btn-sm mr-1'>Modifier</a>";
                if ($row->active == 1) {
                    $btn .= "<button onClick=".$desactiveUserLink." class='btn btn-danger btn-sm mr-1'>Desactiver</button>";
                } else {
                    $btn .= "<button onClick=".$activeUserLink." class='btn btn-success btn-sm mr-1'>Activer</button>";
                }
                
                return $btn;
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->editColumn('telephone', function ($row) {
                return $row->telephone ? $row->telephone : '';
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('role', function ($row) {
                return $row->role_id ? $row->role->nom : '';
            });

            $table->editColumn('etablissement', function ($row) {
                return $row->etablissement ? $row->etablissement->nom_abrev : ($row->filiere ? ($row->filiere->etablissement ? $row->filiere->etablissement->nom_abrev : "") : "");
            });

            $table->editColumn('active', function ($row) {
                return $row->active == 1 ? "<span class='badge bg-success text-white'>Oui</span>" : "<span class='badge bg-danger text-white'>Non</span>";
            });


            $table->rawColumns(['actions', 'placeholder','active']);

            return $table->make(true);
        }
        return view('sup-admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sup-admin.user.create');
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
    public function edit(User $user)
    {
        return view('sup-admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
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

        return redirect()->route('sup-admin.user.index')->with('message','Utilisateur est modifié avec succée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function activer(User $user){
        $user->update([
            'active' => 1
        ]);
        return response()->json(['status' => 1,'message' => 'Ce utilisateur est activé maintenant']);
    }

    public function desactiver(User $user){
        $user->update([
            'active' => 0
        ]);
        return response()->json(['status' => 1,'message' => 'Ce utilisateur est desactivé maintenant']);
    }
}
