<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        return response()->json();
    }
}
