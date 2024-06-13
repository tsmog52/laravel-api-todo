<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function health()
    {
        return response()->json([
            'status' => 'success'
        ]);
    }
}
