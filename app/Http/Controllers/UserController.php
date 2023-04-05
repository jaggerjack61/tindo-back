<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showUsers()
    {
        $results = User::paginate(30);
        return view('pages.users',compact('results'));
    }

    public function newUser(RegisterRequest $request)
    {
        try{
            User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => hash::make($request->password)
            ]);
            return back()->with('success', $request->name.' account has been created');
        }
        catch (\Exception $e){
            return back()->with('error','There was an error creating the account. Please make sure the email address is not already in use.');
        }

    }

    public function activateUser(User $user)
    {
        $user->status = 'active';
        $user->save();
        return back()->with('success',$user->name.' has been activated.');
    }

    public function deactivateUser(User $user)
    {
        $user->status = 'inactive';
        $user->save();
        return back()->with('success',$user->name.' has been deactivated.');
    }

    public function promoteUser(User $user)
    {
        $user->access_level = 'admin';
        $user->save();
        return back()->with('success',$user->name.' has been promoted to admin.');
    }

    public function demoteUser(User $user)
    {
        $user->access_level = 'user';
        $user->save();
        return back()->with('success',$user->name.' has been demmoted to user.');
    }

    public function showProfile()
    {
        return view('auth.profile');
    }

    public function saveProfile(Request $request){
        $user=auth()->user();
        try{
            if($request->pass){
                $user=User::find($user->id);
                $user->update([
                    'name'=>$request->name,
                    'password'=>hash::make($request->pass),
                ]);

                return back()->with('success','Updated profile successfully');
            }
            else{
                $user=User::find($user->id);
                $user->update([
                    'name'=>$request->name,
                ]);
                return back()->with('success','Updated profile successfully');
            }
        }
        catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }


}

