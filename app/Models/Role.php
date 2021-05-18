<?php


namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{
    const ROLE_SUPER_ADMIN = 'super admin';
    const ROLE_USER = 'user';

    static $roles = [
        self::ROLE_USER => [Permission::PERMISSION_USER],
        self::ROLE_SUPER_ADMIN => [Permission::PERMISSION_SUPER_ADMIN],
    ];

}
