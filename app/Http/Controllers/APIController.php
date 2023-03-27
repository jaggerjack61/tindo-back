<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Painting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
