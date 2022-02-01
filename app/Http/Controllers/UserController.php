<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "users",
            "results" => $users
        ];
        return response()->json($users, 200);
    }
}
