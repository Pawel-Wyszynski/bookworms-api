<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;



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


    public function changeEmail(ChangeEmailRequest $request)
{
    $user = auth()->user();

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

    public function changeName(ChangeNameRequest $request)
{
    $user = auth()->user();
    if ($user->name !== $request->currentName) {
        return response()->json(['message' => 'Invalid username'], 400);
    }

    $user->update([
        'name' => $request->newName,
    ]);

    return response()->json($user);
}

public function changePassword(ChangePasswordRequest $request)
{
    $user = auth()->user();
    if (!Hash::check($request->oldPassword, $user->password)) {
        return response()->json(['message' => 'Invalid password'], 400);
    }

    if ($request->newPassword == $request->confirmPassword) {

    $user->update([
        'password' => Hash::make($request->newPassword),
     ]);
    } 
    else  
    return response()->json(['message' => 'Invalid password confirmation'], 400);

    return response()->json($user);
}


}
