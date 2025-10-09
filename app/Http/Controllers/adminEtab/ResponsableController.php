<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ResponsableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = User::whereHas('filiere', function ($query) {
                $query->where('etablissement_id', auth()->user()->etablissement->id);
            })
            ->where('role_id',3)
            ->with('filiere:id,responsable_id,nom_abrv,nom_complet,type')
            ->get();
            
            $table = DataTables::of($data);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {

                $activeUserLink = 'activerUser('.$row->id.')';
                $desactiveUserLink = 'desactiverUser('.$row->id.')';

                if ($row->active == 1) {
                    $btn = "<button onClick=".$desactiveUserLink." class='btn btn-danger btn-sm mr-1'>Desactiver</button>";
                } else {
                    $btn = "<button onClick=".$activeUserLink." class='btn btn-success btn-sm mr-1'>Activer</button>";
                }

                $modifLink = route('admin-etab.responsable.edit',['user'=> $row->id]);
                $btn .= "<a href=".$modifLink." class='btn btn-warning btn-sm mr-1'>Modifier</a>";
                return $btn;
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });

            $table->editColumn('telephone', function ($row) {
                return $row->telephone ? $row->telephone : '';
            });

            $table->editColumn('active', function ($row) {
                if($row->active == 1){
                    return '<span class="badge bg-success text-white">Oui</span>';
                }else{
                    return '<span class="badge bg-danger text-white">Non</span>';
                }
            });

            $table->editColumn('nom_filiere', function ($row) {
                return $row->filiere ? $row->filiere->nom_abrv.'('.$row->filiere->nom_complet.')' : '';
            });

            $table->editColumn('type_filiere', function ($row) {
                return $row->filiere ? (\App\Models\Filiere::TYPE[$row->filiere->type] ?? 'Unknown') : '';
            });


            $table->rawColumns(['actions', 'active', 'placeholder']);

            return $table->make(true);
        }

        return view('admin-etab.responsable.index');
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
        $request['role_id'] = 3; //responsable filiere
        $request['active'] = 0;

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
            'active'    => $request->active,
            'created_by'=> Auth::id()
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
    public function edit(User $user)
    {
        if(!$user->filiere || $user->filiere->etablissement_id != auth()->user()->etablissement->id){
            abort(403);
        }
        return view('admin-etab.responsable.edit',compact('user'));
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

        $user->update($request->except('password'));

        if($request->password){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin-etab.responsable.index')->with('message','Responsable est modifié avec succée');
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
        return response()->json(['status' => 1,'message' => 'Ce responsable est activé maintenant, il peut se connecter à son compte.']);
    }

    public function desactiver(User $user){
        $user->update([
            'active' => 0
        ]);
        return response()->json(['status' => 1,'message' => 'Ce responsable est désactivé. Il ne peut plus se connecter à son compte.']);
    }
}
