<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Hash;

class PasswordUpdate
{
    public static function update($request, $user)
    {
        $password_check = Hash::check($request->oldPassword,$user->password);

        if ($password_check) {
            $user->update([ 'password' => bcrypt($request->newPassword) ]);
            return true;
        }else{
            return false;
        }
    }
}
