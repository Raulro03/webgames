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
        return response()->json(Platform::query()->find($id));
    }
}
