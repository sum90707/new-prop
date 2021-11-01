<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $teachers = User::where('auth', '=', 'teacher')
        //                 ->where('status', '=', 1)
        //                 ->get();
        $teachers = [];
        return view('home', compact('teachers'));
    }
}
