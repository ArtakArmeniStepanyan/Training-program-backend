<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{

    public function registration(Request $request)
    {

        if ($request->file('image')) {
            $path = $request->file('image')->store('profileImg', 'public');
        } else
            $path = null;

        $newUser = User::insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $path,
        ]);

        if ($newUser) {
            return response()->json([
                'status' => 'ok',
                'message' => 'New user created'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function checkOriginEmail($email)
    {
        $userWithSameEmail = User::where('email', $email)->first();

        if ($userWithSameEmail === null) {
            return response()->json([
                'status' => 'ok',
                'message' => 'email is available'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'email is not available'
            ]);
        }

    }

    public function checkOriginEmailWithRegisteredUser(Request $request)
    {
        $userWithSameEmail = User::where('email', $request->email)->first();

        if ($userWithSameEmail->id === $request->userId) {
            return response()->json([
                'status' => 'ok',
                'message' => 'email is available'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'email is not available'
            ]);
        }
    }

    public function editProfile(Request $request)
    {

        if ($request->file('image')) {
            $path = $request->file('image')->store('profileImg', 'public');

            $editedUser = User::where('id', $request->userId)->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'image' => $path,
            ]);
        } else {
            $editedUser = User::where('id', $request->userId)->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
            ]);
        }

        $user = User::where('id', $request->userId)->first();

        if ($editedUser) {
            return response()->json([
                'status' => 'ok',
                'message' => 'User edited',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function editPass(Request $request)
    {
        $user = User::where('id', $request->userId)->first();

        if (Hash::check($request->oldPassword, $user->password)) {
            User::where('id', $request->userId)->update([
                'password' => bcrypt($request->newPassword),
            ]);
            return response()->json([
                'status' => 'ok',
                'message' => 'Password changed successfully'
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Old password is wrong'
            ]);
        }
    }

    public function removeImage($id)
    {
        $imageRemovedUser = User::where('id', $id)->update([
            'image' => '',
        ]);
        $user = User::where('id', $id)->first();

        if ($imageRemovedUser) {
            return response()->json([
                'status' => 'ok',
                'message' => 'Image removed successfully',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Image is not removed'
            ]);
        }

    }


    public function getAllUsers($id)
    {
        if($id)
            $users = User::where('id', '!=', $id)->get();
        else
            $users = User::all();

        if ($users) {
            return response()->json([
                'status' => 'ok',
                'users' => $users
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function getAllUsersForGuest()
    {
        $users = User::all();

        if ($users) {
            return response()->json([
                'status' => 'ok',
                'users' => $users
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }


    public function getUser($id)
    {
        $user = User::where('id', $id)->first();

        if ($user) {
            return response()->json([
                'status' => 'ok',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
    }
}
