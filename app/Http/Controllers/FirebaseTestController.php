<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseTestController extends Controller
{
    public function tests()
    {
        return view('sample/realtimecrud');
    }
}
