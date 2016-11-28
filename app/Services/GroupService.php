<?php

namespace App\Services;

use App\Document;
use App\Group;
use App\User;
use Illuminate\Support\Facades\Auth;
#use Auth;
use Illuminate\Support\Facades\DB;
use App\Services\DocumentService;

class GroupService
{

    public function createGroup($name)
    {
        $group = Group::create([
            'name' => $name,
            'created_by' => 3
        ]);

        $group->save();

        DB::table('groups')->where('id', $group->id)
            ->update(['created_by' => Auth::id()]);

        DB::table('users_groups')->insert([
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'is_admin' => True
        ]);

        return response()->json(GroupService::readGroup($group->id));
    }

    public function readGroup($group_id)
    {
        $group = DB::table('groups')
            ->where('groups.id', $group_id)
            ->first(['id', 'name']);
        
        $group->members = GroupService::getGroupMembers($group->id);

        return $group;
    }

    public function updateGroup($group_id)
    {
        //
    }

    public function getGroupMembers($group_id)
    {
		$users = DB::table('users_groups')
                ->join('users', 'users.id', '=', 'users_groups.user_id')
                ->where('users_groups.group_id', '=', $group_id)
                ->select('users.id', 'users.name', 'users_groups.is_admin')
                ->get();

        return $users;
    }

    public function getGroupDocuments($group_id)
    {
        $documents = [];

        $documentsGroup = DB::table('documents_groups')->where('group_id', '=', $group_id)->get();

        foreach($documentsGroup as $document)
        {
            $documents [] = Document::find($document->document_id);
        }

        return $documents;
    }

    public function isGroupAdmin($group_id)
    {
        $sysAdmin = DB::table('users')->where([['id', Auth::id()],['isAdmin', True]])->count();
        $admin = DB::table('users_groups')
            ->where([['users_groups.group_id', $group_id],
                ['users_groups.user_id', Auth::id()],
                ['users_groups.is_admin', True]])
                ->count();
        return ($sysAdmin + $admin) > 0;
    }

     public function isMember($group_id)
    {
        $sysAdmin = DB::table('users')->where([['id', Auth::id()],['isAdmin', True]])->count();

        $admin = DB::table('users_groups')
            ->where([['users_groups.group_id', $group_id],
                     ['users_groups.user_id', Auth::id()]])
            ->count();
        return ($sysAdmin + $admin) > 0;
    }

    public function updateGroupAdmins($group_id, $admins)
    {
        if(GroupServices::isGroupAdmin($group_id) != True) {
            return response()->json('Error: User is not an admin of group ' . $group, 403);
        }
        DB::table('users_groups')
            ->where('users_groups.group_id', $group_id)
            ->whereNotIn('users_groups.user_id', $admins)
            ->update(['is_admin' => False]);

        DB::table('users_groups')
			->where('users_groups.group_id', $group_id)
            ->whereIn('users_groups.user_id', $admins)
            ->update(['is_admin' => True]);

        return response()->json(GroupServices::readGroup($group_id));
    }

    public function destroyGroup($group_id)
    {
        $Doc = app(DocumentService::class);
        $IDs = DB::table('documents')->where('group_id', $group_id)->select('id')->get();
        foreach($IDs as $ID) {
            $Doc->DestroyDocument($ID->id);
        }
        DB::table('users_groups')->where('group_id', $group_id)->delete();
        DB::table('groups')->where('id', $group_id)->delete();
    }

}
