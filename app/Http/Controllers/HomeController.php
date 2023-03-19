<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',[
            'title' => "Dashboard"
        ]);
    }

    public function notif()
    {
        $notifall = notif::lastest('created_at')->limit(5)->get();
        $notifunreadcount = notif::where('status','unread')->count('id');
        $notifunread = notif::where('status','unread')->limit(5)->get();
    }

    
}
