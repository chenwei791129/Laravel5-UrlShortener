<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shorturl;
use Auth;

class ApiController extends Controller
{
    public function createshort(Request $req)
    {
        $response = new \stdClass;
        if(filter_var($req->original_url, FILTER_VALIDATE_URL))
        {
            $short_code = $this->_get_unique_short($req->original_url);            
            $result = Shorturl::create([
                'original_url' => $req->original_url,
                'short_code' => $short_code,
                'remark' => '備註~!',
                'created_by' => Auth::user()->id,
            ]);
            $response->Status = 'success';
            $response->Original_url = $req->original_url;
            $response->Short_code = $short_code;
            $response->result = $result;
            $response->user = Auth::user();
        } else {
            $response->Status = 'failure';
            $response->Error_msg = 'url format error';
        }
        return json_encode($response);
    }
    
    private function _get_unique_short($url)
    {
        $short_code = dwz($url);
        if(Shorturl::where('short_code', $short_code)->count() > 0) return $this->_get_unique_short($url.str_random(40));
        return $short_code;
    }
}
