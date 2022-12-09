<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class LogController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if($user === null){
            return response()->json([
                'status' => 'error',
                'message' => 'Email or password is wrong'
            ]);
        }else{
            if (Hash::check($request->input('password'), $user->password)) {
                if (Token::where('userId', $user->id)->exists())
                    Token::where('userId', $user->id)->first()->delete();

                $token = Str::random(30);
                Token::insert([
                    'userId' => $user->id,
                    'token' => $token,
                ]);

                return response()->json([
                    'status' => 'ok',
                    'user' => $user,
                    'token' => $token,
                    'message' => 'You successfully logged in'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email or password is wrong'
                ]);
            }
        }
    }


    public function getUser($token)
    {
        if (strlen($token) > 4) {
            $userToken = Token::where('token', $token)->first();
            $userId = $userToken->userId;

            $user = User::where('id', $userId)->first();

            if ($user) {
                return response()->json([
                    'status' => 'ok',
                    'user' => $user,
                    'token' => $token,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not loged in'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not loged in'
            ]);
        }
    }

    public function logout($id)
    {
        $deletedToken = Token::where('userId', $id)->first()->delete();

        if ($deletedToken) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Token deleted'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is not deleted'
            ]);
        }

    }

}