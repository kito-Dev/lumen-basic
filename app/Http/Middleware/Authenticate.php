<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class Authenticate
{
    public function handle(Request $request, \Closure $next)
    {
        try{

            if (!$request->hasHeader('Authorization'))
                throw new \Exception();

            $authHeader = $request->header('Authorization');
            $token = str_replace('Bearer ','',$authHeader);
            $dados = JWT::decode($token,env('JWT_KEY'),['HS256']);
            $user = User::where('cpf', $dados->cpf)->first();

            if(is_null($user))
                throw new \Exception();

            return $next($request);
        }catch(\Exception $e)
        {
            return response()->json('Não autorizado', 401);
        }
    }
}
