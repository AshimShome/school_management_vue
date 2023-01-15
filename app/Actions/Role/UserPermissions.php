<?php

namespace App\Actions\Role;

class UserPermissions
{
    public static function fetch()
    {
        $authUser = auth()->user();
        $role = $authUser->roles[0];
        $permissions = $role->permissions()->get(['name', 'id']);

        return $permissions;
    }
}
