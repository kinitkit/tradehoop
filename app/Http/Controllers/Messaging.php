<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class Messaging extends Controller
{
    public function messaging(){
        return view('admin.messagingInbox');
    }

    public function messagingNew(){
        return view('admin.messagingNew');
    }

}


