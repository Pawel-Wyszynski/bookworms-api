<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function show()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json($user);
    }


    public function changeEmail(Request $request, $id)
{
    $user = User::find($id);

    if ($user->email !== $request->email) {
        return response()->json(['message' => 'Invalid email address'], 400);
    }

    if ($request->newEmail == $request->confirmEmail) {

    $user->update([
        'email' => $request->newEmail,
     ]);
    } 
    else  
     return response()->json(['message' => 'Invalid email confirmation'], 400);

    return response()->json($user);
}

    public function changeName(Request $request, $id)
{
    $user = User::find($id);

    if ($user->name !== $request->currentName) {
        return response()->json(['message' => 'Invalid username'], 400);
    }

    $user->update([
        'name' => $request->newName,
    ]);

    return response()->json($user);
}

public function changePassword(Request $request, $id)
{
   
}


}
