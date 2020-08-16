<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterUser;
use Hash;
use Auth;
class RegisterController extends Controller
{
    public function register(Request $request){
            $data = request()->validate(
            [
                'fname' => 'required',
                'lname' => 'required',
                'address' => 'required',
                'bday' => 'required',
                'contact' => 'required',
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'fname.required' => 'Fill first name field',
                'lname.required' => 'Fill last name field',
                'address.required' => 'Fill address field',
                'bday.required' => 'Fill birthday field',
                'contact.required' => 'Fill contact field',
                'username.required' => 'Fill username field',
                'password.required' => 'Fill password field',
            ]
        );
        $data['password'] = Hash::make($request->password);
        TwitterUser::create($data);
        return redirect('/')->with('flash',"Welcome Twitter.");
    }
    public function login(Request $request){
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if(Auth::guard('twitterUser')->attempt($credentials)){
            return redirect('home');
        }
        else{
            return redirect('/')->with('red','Invalid Username and Password Combination.');
        }
    }
}
