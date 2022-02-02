<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
           'nama_lengkap'=> 'required|string',
           'email'=>'required|email|unique:users',
           'password' => 'required|confirmed',
           'no_tlpon'=>'required|string',
        ]);

        $input =$request->all();

        $validationRules = [
            'nama_lengkap'=> 'required|string',
           'email'=>'required|email|unique:users',
           'password' => 'required|confirmed',
           'no_tlpon'=>'required|string',
        ];

        $validator = \validator::make($input, $validationRules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User;
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->email = $request->input('email');
        $plainPassword = $request->input('password');
        $user->password = app('hash')->make($plainPassword);
        $user->no_tlpon = $request->input('no_tlpon');
        $user->save();

        return response()->json($user, 200);
    }
}
