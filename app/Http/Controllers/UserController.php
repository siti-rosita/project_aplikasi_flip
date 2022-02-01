<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $input = $request->all();
        $validationRules = [
            'id' => 'required',
            'nama_lengkap' => 'required',
            'no_tlpon' => 'required',
            'email' => 'required',
            'password' => 'required'
        ];

        $validator =\validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($input);
        return response()->json($user, 200);
    }
}
