<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Customer extends Controller
{
    public function home(){
        return view('customer.home');
    }
}
