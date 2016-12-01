<?php

namespace App\Services;

use App\User;
use DB;

class UserService
{

    public function createUser($userinfo)
    {
        //create user
        User::create([
            'name' => $userinfo['name'],
            'email' => $userinfo['email'],
            'password' => bcrypt($userinfo['password']),
        ]);
    }

    public function updateUser($user_id, $name, $email)
    {
        $user = User::findOrFail($user_id);
        $user->name = $name;
        $user->email = $email;
        $user->save();
    }
    
    public function updatePassword($user_id, $pass)
    {
        $user = User::findOrFail($user_id);
        $user->password = bcrypt($pass);
        $user->save();
    }

    public function readUser($user_id)
    {
//        Example of the same effect but using a where condition instead of the find function (find only works for id's)
//        $user = DB::table('users')->where('id', '=', $user_id)->first();

        $user = User::find($user_id);

        // This gets the groups relationship and puts it in the user model.
        if(!is_null($user))
        {
            $user->relations = $user->groups;
        }

        // to get the user's groups, use $user->groups

        return $user;

    }

    public function destroyUser($user_id)
    {
        DB::table('users_groups')->where('user_id', $user_id)->delete();
        DB::table('users')->where('id', $user_id)->delete();
    }

    public function getUserDocuments($user_id)
    {

    }
}
