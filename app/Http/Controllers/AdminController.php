<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shorturl;
use Laravel\Passport\Passport;
use Auth;
use Carbon\Carbon;
use App\Click;

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
        $accessToken = Auth::user()->createToken('')->accessToken;
        return view('home', compact('accessToken'));
    }
    // get urlmanage
    public function urlmanage()
    {
        $shrots = Shorturl::orderby('id', 'desc')->paginate(20);
        $accessToken = Auth::user()->createToken('')->accessToken;
        foreach ($shrots as $shrot) {
            $shrot->day_click = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->subday(1))->count();
            $shrot->week_click = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->subday(7))->count();
            $shrot->month_click = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->submonth(1))->count();
        }
        return view('urlmanage', compact('accessToken', 'shrots'));
    }
    public function urlreport($shortcode)
    {
        $accessToken = Auth::user()->createToken('')->accessToken;
        $shrot = Shorturl::where('short_code', $shortcode)->first();
        $shrot->total_click = $shrot->clicks()->count();
        $shrot->day_click = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->subday(1))->count();
        $shrot->week_click = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->subday(7))->count();
        $shrot->month_click = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->submonth(1))->count();
        $shrot->day_of_clicks = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->submonth(1))->get();
        return view('urlreport', compact('shrot', 'accessToken'));
    }
}
