<?php

namespace App\Modules\ExamplePlugin\Controllers;

use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Hello from Example Plugin!',
            'status' => 'active'
        ]);
    }
}
