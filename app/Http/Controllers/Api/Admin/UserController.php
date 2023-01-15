<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Traits\Settings;
use Illuminate\Http\Request;
use App\Actions\User\PasswordUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;

class UserController extends Controller
{
    use Settings;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->where('role', 'admin')->with('roles')->paginate(12);

        return responseSuccess('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $data = $request->only('name', 'email', 'password');
        $data['role'] = 'admin';
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole($request->role);

        return responseSuccess('', '', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->roles;
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->roles;

        if ($user) {
            return responseSuccess('user', $user);
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
    public function update(UserFormRequest $request, User $user)
    {
        $data = $request->only('name', 'email', 'password');
        $data['password'] = bcrypt($request->password);
        $user->update($data);

        $user->roles()->detach();
        if ($request->role) {
            $user->assignRole($request->role);
        }

        return responseSuccess('', '', 'User Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
        }

        return responseSuccess('', '', 'User Deleted successfully');
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        switch ($user->role) {
            case 'admin':
                $this->adminProfileUpdate($request, $user);
                break;
            case 'staff':
                $this->staffProfileUpdate($request, $user);
                break;
            case 'student':
                $this->studentProfileUpdate($request, $user);
                break;
            case 'guardian':
                $this->parentProfileUpdate($request, $user);
                break;
        }

        return responseSuccess('', '', 'Profile Updated successfully');
    }

    public function passwordUpdate(Request $request, User $user)
    {
        $this->validate($request, [
            'oldPassword' => 'required',
            'newPassword' => 'required',
        ]);

        $password = PasswordUpdate::update($request, $user);

        if ($password) {
            return responseSuccess('', '', 'Password Updated successfully');
        } else {
            return responseError("Your current password does'nt match of our records", 200);
        }
    }

    public function details()
    {
        $user = auth()->user();
        switch ($user->original_role) {
            case 'Student':
                $user->load(['student' => function ($query) {
                    $query->with(['classs:id,name', 'section:id,name', 'guardian' => function ($q) {
                        $q->select('id', 'user_id', 'phone', 'occupation')->with('user:id,name');
                    }]);
                }]);
                break;
            case 'Guardian':
                $user->load('guardian');
                break;
            case 'Teacher':
                $user->load('teacher');
                break;
        }

        return $user;
    }

    public function getAuthUserDetails()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return auth()->user();
                break;
            case 'staff':
                return auth()->user()->original_role != 'Accountant' ? auth()->user()->staff->load('user', 'department:id,name') : auth()->user()->staff->load('user');
                break;
            case 'student':
                return auth()->user()->student->load('user', 'section:id,name', 'classs:id,name', 'guardian.user');
                break;
            case 'guardian':
                return auth()->user()->guardian->load('user');
                break;
        }
    }
}
