<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class notification extends Controller
{
    public function index()
    {
    	return view('notification',[
    		'title' => "Notification"
    	]);
    }
}
