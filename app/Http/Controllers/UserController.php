<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangeNameRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeDescriptionRequest;
use JWTAuth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function show()
    {
        $user = JWTAuth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json($user);
    }


    public function changeEmail(ChangeEmailRequest $request)
    {
        $user = JWTAuth::user();

        if ($user->email != $request->email) {
            return response()->json(['message' => 'Invalid email address'], 400);
        }

        if ($request->newEmail == $request->confirmEmail) {

            $user->update([
                'email' => $request->newEmail,
            ]);
        } else return response()->json(['message' => 'Invalid email confirmation'], 400);

        return response()->json($user);
    }

    public function changeName(ChangeNameRequest $request)
    {
        $user = JWTAuth::user();

        if ($user->name != $request->currentName) {
            return response()->json(['message' => 'Invalid username'], 400);
        }

        $user->update([
            'name' => $request->newName,
        ]);

        return response()->json($user);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = JWTAuth::user();

        if (!Hash::check($request->oldPassword, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 400);
        }

        if ($request->newPassword == $request->confirmPassword) {

            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);
        } else return response()->json(['message' => 'Invalid password confirmation'], 400);

        return response()->json($user);
    }

    public function changeDescription(ChangeDescriptionRequest $request)
    {
        $user = JWTAuth::user();

        $user->update([
            'description' => $request->description,
        ]);

        return response()->json($user);
    }

    public function index()
    {
        if(Gate::allows('viewAny', User::class)) {
            $users = User::all();
            return response()->json($users);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (Gate::allows('update', $user)) {
            $user->update($request->all());
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function destroy(User $user)
    {
        if (Gate::allows('delete', $user)) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
