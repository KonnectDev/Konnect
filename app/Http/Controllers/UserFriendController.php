<?php

namespace App\Http\Controllers;

use App\User;
use App\UserFriendRequest;
use App\UserFriendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserFriendController extends Controller
{

    public function add(Request $request)
    {
        if ($this->verifyAuthKey($request['user_id'], $request['auth_key'])) {
            $friendRequest = new UserFriendRequest();
            $friendRequest->user_id = $request['user_id'];
            $friendRequest->friend_id = $request['friend_id'];
            $friendRequest->save();
            return response()->json($friendRequest, 200);

        }
        return 'invalid';
    }

    public function delete(Request $request)
    {
        if ($this->verifyAuthKey($request['user_id'], $request['auth_key'])) {
            $UserFriendship = UserFriendship::where(function ($query) use ($request) {
                $query->where('user_id', '=', $request['user_id'])->where('friend_id', '=', $request['friend_id']);
            })->orWhere(function ($query) use ($request) {
                $query->where('user_id', '=', $request['friend_id'])->where('friend_id', '=', $request['user_id']);
            });
            $UserFriendship->delete();
            return response()->json($UserFriendship, 200);

        }
        return 'invalid';
    }

    public function accept(Request $request)
    {
        if ($this->verifyAuthKey($request['user_id'], $request['auth_key'])) {
            $UserFriendship = new UserFriendship();
            $UserFriendship->user_id = $request['user_id'];
            $UserFriendship->friend_id = $request['friend_id'];
            $UserFriendship->save();
            $this->decline($request);
            return response()->json($UserFriendship, 200);

        }
        return 'invalid';
    }

    public function decline(Request $request)
    {

        if ($this->verifyAuthKey($request['user_id'], $request['auth_key'])) {
            $friendRequest = UserFriendRequest::where(function ($query) use ($request) {
                $query->where('user_id', '=', $request['user_id'])->where('friend_id', '=', $request['friend_id']);
            })->orWhere(function ($query) use ($request) {
                $query->where('user_id', '=', $request['friend_id'])->where('friend_id', '=', $request['user_id']);
            });
            $friendRequest->delete();
            return response()->json($friendRequest, 200);

        }
        return 'invalid';
    }

    public function userFriends(Request $request)
    {
        if ($this->verifyAuthKey($request['user_id'], $request['auth_key'])) {
//            if ($request['show'] == 'online') {
//                return [];
//            } else if ($request['show'] == 'offline') {
//                return [];
//            } else {

                $userFriends = UserFriendship::where('users.id', '!=', $request['user_id'])->where('user_id', '=', $request['user_id'])->orWhere('friend_id', '=', $request['user_id'])

                    ->join('users', function ($join) {
                        $join->on('users.id', '=', 'user_friendships.friend_id')->orOn('users.id', '=', 'user_friendships.user_id');
                    })
                    ->where('users.id', '!=', $request['user_id'])
                    ->get(['users.id', 'users.username', 'users.img_small']);


                return response()->json($userFriends, 200);

            }

       // }
        return 'invalid';

    }
}