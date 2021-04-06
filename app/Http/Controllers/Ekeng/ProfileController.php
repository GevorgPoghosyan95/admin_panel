<?php

namespace App\Http\Controllers\Ekeng;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('profile.index',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $user->update($request->only(['first_name','last_name']));
        return redirect()->back()->with('success','User updated successfully');
    }

    public function change(User $user,ChangePasswordRequest $request){
        if(Hash::check($request->get('current_password'),$user->password)){
            $user->password = $request->get('password');
            $user->save();
            return redirect()->back()->with('success','Password changed successfully');
        }else{
            return redirect()->back()->withErrors('Password incorrect!');
        }
    }
}
