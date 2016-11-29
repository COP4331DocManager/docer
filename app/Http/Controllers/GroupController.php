<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

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
        if($this->service->isMember($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
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
        if($this->service->isMember($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
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
        if($this->service->isMember($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
        }

        $groupDocuments = $this->service->getGroupDocuments($req['group_id']);

        return $groupDocuments;
    }

    public function addMember(Request $request)
    {
        $req = $request->only('group_id', 'user');
        $validator = Validator::make($req, [
            'group_id' => 'required|integer',
            'user' => 'required|string'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($this->service->isGroupAdmin($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
        }

        return $this->service->addMember($req['group_id'], $req['user']);
    }

    public function deleteMember(Request $request)
    {
        $input = $request->input();
        if(isset($request->input()['self'])){
            $input['user_id'] = Auth::id();
            $req = $request->only('group_id');
            $validator = Validator::make($req, [
                'group_id' => 'required|integer'
            ]);
        }
        else {
            $req = $request->only('group_id', 'user_id');
            $validator = Validator::make($req, [
                'group_id' => 'required|integer',
                'user_id' => 'required|integer'
            ]);
        }

        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($this->service->isGroupAdmin($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
        };
        dump($input);
        return $this->service->deleteMember($input['group_id'], $input['user_id']);
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
        if($this->service->isGroupAdmin($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
        }

       return $this->service->updateGroupAdmins($req['group_id'], $req['admins']);
    }

    public function destroyGroup(Request $request)
    {
        $req = $request->only('group_id');
        $validator = Validator::make($req, [
            'admins' => 'require',
            'group_id' => 'required|integer'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($this->service->isGroupAdmin($req['group_id']) != True) {
            return response()->json('Error: User is not authorized', 403);
        }
        $this->service->destroyGroup($req['group_id']);
        return response()->json('Group Destroyed');
    }

}
