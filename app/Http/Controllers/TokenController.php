<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Models\User;

class TokenController extends Controller
{
    public function geraToken(Request $request)
    {
        $this->validate($request, [
            'cpf' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('cpf',$request->cpf)->first();
        $teste = Hash::make($user->password);
        if(is_null($user) || !Hash::check($request->password, $teste))
            return response()->json(['usuário e/ou senha inválido'], 500);

        return [
            'acess_token' => JWT::encode([
                    'cpf' => $request->cpf,
                    'profileId'=>$user->profileId
                ],env('JWT_KEY'))
        ];
    }
}
