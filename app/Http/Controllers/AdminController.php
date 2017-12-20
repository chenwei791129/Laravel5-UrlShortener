<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shorturl;
use Laravel\Passport\Passport;
use Auth;

class AdminController extends Controller
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
    // get admin
    public function home()
    {
        return view('home');
    }
    // get urlmanage
    public function urlmanage()
    {
        $shrots = Shorturl::orderby('id', 'desc')->get();
        $accessToken = Auth::user()->createToken('')->accessToken;
        return view('urlmanage', compact('accessToken', 'shrots'));
    }
    // post addurl
    public function createurl()
    {
        # code...
    }
    public function urlreport()
    {
        return view('urlreport');
    }
}
