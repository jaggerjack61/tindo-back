<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Message;
use App\Models\Painting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
    public function showAllPaintings()
    {
        $results = Painting::where('status','!=', 'deleted')->where('status','!=', 'hidden')->orderBy('created_at', 'desc')->get();
        return response()->json($results);
    }

    public function saveMessage(Request $request)
    {
        try{
            Message::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'content' => $request->message

            ]);
            return response()->json(['message' => 'success']);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()]);
    }

    }

    public function register(RegisterRequest $request)
    {
//        return response()->json($request);
        try{
            User::create([
                'name' =>$request->name,
                'email' =>$request->email,
                'password' =>hash::make($request->password)
            ]);
            return response()->json(['message' =>'success']);
        }
        catch (\Exception $e){
            return response()->json(['message' =>'failed']);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            auth()->user()->tokens()->delete();
            $token = $request->user()->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token,'user'=>auth()->user(),'message' =>'success']);
        }

        return response()->json(['message' => 'unauthorized'], 401);

    }

    public function logout()
    {

    }

    public function getUser()
    {
        if(auth()){
            return response()->json(['message' => 'success', 'user' => auth()->user()]);
        }
        else{
            return response()->json(['message' =>'unauthenticated']);
        }
    }
}
