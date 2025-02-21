<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Platform;

class PlatformController extends Controller
{

    public function index()
    {
        return response()->json(Platform::query()->paginate(10));

    }

    public function show(string $id)
    {

        $platform = Platform::query()->find($id);
        if (!$platform) {
            return response()->json(['error' => 'Platform not found'], 404);
        }
        return response()->json($platform);
    }
}
