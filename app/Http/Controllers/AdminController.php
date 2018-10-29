<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserData\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index',compact('users'));
    }

    public function addUser(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }

    public function viewUser()
    {
        $users = User::all();
        return view('admin.view_user', compact('users'));
    }
}
