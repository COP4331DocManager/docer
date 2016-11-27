<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Validator;

class GroupController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->service = app(GroupService::class);
    }

    public function createGroup(Request $request)
    {
        return $this->service->createGroup($request->input('name'));
    }

    public function readGroup(Request $request)
    {
        $req = $request->only('group_id');
        $validator = Validator::make($req, [
            'group_id' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        return response()->json($this->service->readGroup($req['group_id']));
    }

    public function getGroupMembers(Request $request = null)
    {
        $req = $request->only('group_id');
        $validator = Validator::make($req, [
            'group_id' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $groupMember = app(GroupService::class)->getGroupMembers($req['group_id']);

        return $groupMember;
    }

    public function getGroupDocuments(Request $request = null)
    {
        $req = $request->only('group_id');
        $validator = Validator::make($req, [
            'group_id' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $groupDocuments = $this->service->getGroupDocuments($req['group_id']);

        return $groupDocuments;
    }

    public function updateGroup(Request $request)
    {
        $req = $request->only('group_id');
        $validator = Validator::make($req, [
            'group_id' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if(GroupServices::isGroupAdmin($req['group_id']) != 1) {
            return response()->json('Error: User is not an admin of group ' . $req['group_id'], 403);
        }
        $this->service->updateGroup($req['group_id']);
    }

    public function updateGroupAdmins(Request $request)
    {
        $req = $request->only('group_id', 'admins');
        $validator = Validator::make($req, [
            'admins' => 'require',
            'group_id' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
       if(GroupServices::isGroupAdmin($group_id) != 1) {
            return response()->json('Error: User is not an admin of group ' . $group, 403);
       }

       $this->service->updateGroupAdmins($req['group_id'], $req['admins']);
    }

    public function destroyGroup(Request $request)
    {
        if(GroupServices::isGroupAdmin($group_id) != 1) {
            return response()->json('Error: User is not an admin of group ' . $group, 403);
        }
        $this->service->destroyGroup($request->input('group_id'));
    }

}
