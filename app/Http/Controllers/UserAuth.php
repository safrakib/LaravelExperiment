<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\UserRegistration;
use App\Models\User;

class UserAuth extends Controller
{
    function registration(){
        return view('registration');
    }

    function store(Request $request){
        $data=new User();
        $data->name=$request->name;
        $data->email=$request->email;
        $data->password=$request->password;
        $data->save();
        $data->notify(new UserRegistration($data));
        return 'success';
    }
}
