<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Shorturl;
use Agent;
use App\Click;

class UrlShortController extends Controller
{
    public function goUrl($shortcode)
    {
        $item = Shorturl::where('short_code', $shortcode)->first();
        if(empty($item)) return response()->view('errors.HTTP404', array(), 404);
        Click::create([
            'short_code' => $shortcode,
            'isRobot' => Agent::isRobot(),
            'isDesktop' => Agent::isDesktop(),
            'platform' => Agent::platform(),
            'platform_version' => Agent::version(Agent::platform()),
            'browser' => Agent::browser(),
            'browser_version' => Agent::version(Agent::browser()),
            'client_ip_addrs' => json_encode(getClientIp()),
            'country_from' => $this->getCountry()
        ]);

        return redirect(Shorturl::where('short_code', $shortcode)->first()->original_url);
    }
    private function getCountry($ip = null)
    {
        if(empty($ip)) $ip = getClientIp()['REMOTE_ADDR'];
        if($ip == '127.0.0.1' || $ip == '::1') return 'localhost';
        $sql = '
        SELECT 
            c.country 
        FROM 
            ip2nationCountries c,
            ip2nation i 
        WHERE 
            i.ip < "'.ip2long($ip).'"
            AND 
            c.code = i.country 
        ORDER BY 
            i.ip DESC 
        LIMIT 0,1';

        return collect(DB::select(DB::raw($sql)))->first()->country;
    }
}
