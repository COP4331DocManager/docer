<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\DocumentService;
use App\Services\GroupService;
use JWTAuth;
#use Tymon\JWTAuth\Exceptions\JWTException;
#use App\User;
use Validator;
#use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    protected $service;
    protected $groups;

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate/register method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        #$this->middleware('jwt.auth', ['except' => ['authenticate', 'register']]);
        $this->middleware('jwt.auth');
        $this->service = app(DocumentService::class);
        $this->groups = app(GroupService::class);
    }

    public function upload(Request $request)
    {
        $req = $request->only('user_upload', 'group', 'filename', 'metaTags');
        $validator = Validator::make($req, [
            'user_upload' => 'required|file',
            'group' => 'required|integer',
            'metaTags' => 'present|json'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($this->groups->isMember($req['group']) != True) {
            return response()->json('Error: User is not a member of group ' . $req['group'], 403);
        }

        return $this->service->createDocument(
            $req['user_upload'],
            $req['group'],
            json_decode($req['metaTags']));
    }

    public function delete(Request $request, $id)
    {
        if($this->service->hasDocAccess($id, True) != True) {
            return response()->json("Error: User is not authorized", 403);
        }
        return $this->service->destroyDocument($id);
    }

    public function view(Request $request, $id)
    {
        if($this->service->hasDocAccess($id) != True) {
            return response()->json("Error: User is not authorized", 403);
        }

        return $this->service->readDocument(
            $id,
            $request->user());
    }

    public function info(Request $request, $id)
    {
        if($this->service->hasDocAccess($id) != True) {
            return response()->json("Error: User is not authorized", 403);
        }

        return $this->service->getDocuments([$id]);
    }

    public function search(Request $request)
    {
        return $this->service->searchDocument(
            $request->input('str'), 
            $request->user());
    }

    public function update(Request $request, $id)
    {
        $req = $request->only('metaTags');
        $validator = Validator::make($req, [
            'metaTags' => 'required|json'
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        if($this->service->hasDocAccess($id) != True) {
            return response()->json("Error: User is not authorized", 403);
        }

        return $this->service->updateDocument(
            $id,
            json_decode($req['metaTags']));
    }
}
