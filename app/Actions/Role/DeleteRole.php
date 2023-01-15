<?php

namespace App\Actions\Role;

class DeleteRole
{
    public static function delete($role)
    {
        $role->delete();

        return true;
    }
}
