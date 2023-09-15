<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

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

public function generatePdfFromUrl()
{
    $url = 'https://www.example.com'; // Replace with the URL you want to convert to PDF

    $pdf = PDF::loadFile($url);

    return $pdf->download('output.pdf');
}

    public function index()
    {
        return view('home');
    }
    public function admin(){
        return view('admin');
    }
    public function SuperManager(){
        return view('SuperManager');
    }
}
