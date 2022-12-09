<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function getFriends($id){
        $friends = Friends::where('userId', $id)->with("user")->get();


        return response()->json([
                'status' => 'ok',
                'friends' => $friends,
          ]);

    }

    public function addToFriend(Request $request){
        $newFriend = Friends::insert([
            'userId' => $request->userId,
            'friendId' => $request->friendId,
        ]);

        if ($newFriend) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Friend added'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function removeFromFriend(Request $request){
        $removableFriend = Friends::where([
            ['userId', $request->userId],
            ['friendId', $request->friendId]
        ])->orWhere([
            ['friendId', $request->userId],
            ['userId', $request->friendId]
        ])->delete();

        if ($removableFriend) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Friend removed'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function isFriend(Request $request){
        $isFriend = Friends::where([
            ['userId', $request->userId],
            ['friendId', $request->friendId]
        ])->orWhere([
            ['friendId', $request->userId],
            ['userId', $request->friendId]
        ])->get();

        if ($isFriend) {
            if(count($isFriend) > 0){
                return response()->json([
                    'status' => 'ok',
                    'isFriend' => true
                ]);
            }else{
                return response()->json([
                    'status' => 'ok',
                    'isFriend' => false
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }
}
