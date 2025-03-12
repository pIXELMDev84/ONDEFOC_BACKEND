<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return response()->json($users);
    }


    public function updateUsername(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->username = $request->input('username');
        $user->save();
    
        return response()->json(['message' => 'Username updated successfully'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($user){
            $user->delete();
            return response()->json(['message' => 'user deleted successfully'], 200);
        }else{
            return response()->json(['message' => 'user not fond'], 200);
        }
        
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user->nom = $request->input('nom');
            $user->prenom = $request->input('prenom');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            if ($request->filled('password')) {
                $user->password = bcrypt($request->input('password'));
            }
            $user->role = $request->input('role');
    
            $user->save();
    
            return response()->json(['message' => 'Utilisateur modifié avec succès', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur interne', 'error' => $e->getMessage()], 500);
        }
    }
    
}
