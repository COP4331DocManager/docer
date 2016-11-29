<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\UserService;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class UserController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->service = app(UserService::class);
    }

     public function index()
    {
        return '';
    }

    public function createUser(Request $request)
    {
        $userinfo = $request->only('name', 'email', 'password');
        
        $validator = Validator::make($userinfo, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
        
        //validate input
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        
        app(UserService::class)->createUser($userinfo);
        
        return response()->json(["message"=>"User created successfully!"]);
    }

    public function readUser(Request $request = null)
    {
        $isAdmin = DB::table('users')->where('id', Auth::id())->value('isAdmin');
        if($isAdmin != True && $request['id'] !=Auth::id()) {
            return response()->json("Error: User is not Authorized", 403);
        }

        $user = app(UserService::class)->readUser($request["id"]);

        //dump($user);

        return $user;
    }

    public function updateUser(Request $request)
    {
        $isAdmin = DB::table('users')->where('id', Auth::id())->value('isAdmin');
        if($isAdmin != True && $request['id'] != Auth::id()) {
            return response()->json("Error: User is not Authorized", 403);
        }

        try
        {
            app(UserService::class)->updateUser($request["id"], $request["name"], $request["email"]);
        }
        catch(\Exception $e)
        {
            return response()->json("error", 422);
        }
        
        return response()->json(["message"=>"User updated successfully!"]);
    }

    public function destroyUser(Request $request)
    {
        $isAdmin = DB::table('users')->where('id', Auth::id())->value('isAdmin');
        if($isAdmin != True) {
            return response()->json("Error: User is not Authorized", 403);
        }

        app(UserService::class)->destroyUser($request["id"]);
        return response()->json(["message"=>"User destroy successfully!"]);
    }

}
