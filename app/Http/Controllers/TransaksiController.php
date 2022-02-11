<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function transfer(Request $request)
    {
    	$input = $request->all();
       
            $validationRules = [
                'nomor_rekening' => 'required',
                'nominal' => 'required',
                'nomor_rekening_tujuan' => 'required'
            ];
            	
				$validator =\validator::make($input, $validationRules);

        		if ($validator->fails()) {
           		 return response()->json($validator->errors(), 400);
        			}

       				 $user = User::create($input);
        		return response()->json($post, 200);

}
}