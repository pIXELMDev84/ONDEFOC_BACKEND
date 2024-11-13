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
}
