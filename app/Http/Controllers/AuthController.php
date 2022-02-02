<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request  $request)
    {
        $input = $request->all();
        
        $validationRules =[
            'email' => 'required|string',
            'password' => 'required|string',
        ];
        $validator =\validator::make($input, $validationRules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 400);
        }
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL()* 60
        ], 200);
    }
}
