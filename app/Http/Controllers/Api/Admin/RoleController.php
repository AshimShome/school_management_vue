<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Role\CreateRole;
use App\Actions\Role\UpdateRole;
use App\Actions\Role\DeleteRole;
use App\Actions\Role\UserPermissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roleWithPermissions = Role::where('name','!=','Student')
                ->where('name','!=','Guardian')
                ->with('permissions')
                ->paginate(20);

        if ($roleWithPermissions) {
            return responseSuccess('roles', $roleWithPermissions);
        } else {
            return responseError();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();

        if ($permissions) {
            return responseSuccess('permissions', $permissions);
        } else {
            return responseError();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleFormRequest $request)
    {
        $role = CreateRole::create($request);

        if ($role) {
            return responseSuccess('', '', 'Role Created successfully');
        } else {
            return responseError();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $permissions = Permission::get();

        if ($permissions) {
            return responseSuccess('permissions', $permissions);
        } else {
            return responseError();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role->permissions;

        if ($role) {
            return responseSuccess('role', $role);
        } else {
            return responseError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleFormRequest $request, Role $role)
    {
        $role = UpdateRole::update($request, $role);

        if ($role) {
            return responseSuccess('', '', 'Role Updated successfully');
        } else {
            return responseError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role = DeleteRole::delete($role);

        if ($role) {
            return responseSuccess('', '', 'Role Deleted successfully');
        } else {
            return responseError();
        }
    }

    public function getRoleWisePermissions()
    {
        $userPermissions =  UserPermissions::fetch();

        if ($userPermissions) {
            return responseSuccess('roleWisePermissions', $userPermissions);
        } else {
            return responseError();
        }
    }

    public function rolesList()
    {
        return response()->json(Role::all(['id', 'name']));
    }
}
