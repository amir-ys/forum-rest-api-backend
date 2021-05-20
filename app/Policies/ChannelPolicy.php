<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    public function store($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CHANNELS)) return True;
        return null;
    }

    public function update($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CHANNELS)) return True;
        return null;
    }

    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_CHANNELS)) return True;
        return null;
    }
}
