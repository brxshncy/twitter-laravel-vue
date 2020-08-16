<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterUser;
class UserController extends Controller
{
    public function showUsers($id){
        $users = TwitterUser::whereNotin('id',[$id])->get();
        return $users;
    }
}
