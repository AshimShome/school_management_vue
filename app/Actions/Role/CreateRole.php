<?php

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

class CreateRole
{
    public static function create($request)
    {
        $role = Role::create(['guard_name' => 'api','name' => $request->name]);
        $role->syncPermissions($request->permission);

        return true;
    }
}
