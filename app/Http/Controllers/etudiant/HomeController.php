<?php

namespace App\Http\Controllers\etudiant;

use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissementCount = Etablissement::count();
        $filieresMasterCount = Filiere::where('type',1)->where('active',1)->count();
        $filierePasserelleCount = Filiere::where('type',2)->where('active',1)->count();
        $candidaturesMasterCount = StudentMaster::where('user_id',auth()->user()->id)->count();
        $candidaturesPasserelleCount = StudentPasserelle::where('user_id',auth()->user()->id)->count();
        $etablissementsWithFiliereCount = Etablissement::withCount('filiere')->get();

        // 🔔 Notifications du candidat connecté
        $notifications = auth()->user()->unreadNotifications; // non lues
        $allNotifications = auth()->user()->notifications;     // toutes
        return view('etudiant.dashboard',compact('etablissementCount',
        'filieresMasterCount',
        'filierePasserelleCount',
        'candidaturesMasterCount',
        'candidaturesPasserelleCount',
        'etablissementsWithFiliereCount',
        'notifications',
        'allNotifications'
        ));
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
