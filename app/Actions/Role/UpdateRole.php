<?php

namespace App\Actions\Role;

use Spatie\Permission\Models\Role;

class UpdateRole
{
    public static function update($request, $role)
    {
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permission);

        return true;
    }
}
