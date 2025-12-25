<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

public function myAccount()
    {
          $orders = auth()->user()->orders()->latest()->get();
        return view('my-account',compact('orders'));
    }

}
