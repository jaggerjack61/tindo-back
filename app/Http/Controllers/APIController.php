<?php

namespace App\Http\Controllers;

use App\Models\Painting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function showAllPaintings()
    {
        $results = Painting::where('status', 'available')->get();
        return response()->json($results);
    }
}
