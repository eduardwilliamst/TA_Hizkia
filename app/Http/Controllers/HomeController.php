<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosSession;

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
        return view('home');
    }
    
    public function dashboard()
    {
        $id_pos_session = session('pos_session');
        $possession = PosSession::where('idpos_session', $id_pos_session)->get();
        // dd($possession);
        return view('dashboard');
    }
    
    public function store(Request $request)
    {
        $id_pos_session = session('pos_session');
        $possession = PosSession::where('idpos_session', $id_pos_session)->get();
        // dd($possession);
        return view('dashboard');
    }
}
