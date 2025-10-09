<?php

namespace App\Http\Controllers\adminEtab;

use App\Http\Controllers\Controller;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use App\Models\User;
use App\Notifications\CandidatNotifie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
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
        $etudiantsMaster = StudentMaster::where('etablissement_id',auth()->user()->etablissement->id)->get();
        $etudiantsLicence = StudentPasserelle::where('etablissement_id',auth()->user()->etablissement->id)->get();
        return view('admin-etab.notification.create',compact('etudiantsMaster','etudiantsLicence'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'titre'     => 'required:max:150',
            'message'   => 'required'
        ]);

        $users = User::whereIn('id',$request->etudiantsMaster)->get();
        Notification::send($users, new CandidatNotifie(
            $request->titre,
            $request->message
        ));

        return redirect()->route('admin-etab.notification.create')->with('message','Message est envoyé avec succées');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        // Marquer comme lu si pas encore lu
        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'title' => $notification->data['title'],
            'message' => $notification->data['message'],
            'time' => $notification->created_at->diffForHumans()
        ]);
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
