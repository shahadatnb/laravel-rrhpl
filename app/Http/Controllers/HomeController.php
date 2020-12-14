<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LabTransaction;
use App\LabInvoice;
use App\LabItem;
use DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard');
    }
    public function lab()
    {
        $report = LabTransaction::orderBy('expiryDate')->where('iType','buy')->where('exp',0)
        ->where('expiryDate','<',date('Y-m-d', strtotime('+15 days')))->get();
        return view('lab.index')->withReport($report);
    }

    public function exp($id){
        $post=LabTransaction::find($id);
        $post->exp=1;
        $post->save();
        return redirect()->route('lab.lab');
    }
}
