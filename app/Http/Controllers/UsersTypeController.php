<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);

        Users::create([
            'username' => $request->username,
        ]);
    }
}
