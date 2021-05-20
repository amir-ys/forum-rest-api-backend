<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Thread $thread)
    {
        return $user->id == $thread->user_id;
        return  null ;

    }


    public function delete(User $user, Thread $thread)
    {
        return $user->id == $thread->user_id;
        return  null ;
    }

}
