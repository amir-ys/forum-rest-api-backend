<?php


namespace App\Models;


class Permission extends \Spatie\Permission\Models\Permission
{
    const PERMISSION_SUPER_ADMIN = 'super admin';
    const PERMISSION_USER = 'user';
    const PERMISSION_MANAGE_CHANNELS = 'manage channels';
    const PERMISSION_MANAGE_THREADS = 'manage threads';
    const PERMISSION_MANAGE_ANSWERS = 'manage answers';
    const PERMISSION_MANAGE_SUBSCRIBES = 'manage subscribe';
    const PERMISSION_MANAGE_ROLE_PERMISSIONS = 'manage role_permissions';

    static $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_USER,
        self::PERMISSION_MANAGE_THREADS,
        self::PERMISSION_MANAGE_SUBSCRIBES,
        self::PERMISSION_MANAGE_ROLE_PERMISSIONS,
        self::PERMISSION_MANAGE_CHANNELS,
        self::PERMISSION_MANAGE_ANSWERS,
    ];

}
