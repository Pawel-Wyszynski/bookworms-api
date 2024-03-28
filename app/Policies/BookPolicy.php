<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    public function before(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function index(User $user)
    {
        return Response::deny('Permission denied');
    }
}
