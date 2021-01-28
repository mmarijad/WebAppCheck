<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\App;
use App\Admin;
use App\Check;

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
    
    }

    public function store(Request $request)
	{ 
       
	}

}
