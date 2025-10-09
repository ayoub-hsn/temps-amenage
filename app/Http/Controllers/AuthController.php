<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showFormLogin(){
        return view('login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->active == 0){
                Auth::logout();
                return back()->with('login_error',"Votre compte n'est pas encore activé. Veuillez contacter votre responsable pour procéder à son activation.");
            }
            switch ($user->role_id) {
                case 1:
                    return redirect()->route('sup-admin.dashboard');
                    break;
                case 2:
                    return redirect()->route('admin-etab.dashboard');
                    break;
                case 3:
                    return redirect()->route('admin-filiere.dashboard');
                    break;
                case 4:
                    return redirect()->route('etudiant.dashboard');
                    break;
                case 5:
                    return redirect()->route('visiteur.dashboard');
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            return back()->with('login_error','Email ou password incorrecte');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}